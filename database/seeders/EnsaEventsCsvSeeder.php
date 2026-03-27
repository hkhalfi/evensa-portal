<?php

namespace Database\Seeders;

use App\Models\EvEnsa\Events\Event;
use App\Models\EvEnsa\Referentials\Category;
use App\Models\EvEnsa\Referentials\EventType;
use App\Models\EvEnsa\Referentials\Instance;
use App\Models\EvEnsa\Referentials\Venue;
use App\Models\EvEnsa\Requests\EventRequest;
use App\Models\EvEnsa\Requests\EventRequestComment;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class EnsaEventsCsvSeeder extends Seeder
{
    /**
     * Place ton CSV dans:
     * database/data/ensa_events.csv
     *
     * Puis exécute:
     * php artisan db:seed --class=Database\\Seeders\\EnsaEventsCsvSeeder
     */
    public function run(): void
    {
        $csvPath = database_path('data/ensa_events.csv');

        if (! File::exists($csvPath)) {
            $this->command?->error("Fichier introuvable: {$csvPath}");

            return;
        }

        $rows = $this->readCsv($csvPath);

        if (empty($rows)) {
            $this->command?->warn('Le CSV est vide.');

            return;
        }

        $this->seedBaseReferentials();

        foreach ($rows as $row) {
            $title = $this->value($row, "Intitulé de l'événement :");
            $entityName = $this->value($row, "Entité d'attache :");

            if (blank($title) || blank($entityName)) {
                continue;
            }

            $instance = $this->resolveInstance($entityName);
            $eventType = $this->resolveEventType($this->value($row, "Type de l'événement :"));
            $category = $this->resolveCategory($this->value($row, "Domaine d'activité :"));
            [$eventMode, $venue] = $this->resolveVenueAndMode($this->value($row, 'Lieu ou Local  :'));

            $startAt = $this->parseFrenchDate($this->value($row, 'Date de début :'), '09:00');
            $endAt = $this->parseFrenchDate($this->value($row, 'Date de fin :'), '18:00');

            if (! $startAt || ! $endAt) {
                continue;
            }

            if ($endAt->lessThanOrEqualTo($startAt)) {
                $endAt = $startAt->copy()->addHours(8);
            }

            $requestStatus = 'approved';
            $eventStatus = $endAt->isPast() ? 'completed' : 'scheduled';
            $isPublished = true;

            $organizationRequestFile = $this->value($row, "Demande d'organisation addressée au directeur de l'ENSA :");
            $description = $this->buildDescription($row);

            $eventRequest = EventRequest::updateOrCreate(
                [
                    'title' => $title,
                    'instance_id' => $instance->id,
                    'start_at' => $startAt,
                ],
                [
                    'event_type_id' => $eventType->id,
                    'category_id' => $category->id,
                    'venue_id' => $venue?->id,
                    'event_mode' => $eventMode,
                    'end_at' => $endAt,
                    'expected_attendees' => null,
                    'description' => $description,
                    'organization_request_file' => $organizationRequestFile ?: null,
                    'status' => $requestStatus,
                    'submitted_at' => $this->parseFrenchDate($this->value($row, 'Submission Date'), '10:00') ?? $startAt->copy()->subDays(15),
                ]
            );

            EventRequestComment::firstOrCreate(
                [
                    'event_request_id' => $eventRequest->id,
                    'comment_type' => 'decision_note',
                    'comment' => 'Demande importée depuis le fichier historique ENSA et marquée comme approuvée.',
                ],
                [
                    'user_id' => null,
                ]
            );

            Event::updateOrCreate(
                [
                    'event_request_id' => $eventRequest->id,
                ],
                [
                    'title' => $title,
                    'instance_id' => $instance->id,
                    'event_type_id' => $eventType->id,
                    'category_id' => $category->id,
                    'venue_id' => $venue?->id,
                    'event_mode' => $eventMode,
                    'start_at' => $startAt,
                    'end_at' => $endAt,
                    'expected_attendees' => null,
                    'description' => $description,
                    'status' => $eventStatus,
                    'is_published' => $isPublished,
                    'published_at' => $isPublished ? now() : null,
                    'cover_image' => null,
                ]
            );
        }

        $this->command?->info('Import ENSA terminé.');
    }

    protected function readCsv(string $path): array
    {
        $handle = fopen($path, 'r');

        if (! $handle) {
            return [];
        }

        $headers = fgetcsv($handle);
        $rows = [];

        if (! $headers) {
            fclose($handle);

            return [];
        }

        $headers = array_map(fn ($header) => $this->stripBom(trim((string) $header)), $headers);

        while (($data = fgetcsv($handle)) !== false) {
            if (count(array_filter($data, fn ($value) => filled($value))) === 0) {
                continue;
            }

            $row = [];
            foreach ($headers as $index => $header) {
                $row[$header] = isset($data[$index]) ? trim((string) $data[$index]) : null;
            }

            $rows[] = $row;
        }

        fclose($handle);

        return $rows;
    }

    protected function stripBom(string $value): string
    {
        return preg_replace('/^\xEF\xBB\xBF/', '', $value) ?? $value;
    }

    protected function value(array $row, string $key): ?string
    {
        $value = $row[$key] ?? null;

        return filled($value) ? trim((string) $value) : null;
    }

    protected function seedBaseReferentials(): void
    {
        $this->upsertEventType('conference', 'Conférence');
        $this->upsertEventType('workshop', 'Workshop');
        $this->upsertEventType('competition', 'Compétition');
        $this->upsertEventType('programme', 'Programme');
        $this->upsertEventType('forum', 'Forum');
        $this->upsertEventType('table_ronde', 'Table ronde');
        $this->upsertEventType('exposition', 'Exposition');
        $this->upsertEventType('entrainement', 'Entraînement');
        $this->upsertEventType('formation', 'Formation');
        $this->upsertEventType('humanitaire_sanitaire', 'Humanitaire et sanitaire');

        $this->upsertCategory('scientifique', 'Scientifique');
        $this->upsertCategory('culturelle', 'Culturelle');
        $this->upsertCategory('sportive', 'Sportive');
        $this->upsertCategory('artistique', 'Artistique');
        $this->upsertCategory('religieuse', 'Religieuse');
        $this->upsertCategory('sociale', 'Sociale');
        $this->upsertCategory('soft_skills', 'Soft skills');
        $this->upsertCategory('entrepreneuriat', 'Entrepreneuriat');
        $this->upsertCategory('innovation', 'Innovation');
        $this->upsertCategory('benevole', 'Bénévole');
        $this->upsertCategory('autre', 'Autre');

        $this->upsertVenue('campus_ensa', 'Campus ENSA Khouribga', "Au sein des locaux de l'établissement", true);
        $this->upsertVenue('en_ligne', 'En ligne', 'Événement virtuel', false);
        $this->upsertVenue('a_preciser', 'À préciser', 'Lieu non précisé', true);
    }

    protected function resolveInstance(string $name): Instance
    {
        $code = Str::slug($name, '_');

        $instanceType = Str::contains(Str::lower($name), 'département')
            ? 'departement'
            : (Str::contains(Str::lower($name), 'laboratoire') ? 'association' : 'club');

        return Instance::firstOrCreate(
            ['code' => $code],
            [
                'name' => $name,
                'instance_type' => $instanceType,
                'contact_email' => null,
                'contact_phone' => null,
                'description' => 'Import historique ENSA',
                'is_active' => true,
            ]
        );
    }

    protected function resolveEventType(?string $rawValue): EventType
    {
        $value = Str::lower((string) $rawValue);

        $mapping = [
            'conférence' => 'conference',
            'workshop' => 'workshop',
            'compétition' => 'competition',
            'programme' => 'programme',
            'forum' => 'forum',
            'table ronde' => 'table_ronde',
            'exposition' => 'exposition',
            'entrainement' => 'entrainement',
            'formation' => 'formation',
            'humanitaire et sanitaire' => 'humanitaire_sanitaire',
            'projet' => 'programme',
        ];

        foreach ($mapping as $needle => $code) {
            if (Str::contains($value, $needle)) {
                return EventType::where('code', $code)->firstOrFail();
            }
        }

        return EventType::where('code', 'programme')->firstOrFail();
    }

    protected function resolveCategory(?string $rawValue): Category
    {
        $value = Str::lower((string) $rawValue);

        return match (true) {
            Str::contains($value, 'scientifique') => Category::where('code', 'scientifique')->firstOrFail(),
            Str::contains($value, 'culturelle') => Category::where('code', 'culturelle')->firstOrFail(),
            Str::contains($value, 'sport') => Category::where('code', 'sportive')->firstOrFail(),
            Str::contains($value, 'artist') => Category::where('code', 'artistique')->firstOrFail(),
            Str::contains($value, 'relig') => Category::where('code', 'religieuse')->firstOrFail(),
            Str::contains($value, 'social') => Category::where('code', 'sociale')->firstOrFail(),
            Str::contains($value, 'soft skills') => Category::where('code', 'soft_skills')->firstOrFail(),
            Str::contains($value, 'entrepreneuriat') => Category::where('code', 'entrepreneuriat')->firstOrFail(),
            Str::contains($value, 'innovation') => Category::where('code', 'innovation')->firstOrFail(),
            Str::contains($value, 'bénévole') || Str::contains($value, 'benevole') => Category::where('code', 'benevole')->firstOrFail(),
            default => Category::where('code', 'autre')->firstOrFail(),
        };
    }

    protected function resolveVenueAndMode(?string $rawValue): array
    {
        $value = (string) $rawValue;

        if (Str::contains($value, "Au sein des locaux de l'établissement") && Str::contains($value, 'En ligne')) {
            return ['hybrid', Venue::where('code', 'campus_ensa')->first()];
        }

        if (Str::contains($value, "Au sein des locaux de l'établissement")) {
            return ['internal', Venue::where('code', 'campus_ensa')->first()];
        }

        if (Str::contains($value, 'En ligne')) {
            return ['online', Venue::where('code', 'en_ligne')->first()];
        }

        return ['internal', Venue::where('code', 'a_preciser')->first()];
    }

    protected function buildDescription(array $row): string
    {
        $parts = [];

        $summary = $this->value($row, "Thématiques et description de l'événement :");
        $domain = $this->value($row, "Domaine d'activité :");
        $guests = $this->value($row, "Listes des invités de l'événement :");
        $edition = $this->value($row, "Numéro de l'édition :");
        $recurrent = $this->value($row, 'Événement réccurent :');
        $submitter = $this->value($row, 'Nom et Prénom :');
        $email = $this->value($row, 'Email :');
        $phone = $this->value($row, 'Téléphone :');

        if ($summary) {
            $parts[] = $summary;
        }

        if ($domain) {
            $parts[] = "Domaine d'activité: {$domain}";
        }

        if ($recurrent) {
            $parts[] = "Événement récurrent: {$recurrent}";
        }

        if ($edition) {
            $parts[] = "Numéro de l'édition: {$edition}";
        }

        if ($guests) {
            $parts[] = "Invités: {$guests}";
        }

        $contact = collect([$submitter, $email, $phone])->filter()->implode(' | ');
        if ($contact !== '') {
            $parts[] = "Contact source: {$contact}";
        }

        return implode("\n\n", $parts);
    }

    protected function parseFrenchDate(?string $value, string $defaultTime = '09:00'): ?Carbon
    {
        if (blank($value)) {
            return null;
        }

        $normalized = Str::lower(trim((string) $value));

        $months = [
            'janv.' => '01',
            'févr.' => '02',
            'mars' => '03',
            'avr.' => '04',
            'mai' => '05',
            'juin' => '06',
            'juil.' => '07',
            'août' => '08',
            'sept.' => '09',
            'oct.' => '10',
            'nov.' => '11',
            'déc.' => '12',
        ];

        foreach ($months as $fr => $num) {
            $normalized = str_replace($fr, $num, $normalized);
        }

        if (preg_match('/(\d{2})\s+(\d{1,2}),\s+(\d{4})/', $normalized, $matches)) {
            $month = $matches[1];
            $day = str_pad($matches[2], 2, '0', STR_PAD_LEFT);
            $year = $matches[3];

            return Carbon::createFromFormat('Y-m-d H:i', "{$year}-{$month}-{$day} {$defaultTime}");
        }

        return null;
    }

    protected function upsertEventType(string $code, string $name): void
    {
        EventType::updateOrCreate(
            ['code' => $code],
            [
                'name' => $name,
                'description' => 'Créé automatiquement par le seeder ENSA.',
                'minimum_submission_days' => 0,
                'is_active' => true,
            ]
        );
    }

    protected function upsertCategory(string $code, string $name): void
    {
        Category::updateOrCreate(
            ['code' => $code],
            [
                'name' => $name,
                'description' => 'Créée automatiquement par le seeder ENSA.',
                'is_active' => true,
            ]
        );
    }

    protected function upsertVenue(string $code, string $name, ?string $location, bool $isInternal): void
    {
        Venue::updateOrCreate(
            ['code' => $code],
            [
                'name' => $name,
                'location' => $location,
                'capacity' => null,
                'is_internal' => $isInternal,
                'description' => 'Créé automatiquement par le seeder ENSA.',
                'is_active' => true,
            ]
        );
    }
}
