<?php

namespace Database\Factories;

use App\Models\Membership;
use Illuminate\Database\Eloquent\Factories\Factory;

class MembershipFactory extends Factory
{
    protected $model = Membership::class;

    public function definition(): array
    {
        $price = $this->faker->randomFloat(2, 10, 999);
        $hasDiscount = $this->faker->boolean(40);
        $discounted = $hasDiscount ? round($price * $this->faker->randomFloat(2, 0.5, 0.95), 2) : null;

        return [
            'name' => [
                'en' => $this->faker->randomElement(['Basic', 'Standard', 'Pro', 'Enterprise']),
                'ar' => $this->faker->randomElement(['الأساسية', 'القياسية', 'الاحترافية', 'المؤسسة']),
            ],
            'description' => [
                'en' => $this->faker->sentence(12),
                'ar' => $this->faker->sentence(10),
            ],
            'is_active' => true,
            'price' => $price,
            'discounted_price' => $discounted,
            'duration_days' => $this->faker->randomElement([30, 90, 180, 365]),
            'requirements' => [
                'en' => $this->faker->sentences(2),
                'ar' => ['متطلب 1', 'متطلب 2'],
            ],
            'features' => [
                'en' => $this->faker->sentences(3),
                'ar' => ['ميزة 1', 'ميزة 2', 'ميزة 3'],
            ],
        ];
    }
}
