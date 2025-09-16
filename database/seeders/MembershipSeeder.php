<?php

namespace Database\Seeders;

use App\Models\Membership;
use Illuminate\Database\Seeder;

class MembershipSeeder extends Seeder
{
    public function run(): void
    {
        // Fixed plans
        Membership::query()->create([
            'name' => ['en' => 'Basic', 'ar' => 'الأساسية'],
            'description' => ['en' => 'Entry-level plan', 'ar' => 'خطة للمبتدئين'],
            'is_active' => true,
            'price' => 19.99,
            'discounted_price' => null,
            'duration_days' => 30,
            'requirements' => [
                'en' => ['Email verification'],
                'ar' => ['التحقق من البريد الإلكتروني'],
            ],
            'features' => [
                'en' => ['Access to core features'],
                'ar' => ['الوصول إلى الميزات الأساسية'],
            ],
        ]);

        Membership::query()->create([
            'name' => ['en' => 'Standard', 'ar' => 'القياسية'],
            'description' => ['en' => 'Great for regular use', 'ar' => 'مناسب للاستخدام المنتظم'],
            'is_active' => true,
            'price' => 49.99,
            'discounted_price' => 39.99,
            'duration_days' => 90,
            'requirements' => [
                'en' => ['Email verification'],
                'ar' => ['التحقق من البريد الإلكتروني'],
            ],
            'features' => [
                'en' => ['Priority support', 'More storage'],
                'ar' => ['دعم أولوية', 'مساحة تخزين أكبر'],
            ],
        ]);

        Membership::query()->create([
            'name' => ['en' => 'Pro', 'ar' => 'الاحترافية'],
            'description' => ['en' => 'Advanced features for teams', 'ar' => 'ميزات متقدمة للفرق'],
            'is_active' => true,
            'price' => 99.99,
            'discounted_price' => 79.99,
            'duration_days' => 180,
            'requirements' => [
                'en' => ['Email verification'],
                'ar' => ['التحقق من البريد الإلكتروني'],
            ],
            'features' => [
                'en' => ['Team collaboration', 'Analytics', 'API access'],
                'ar' => ['تعاون الفرق', 'تحليلات', 'وصول API'],
            ],
        ]);

        // Random extra plans
        Membership::factory()->count(5)->create();
    }
}
