<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Membership;

class MembershipSeeder extends Seeder
{
    public function run()
    {
        $memberships = [
            // 1️⃣ عضوية الطالب
            [
                'name' => ['ar' => 'عضوية الطالب', 'en' => 'Student Membership'],
                'description' => [
                    'ar' => 'عضوية للطلاب والطالبات مرحلة البكالوريوس في تخصص التغذية العلاجية.',
                    'en' => 'Membership for undergraduate students in Clinical Nutrition.',
                ],
                'requirements' => [
                    'ar' => [
                        'إثبات تسجيل جامعي حديث',
                        'المشاركة الفعالة في الاجتماعات الشهرية على Zoom، مع الكاميرا والصوت',
                        'حضور فعلي مرة سنوياً للقاء حضوري لمن هم في مكة/جدة',
                    ],
                    'en' => [
                        'Recent university enrollment proof',
                        'Active participation in monthly Zoom meetings, with camera and audio on',
                        'Attend at least one annual in-person meeting (for residents of Mecca/Jeddah)',
                    ],
                ],
                'features' => [
                    'ar' => [
                        'شهادة عضوية',
                        'خصم للجلسات الشهرية',
                        'برنامج إرشاد مهني Mentorship مع أخصائيين معتمدين',
                        'الوصول إلى مصادر تعليمية رقمية حديثة',
                        'دعوة إلى فعاليات خاصة بالطلبة',
                    ],
                    'en' => [
                        'Membership certificate',
                        'Discount on monthly sessions',
                        'Mentorship program with certified specialists',
                        'Access to latest digital educational resources',
                        'Invitation to student-specific events',
                    ],
                ],
                'price' => 100,
                'duration_days' => 365,
                'is_active' => true,
            ],

            // 2️⃣ عضوية الخريج/المتدرب
            [
                'name' => ['ar' => 'عضوية الخريج/المتدرب', 'en' => 'Graduate/Trainee Membership'],
                'description' => [
                    'ar' => 'لخريجي التغذية العلاجية بانتظار الترخيص أو فترة التدريب.',
                    'en' => 'For Clinical Nutrition graduates awaiting license or in training period.',
                ],
                'requirements' => [
                    'ar' => [
                        'شهادة تخرج أو ما يثبت فترة الامتياز',
                        'المشاركة الفعالة في الاجتماعات الشهرية على Zoom',
                        'حضور فعلي مرة سنوياً للقاء حضوري لمن هم في مكة/جدة',
                    ],
                    'en' => [
                        'Graduation certificate or proof of internship period',
                        'Active participation in monthly Zoom meetings',
                        'Attend at least one annual in-person meeting (Mecca/Jeddah residents)',
                    ],
                ],
                'features' => [
                    'ar' => [
                        'شهادة عضوية',
                        'خصم للجلسات الشهرية',
                        'جلسات تحضيرية لاختبار الهيئة (SCFHS)',
                        'برنامج إرشاد مهني Mentorship',
                        'الوصول إلى مصادر تعليمية رقمية حديثة',
                    ],
                    'en' => [
                        'Membership certificate',
                        'Discount on monthly sessions',
                        'SCFHS exam preparation sessions',
                        'Mentorship program',
                        'Access to latest digital educational resources',
                    ],
                ],
                'price' => 150,
                'duration_days' => 365,
                'is_active' => true,
            ],

            // 3️⃣ عضوية الأخصائي المرخّص
            [
                'name' => ['ar' => 'عضوية الأخصائي المرخّص', 'en' => 'Licensed Specialist Membership'],
                'description' => [
                    'ar' => 'لأخصائي التغذية العلاجية الحاصل على ترخيص من الهيئة.',
                    'en' => 'For licensed Clinical Nutrition specialists.',
                ],
                'requirements' => [
                    'ar' => [
                        'ترخيص ساري من الهيئة',
                        'المشاركة في الاجتماعات الشهرية على Zoom',
                        'حضور فعلي مرة سنوياً للقاء حضوري لمن هم في مكة/جدة',
                    ],
                    'en' => [
                        'Valid license from SCFHS',
                        'Active participation in monthly Zoom meetings',
                        'Attend at least one annual in-person meeting (Mecca/Jeddah residents)',
                    ],
                ],
                'features' => [
                    'ar' => [
                        'شهادة عضوية',
                        'دخول مجاني لجميع الجلسات الافتراضية',
                        'أولوية في التقديم كمتحدث',
                        'عضو في قروب خاص للجان نسق',
                        'حقوق التصويت واختيار المواضيع في قروب لجان نسق',
                    ],
                    'en' => [
                        'Membership certificate',
                        'Free access to all virtual sessions',
                        'Priority to present as a speaker',
                        'Member in special NSQ committees group',
                        'Voting rights and topic selection in NSQ committees group',
                    ],
                ],
                'price' => 300,
                'duration_days' => 365,
                'is_active' => true,
            ],

            // 4️⃣ عضوية الباحث / الأكاديمي
            [
                'name' => ['ar' => 'عضوية الباحث / الأكاديمي', 'en' => 'Researcher/Academic Membership'],
                'description' => [
                    'ar' => 'لأعضاء هيئة التدريس، طلاب الدراسات العليا، الباحثين.',
                    'en' => 'For faculty members, graduate students, and researchers.',
                ],
                'requirements' => [
                    'ar' => [
                        'إثبات ارتباط أكاديمي أو بحثي نشط',
                        'نشر أو المشاركة في ورقة علمية خلال آخر عامين (موصى به)',
                        'المشاركة في الاجتماعات الشهرية على Zoom',
                        'حضور فعلي مرة سنوياً للقاء حضوري لمن هم في مكة/جدة',
                    ],
                    'en' => [
                        'Active academic or research affiliation',
                        'Publish or participate in a paper in the last 2 years (recommended)',
                        'Active participation in monthly Zoom meetings',
                        'Attend at least one annual in-person meeting (Mecca/Jeddah residents)',
                    ],
                ],
                'features' => [
                    'ar' => [
                        'شهادة عضوية',
                        'دخول مجاني لجميع الجلسات الافتراضية',
                        'أولوية في التقديم كمتحدث',
                        'عضو في قروب خاص للجان نسق',
                        'حقوق التصويت واختيار المواضيع',
                        'فرص التعاون في المبادرات العلمية',
                        'جلسات تبادل معرفي محلي ودولي',
                        'أولوية تقديم ملخصات بحثية في الفعاليات',
                    ],
                    'en' => [
                        'Membership certificate',
                        'Free access to all virtual sessions',
                        'Priority to present as a speaker',
                        'Member in special NSQ committees group',
                        'Voting rights and topic selection in NSQ committees group',
                        'Opportunities for collaboration in scientific initiatives',
                        'Knowledge exchange sessions locally and internationally',
                        'Priority submission of research abstracts in events',
                    ],
                ],
                'price' => 300,
                'duration_days' => 365,
                'is_active' => true,
            ],

            // 5️⃣ عضوية المستقلين ورواد الأعمال
            [
                'name' => ['ar' => 'عضوية المستقلين ورواد الأعمال', 'en' => 'Freelancers/Entrepreneurs Membership'],
                'description' => [
                    'ar' => 'لأخصائيين يملكون مشاريع أو يعملون كرواد أعمال.',
                    'en' => 'For specialists who own projects or work as entrepreneurs.',
                ],
                'requirements' => [
                    'ar' => [
                        'إثبات تقديم خدمات أو محتوى متعلق بالتغذية العلاجية',
                        'المشاركة في الاجتماعات الشهرية على Zoom',
                        'حضور فعلي مرة سنوياً للقاء حضوري لمن هم في مكة/جدة',
                    ],
                    'en' => [
                        'Proof of providing services or content related to Clinical Nutrition',
                        'Active participation in monthly Zoom meetings',
                        'Attend at least one annual in-person meeting (Mecca/Jeddah residents)',
                    ],
                ],
                'features' => [
                    'ar' => [
                        'شهادة عضوية',
                        'دخول مجاني لجميع الجلسات الافتراضية',
                        'أولوية في التقديم كمتحدث',
                        'عضو في قروب خاص للجان نسق',
                        'حقوق التصويت واختيار المواضيع في قروب لجان نسق',
                        'ورش في التسويق وبناء الهوية',
                        'عرض في دليل أعمال نسق الإلكتروني',
                    ],
                    'en' => [
                        'Membership certificate',
                        'Free access to all virtual sessions',
                        'Priority to present as a speaker',
                        'Member in special NSQ committees group',
                        'Voting rights and topic selection in NSQ committees group',
                        'Workshops in marketing and brand building',
                        'Listing in NSQ online business directory',
                    ],
                ],
                'price' => 350,
                'duration_days' => 365,
                'is_active' => true,
            ],
        ];

        foreach ($memberships as $data) {
            Membership::create($data);
        }
    }
}
