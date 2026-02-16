<?php

namespace Database\Seeders;

use App\Filament\Resources\Shop\Orders\OrderResource;
use App\Models\Address;
use App\Models\Blog\Author;
use App\Models\Blog\Post;
use App\Models\Blog\PostCategory;
use App\Models\Comment;
use App\Models\HR\Department;
use App\Models\HR\Employee;
use App\Models\HR\Expense;
use App\Models\HR\ExpenseLine;
use App\Models\HR\LeaveRequest;
use App\Models\HR\Project;
use App\Models\HR\Task;
use App\Models\HR\Timesheet;
use App\Models\Shop\Brand;
use App\Models\Shop\Customer;
use App\Models\Shop\Order;
use App\Models\Shop\OrderItem;
use App\Models\Shop\Payment;
use App\Models\Shop\Product;
use App\Models\Shop\ProductCategory;
use App\Models\User;
use Closure;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\Console\Helper\ProgressBar;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::raw('SET time_zone=\'+00:00\'');

        // Clear images
        Storage::deleteDirectory('public');

        // Admin
        $this->command->warn(PHP_EOL . 'Creating admin user...');
        $user = $this->withProgressBar(1, fn () => User::factory(1)->create([
            'name' => 'Demo User',
            'email' => 'admin@filamentphp.com',
            'password' => Hash::make('demo.Filament@2021!'),
        ]));
        $this->command->info('Admin user created.');

        // Shop
        $this->command->warn(PHP_EOL . 'Creating brands...');
        $brands = $this->withProgressBar(20, fn () => Brand::factory()->count(20)
            ->has(Address::factory()->count(rand(1, 3)))
            ->create());
        Brand::query()->update(['sort' => new Expression('id')]);
        $this->command->info('Brands created.');

        $this->command->warn(PHP_EOL . 'Creating product categories...');
        $categories = $this->withProgressBar(20, fn () => ProductCategory::factory(1)
            ->has(
                ProductCategory::factory()->count(3),
                'children'
            )->create());
        $this->command->info('Product categories created.');

        $this->command->warn(PHP_EOL . 'Creating customers...');
        $customers = $this->withProgressBar(1000, fn () => Customer::factory(1)
            ->has(Address::factory()->count(rand(1, 3)))
            ->create());
        $this->command->info('Customers created.');

        $this->command->warn(PHP_EOL . 'Creating products...');
        $products = $this->withProgressBar(50, fn () => Product::factory(1)
            ->sequence(fn ($sequence) => ['brand_id' => $brands->random(1)->first()->id])
            ->hasAttached($categories->random(rand(3, 6)), ['created_at' => now(), 'updated_at' => now()])
            ->has(
                Comment::factory()->count(rand(10, 20))
                    ->state(fn (array $attributes, Product $product) => ['customer_id' => $customers->random(1)->first()->id]),
            )
            ->create());
        $this->command->info('Products created.');

        $this->command->warn(PHP_EOL . 'Creating orders...');
        $orders = $this->withProgressBar(1000, fn () => Order::factory(1)
            ->sequence(fn ($sequence) => ['customer_id' => $customers->random(1)->first()->id])
            ->has(Payment::factory()->count(rand(1, 3)))
            ->has(
                OrderItem::factory()->count(rand(2, 5))
                    ->state(fn (array $attributes, Order $order) => ['product_id' => $products->random(1)->first()->id]),
                'orderItems'
            )
            ->create());

        foreach ($orders->random(rand(5, 8)) as $order) {
            Notification::make()
                ->title('New order')
                ->icon('heroicon-o-shopping-bag')
                ->body("{$order->customer->name} ordered {$order->orderItems->count()} products.")
                ->actions([
                    Action::make('View')
                        ->url(OrderResource::getUrl('edit', ['record' => $order])),
                ])
                ->sendToDatabase($user);
        }
        $this->command->info('Orders created.');

        // Blog
        $this->command->warn(PHP_EOL . 'Creating post categories...');
        $blogCategories = $this->withProgressBar(20, fn () => PostCategory::factory(1)
            ->count(20)
            ->create());
        $this->command->info('Post categories created.');

        $this->command->warn(PHP_EOL . 'Creating authors and posts...');
        $postTags = ['Laravel', 'PHP', 'JavaScript', 'CSS', 'DevOps', 'Testing', 'API', 'Security', 'Performance', 'Architecture', 'Git', 'Database', 'Accessibility', 'Deployment', 'Design Patterns'];
        $this->withProgressBar(20, fn () => Author::factory(1)
            ->has(
                Post::factory()->count(5)
                    ->has(
                        Comment::factory()->count(rand(5, 10))
                            ->state(fn (array $attributes, Post $post) => ['customer_id' => $customers->random(1)->first()->id]),
                    )
                    ->state(fn (array $attributes, Author $author) => ['post_category_id' => $blogCategories->random(1)->first()->id])
                    ->afterCreating(function (Post $post) use ($postTags): void {
                        $post->attachTags(fake()->randomElements($postTags, rand(2, 5)));
                    }),
                'posts'
            )
            ->create());
        $this->command->info('Authors and posts created.');

        // HR & Projects
        $this->command->warn(PHP_EOL . 'Creating departments...');
        $topDepartments = $this->withProgressBar(4, fn () => Department::factory(1)->create());

        $childNames = collect(['Frontend', 'Backend', 'DevOps', 'QA', 'Content', 'SEO'])->shuffle()->values();
        $childIndex = 0;

        $childDepartments = new Collection;
        foreach ($topDepartments as $parent) {
            $count = min(rand(1, 2), $childNames->count() - $childIndex);
            for ($i = 0; $i < $count; $i++) {
                $childName = $childNames[$childIndex++];
                $child = Department::factory()->create([
                    'parent_id' => $parent->id,
                    'name' => $childName,
                    'slug' => Str::slug($childName),
                ]);
                $childDepartments->push($child);
            }
        }

        $allDepartments = $topDepartments->merge($childDepartments);
        $this->command->info('Departments created.');

        $this->command->warn(PHP_EOL . 'Creating employees...');
        $employees = $this->withProgressBar(100, fn () => Employee::factory(1)
            ->state(fn () => ['department_id' => $allDepartments->random()->id])
            ->create());
        $this->command->info('Employees created.');

        $this->command->warn(PHP_EOL . 'Creating leave requests...');
        $this->withProgressBar(500, fn () => LeaveRequest::factory(1)
            ->state(fn () => [
                'employee_id' => $employees->random()->id,
                'approver_id' => fake()->boolean(60) ? $employees->random()->id : null,
            ])
            ->create());
        $this->command->info('Leave requests created.');

        $this->command->warn(PHP_EOL . 'Creating projects...');
        $projects = $this->withProgressBar(20, fn () => Project::factory(1)
            ->state(fn () => ['department_id' => $allDepartments->random()->id])
            ->create());
        $this->command->info('Projects created.');

        $this->command->warn(PHP_EOL . 'Creating tasks...');
        $tasks = $this->withProgressBar(200, fn () => Task::factory(1)
            ->state(fn () => [
                'project_id' => $projects->random()->id,
                'assigned_to' => fake()->boolean(70) ? $employees->random()->id : null,
            ])
            ->create());
        $this->command->info('Tasks created.');

        $this->command->warn(PHP_EOL . 'Creating timesheets...');
        $this->withProgressBar(5000, fn () => Timesheet::factory(1)
            ->state(function () use ($employees, $projects, $tasks) {
                $project = $projects->random();
                $projectTasks = $tasks->where('project_id', $project->id);
                $employee = $employees->random();

                return [
                    'employee_id' => $employee->id,
                    'project_id' => $project->id,
                    'task_id' => $projectTasks->isNotEmpty() ? $projectTasks->random()->id : null,
                    'hourly_rate' => $employee->hourly_rate ?? fake()->randomFloat(2, 50, 200),
                ];
            })
            ->create());
        $this->command->info('Timesheets created.');

        $this->command->warn(PHP_EOL . 'Creating expenses...');
        $this->withProgressBar(300, fn () => Expense::factory(1)
            ->state(fn () => [
                'employee_id' => $employees->random()->id,
                'project_id' => fake()->boolean(60) ? $projects->random()->id : null,
                'approved_by' => fake()->boolean(30) ? $employees->random()->id : null,
            ])
            ->has(
                ExpenseLine::factory()->count(rand(1, 5)),
                'expenseLines'
            )
            ->create()
            ->each(function (Expense $expense): void {
                $expense->update([
                    'total_amount' => $expense->expenseLines()->sum('amount'),
                ]);
            }));
        $this->command->info('Expenses created.');
    }

    protected function withProgressBar(int $amount, Closure $createCollectionOfOne): Collection
    {
        $progressBar = new ProgressBar($this->command->getOutput(), $amount);

        $progressBar->start();

        $items = new Collection;

        foreach (range(1, $amount) as $i) {
            $items = $items->merge(
                $createCollectionOfOne()
            );
            $progressBar->advance();
        }

        $progressBar->finish();

        $this->command->getOutput()->writeln('');

        return $items;
    }
}
