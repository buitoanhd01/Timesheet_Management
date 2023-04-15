<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attendance>
 */
class AttendanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date' => date('Y-m-d'),
            'employee_id' => 1,
            'first_checkin' => date('Y-m-d H:i:s'),
            'last_checkout' => date('Y-m-d H:i:s'),
            'working_hours' => random_int(1,10),
            'overtime' => random_int(1,10),
        ];
    }
}
