<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\MembershipApplication;
use App\Models\MembershipFile;
use App\Models\Membership;

class MembershipApplicationSeeder extends Seeder
{
    public function run()
    {
        // $users = User::factory()->count(10)->create();
        $users = User::get();
        $memberships = Membership::all();

        foreach ($users as $user) {
            $membershipCount = rand(1, 2);

            for ($i = 0; $i < $membershipCount; $i++) {
                $membership = $memberships->random();

                $application = MembershipApplication::factory()->create([
                    'user_id' => $user->id,
                    'membership_id' => $membership->id,
                ]);

                // 4️⃣ إنشاء ملفات وهمية لكل طلب
                MembershipFile::factory()->count(rand(1,3))->create([
                    'membership_application_id' => $application->id,
                ]);
            }
        }
    }
}
