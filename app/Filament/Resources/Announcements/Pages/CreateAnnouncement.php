<?php

namespace App\Filament\Resources\Announcements\Pages;

use App\Filament\Resources\Announcements\AnnouncementResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAnnouncement extends CreateRecord
{
    protected static string $resource = AnnouncementResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (($data['status'] ?? null) === 'published') {
            $data['is_published'] = true;
            $data['published_at'] = $data['published_at'] ?? now();
        } else {
            $data['is_published'] = false;
            $data['published_at'] = null;
        }

        $data['user_id'] = auth()->id();

        return $data;
    }
}
