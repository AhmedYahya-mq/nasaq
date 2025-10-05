@props([
    'title' => __('blog.default_title'),
    'author' => __('blog.default_author'),
    'created_at' => now()->format('d M, Y'),
    'content' => __('blog.default_content'),
    'images' => [
        [
            'image' => 'seminar-1.webp',
            'caption' => __('blog.default_image_caption'),
        ],
    ],
])

<section id="single-blog" class="py-16 md:py-24 bg-card">
    <div class="container mx-auto max-w-4xl px-4 space-y-10">

        {{-- عنوان المقال --}}
        <h2 class="text-3xl md:text-4xl font-bold mb-2 text-primary">
            {!! $title !!}
        </h2>

        {{-- الكاتب والتاريخ --}}
        <p class="text-sm text-muted-foreground mb-6">
            {{ __('blog.by') }} <span class="font-medium">{{ $author }}</span> | {{ $created_at }}
        </p>

        {{-- الصور --}}
        <div
            class="relative w-full h-auto aspect-[16/9] bg-card dark:bg-card-dark rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-shadow duration-300 group">
            <img src="https://read.opensooq.com/wp-content/uploads/2022/03/%D9%85%D8%B9%D9%84%D9%88%D9%85%D8%A7%D8%AA-%D8%B9%D9%86-%D8%AA%D8%AE%D8%B5%D8%B5-%D8%A7%D9%84%D8%AA%D8%BA%D8%B0%D9%8A%D8%A9.webp"
                alt="{{ $title }}"
                class="object-cover min-w-lg max-h-md w-full h-full scale-100 group-hover:scale-105 transition-transform duration-300">
        </div>


        {{-- محتوى المقال --}}
        <div class="prose max-w-full text-justify text-muted-foreground">
            <div class="max-w-5xl mx-auto p-8 *:ps-4 **:ps-4">

                <h1 class="text-4xl font-bold text-gray-900 dark:text-white">التغذية العلاجية: علم غذائي لعلاج الأمراض
                    وتحسين الصحة</h1>

                <p class="text-gray-700 dark:text-gray-300 leading-relaxed mt-4">
                    التغذية العلاجية هي علم حديث يدمج بين الطب والتغذية، يهدف إلى استخدام الغذاء كوسيلة علاجية للوقاية
                    من الأمراض وتحسين جودة الحياة. يعتمد هذا المجال على دراسة دقيقة للعناصر الغذائية، الفيتامينات،
                    المعادن، والأحماض الأمينية، لتصميم خطط غذائية تناسب كل حالة صحية على حدة.
                </p>

                <h2 class="text-3xl font-semibold text-gray-900 dark:text-white mt-8">أهمية التغذية العلاجية في العصر
                    الحديث</h2>
                <p class="text-gray-700 dark:text-gray-300 leading-relaxed mt-2">
                    مع زيادة انتشار الأمراض المزمنة مثل السكري، السمنة، وأمراض القلب، أصبح الاعتماد على التغذية العلاجية
                    ضرورة وليس خيارًا. الغذاء المناسب يمكن أن:
                </p>
                <ul class="list-disc list-inside text-gray-700 dark:text-gray-300 space-y-2 mt-2">
                    <li>يدعم علاج الأمراض المزمنة.</li>
                    <li>يعزز جهاز المناعة ويحسن الصحة العامة.</li>
                    <li>يساهم في الوقاية من نقص الفيتامينات والمعادن.</li>
                    <li>يحسن الأداء الذهني والبدني.</li>
                </ul>

                <h2 class="text-3xl font-semibold text-gray-900 dark:text-white mt-8">المبادئ الأساسية للتغذية العلاجية
                </h2>
                <p class="text-gray-700 dark:text-gray-300 leading-relaxed mt-2">
                    قبل البدء بأي خطة غذائية علاجية، يجب فهم المبادئ الأساسية التي يقوم عليها هذا العلم:
                </p>
                <ol class="list-decimal list-inside text-gray-700 dark:text-gray-300 space-y-2 mt-2">
                    <li>تحديد الاحتياجات الغذائية الفردية لكل مريض وفق حالته الصحية.</li>
                    <li>تقييم نمط الحياة ومستوى النشاط البدني للمريض.</li>
                    <li>اختيار الأطعمة التي تعزز الشفاء وتدعم وظائف الجسم.</li>
                    <li>تجنب الأطعمة الضارة أو تلك التي تتداخل مع الأدوية.</li>
                    <li>مراقبة استجابة الجسم وتحسين الخطة باستمرار.</li>
                </ol>

                <h2 class="text-3xl font-semibold text-gray-900 dark:text-white mt-8">الأمراض التي تستفيد من التغذية
                    العلاجية</h2>
                <p class="text-gray-700 dark:text-gray-300 leading-relaxed mt-2">
                    التغذية العلاجية لها تأثير كبير على مجموعة متنوعة من الحالات المرضية:
                </p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                    <div class="p-5 bg-gray-50 dark:bg-gray-800 rounded-xl shadow-md">
                        <h3 class="font-semibold text-gray-800 dark:text-white">مرض السكري</h3>
                        <p class="text-gray-700 dark:text-gray-300 mt-2">اتباع نظام منخفض الكربوهيدرات مع التركيز على
                            الألياف والدهون
                            الصحية يساعد على التحكم في مستويات السكر بالدم ومنع المضاعفات.</p>
                    </div>
                    <div class="p-5 bg-gray-50 dark:bg-gray-800 rounded-xl shadow-md">
                        <h3 class="font-semibold text-gray-800 dark:text-white">أمراض القلب والشرايين</h3>
                        <p class="text-gray-700 dark:text-gray-300 mt-2">زيادة استهلاك الأطعمة الغنية بالأوميغا 3 مثل
                            السمك والمكسرات،
                            والحد من الدهون المشبعة والصوديوم يقلل من خطر الإصابة بالنوبات القلبية.</p>
                    </div>
                    <div class="p-5 bg-gray-50 dark:bg-gray-800 rounded-xl shadow-md">
                        <h3 class="font-semibold text-gray-800 dark:text-white">السمنة وزيادة الوزن</h3>
                        <p class="text-gray-700 dark:text-gray-300 mt-2">اتباع نظام منخفض السعرات مع التركيز على
                            البروتين والخضروات يزيد من
                            الشبع ويساعد على فقدان الوزن بشكل صحي.</p>
                    </div>
                    <div class="p-5 bg-gray-50 dark:bg-gray-800 rounded-xl shadow-md">
                        <h3 class="font-semibold text-gray-800 dark:text-white">أمراض الكلى</h3>
                        <p class="text-gray-700 dark:text-gray-300 mt-2">تحديد كمية البروتين وتقليل الصوديوم والبوتاسيوم
                            بما يتناسب مع حالة
                            المريض يساعد على تحسين وظائف الكلى.</p>
                    </div>
                    <div class="p-5 bg-gray-50 dark:bg-gray-800 rounded-xl shadow-md">
                        <h3 class="font-semibold text-gray-800 dark:text-white">مشاكل الجهاز الهضمي</h3>
                        <p class="text-gray-700 dark:text-gray-300 mt-2">الألياف الغذائية، البروبيوتيك، وتقليل الأطعمة
                            المصنعة تساعد على
                            تحسين الهضم ومنع الانتفاخ والقولون العصبي.</p>
                    </div>
                    <div class="p-5 bg-gray-50 dark:bg-gray-800 rounded-xl shadow-md">
                        <h3 class="font-semibold text-gray-800 dark:text-white">نقص الفيتامينات والمعادن</h3>
                        <p class="text-gray-700 dark:text-gray-300 mt-2">تناول مجموعة متنوعة من الفواكه والخضروات،
                            والحبوب الكاملة،
                            والمكملات عند الحاجة يعوض النقص ويحسن الصحة العامة.</p>
                    </div>
                </div>

                <h2 class="text-3xl font-semibold text-gray-900 dark:text-white mt-8">نصائح عملية للتغذية العلاجية
                    اليومية</h2>
                <ul class="list-disc list-inside text-gray-700 dark:text-gray-300 space-y-2 mt-2">
                    <li>تنظيم وجبات الطعام على مدار اليوم لتجنب الإفراط في الأكل.</li>
                    <li>شرب كمية كافية من الماء لتعزيز الهضم وطرد السموم.</li>
                    <li>اختيار مصادر بروتين متنوعة مثل السمك، الدواجن، والبقوليات.</li>
                    <li>الحد من السكريات المكررة والدهون المشبعة.</li>
                    <li>إضافة الأعشاب الطبيعية والتوابل الصحية مثل الزنجبيل والثوم لتعزيز المناعة.</li>
                </ul>

                <h2 class="text-3xl font-semibold text-gray-900 dark:text-white mt-8">البحث العلمي وأهمية التغذية
                    العلاجية</h2>
                <p class="text-gray-700 dark:text-gray-300 leading-relaxed mt-2">
                    الدراسات الحديثة أظهرت أن التغذية العلاجية يمكن أن تقلل من الحاجة لبعض الأدوية، وتسرع عملية الشفاء،
                    وتدعم الوقاية من الأمراض المزمنة. على سبيل المثال، أظهرت الأبحاث أن اتباع نظام غني بالألياف يقلل من
                    مخاطر الإصابة بالسكري بنسبة تصل إلى 30%، ويخفض مستويات الكوليسترول الضار في الدم.
                </p>

                <h2 class="text-3xl font-semibold text-gray-900 dark:text-white mt-8">خلاصة</h2>
                <p class="text-gray-700 dark:text-gray-300 leading-relaxed mt-2">
                    التغذية العلاجية ليست مجرد تناول طعام صحي، بل هي علم متكامل يعتمد على المعرفة الدقيقة بالعناصر
                    الغذائية وحالة المريض الصحية. الالتزام بخطة غذائية مصممة خصيصًا لكل شخص يمكن أن يحسن الصحة العامة،
                    يمنع الأمراض، ويعزز نوعية الحياة على المدى الطويل.
                </p>

            </div>
        </div>

        {{-- نهاية المقال: مشاركة مبتكرة --}}
        <div
            class="mt-12 p-8 bg-gradient-to-r from-primary/20 to-primary/10 rounded-2xl border border-primary/30 shadow-lg text-center space-y-4">

            {{-- رسالة تشجيعية --}}
            <p class="text-lg md:text-xl font-semibold text-primary mb-4">
                {{ __('blog.share_message') }}
            </p>

            {{-- أزرار المشاركة --}}
            <div class="flex justify-center gap-4 flex-wrap">
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}" target="_blank"
                    class="flex items-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-xl hover:scale-105 hover:bg-blue-700 transition transform">
                    <x-ui.icon name="facebook" class="size-5 text-white" />
                    {{ __('blog.facebook') }}
                </a>
                <a href="https://twitter.com/intent/tweet?url={{ url()->current() }}&text={{ $title }}"
                    target="_blank"
                    class="flex items-center gap-2 bg-blue-400 text-white px-6 py-3 rounded-xl hover:scale-105 hover:bg-blue-500 transition transform">
                    <x-ui.icon name="x" class="size-5 text-white" />
                    {{ __('blog.twitter') }}
                </a>
                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ url()->current() }}" target="_blank"
                    class="flex items-center gap-2 bg-blue-700 text-white px-6 py-3 rounded-xl hover:scale-105 hover:bg-blue-800 transition transform">
                    <x-ui.icon name="linkedin" class="size-5 text-white" />
                    {{ __('blog.linkedin') }}
                </a>
            </div>

            {{-- نص إضافي --}}
            <p class="text-sm text-muted-foreground mt-4">
                {{ __('blog.share_note') }}
            </p>
        </div>

    </div>
</section>
