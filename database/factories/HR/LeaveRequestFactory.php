<?php

namespace Database\Factories\HR;

use App\Enums\LeaveStatus;
use App\Enums\LeaveType;
use App\Models\HR\LeaveRequest;
use DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<LeaveRequest>
 */
class LeaveRequestFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = LeaveRequest::class;

    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('-6 months', '+3 months');
        $days = $this->faker->randomElement([0.5, 1, 1, 1, 2, 2, 3, 5, 5, 10]);
        $endDate = (clone $startDate)->modify('+' . max(1, (int) ceil($days)) . ' days');
        $status = $this->faker->randomElement(LeaveStatus::cases());

        return [
            'type' => $this->faker->randomElement(LeaveType::cases()),
            'status' => $status,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'days_requested' => $days,
            'reason' => $this->faker->sentence(),
            'reviewer_notes' => $status !== LeaveStatus::Pending ? $this->faker->optional(0.5)->sentence() : null,
            'reviewed_at' => $status !== LeaveStatus::Pending && $startDate <= new DateTime ? $this->faker->dateTimeBetween($startDate, 'now') : null,
        ];
    }
}
