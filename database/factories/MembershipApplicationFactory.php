<?php

namespace Database\Factories;

use App\Enums\EmploymentStatus;
use App\Enums\MembershipApplication as EnumsMembershipApplication;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\MembershipApplication;
use App\Enums\MembershipStatus;

class MembershipApplicationFactory extends Factory
{
    protected $model = MembershipApplication::class;

    public function definition()
    {
        return [
            'national_id' => $this->faker->numerify('###########'),
            'employment_status' => $this->faker->randomElement(EmploymentStatus::getValues()),
            'current_employer' => $this->faker->company,
            'scfhs_number' => $this->faker->numerify('########'),
            'status' => EnumsMembershipApplication::Pending,
            'submitted_at' => now(),
            'reviewed_at' => null,
            'notes' => $this->faker->optional()->paragraph,
            'admin_notes' => null,
        ];
    }
}
