<section id="feature">
    <div class="relative min-h-auto mt-20">
        <h2 class="text-center mb-20">مميزاتنا</h2>
        <div class="flex flex-col gap-36 w-full">

            <!-- الندوات الدورية -->
            <div
                class="Seminars grid place-items-center place-content-center grid-cols-1 md:grid-cols-2 md:gap-14 gap-6">
                <div class="flex items-start gap-4 rtl:pr-6 ltr:pl-6 not-md:px-5">
                    <div class="flex flex-col justify-center">
                        <h3 class="text-2xl font-bold text-primary">الندوات الدورية</h3>
                        <div class="p-5">
                            <p class="text-muted-foreground">
                                ندوات نسق الدورية تمنح أخصائيي التغذية العلاجية مساحة للتعلم والتفاعل في لقاءات منتظمة
                                تجمع بين المعرفة والتطبيق. كل ندوة تُناقش التحديات الواقعية وتطرح حلولًا مبتكرة ضمن بيئة
                                مهنية محفزة. إنها فرصتك للانتماء إلى مجتمع يطور مهاراتك ويدعم نموك المهني.
                            </p>
                            <ul
                                class="flex flex-col rtl:pr-5 ltr:pl-5 gap-3 mt-5 list-inside text-muted-foreground
                                       *:flex *:items-center *:gap-4">
                                <li>
                                    <i class="flex items-center justify-center p-3 shadow-lg rounded-full bg-card">
                                        <x-ui.icon name="sparkles"
                                            class="size-8 drop-shadow-lg text-primary *:!fill-primary" />
                                    </i>
                                    <span>لقاءات دورية غنية بالمحتوى التطبيقي</span>
                                </li>
                                <li>
                                    <i class="flex items-center justify-center p-3 shadow-lg rounded-full bg-card">
                                        <x-ui.icon name="light"
                                            class="size-8 drop-shadow-lg text-primary *:!fill-primary" />
                                    </i>
                                    <span>تبادل خبرات واقعية وحلول مهنية مبتكرة</span>
                                </li>
                                <li>
                                    <i class="flex items-center justify-center p-3 shadow-lg rounded-full bg-card">
                                        <x-ui.icon name="handshake"
                                            class="size-8 drop-shadow-lg text-primary *:!fill-primary" />
                                    </i>
                                    <span>بناء شبكة علاقات مهنية متينة</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="md:p-7 not-md:px-5 flex justify-center items-center">
                    <img src="{{ asset('images/seminar.webp') }}" width="1200" height="800"
                        class="w-full h-auto object-cover brightness-100
                                dark:!drop-shadow-[0_35px_35px_rgba(255,255,255,0.15)]
                                drop-shadow-[0_35px_35px_rgba(0,0,0,0.30)]"
                        alt="Seminars" />
                </div>
            </div>

            <!-- الاجتماعات الافتراضية -->
            <div
                class="Seminars grid place-items-center place-content-center grid-cols-1 md:grid-cols-2 md:gap-14 gap-6">
                <div class="flex items-center justify-center h-full rtl:pr-6 ltr:pl-6 not-md:px-5">
                    <img src="{{ asset('images/meat.webp') }}" width="1200" height="800"
                        class="w-full h-auto object-cover brightness-100
                                dark:!drop-shadow-[0_35px_35px_rgba(255,255,255,0.15)]
                                drop-shadow-[0_35px_35px_rgba(0,0,0,0.3)]"
                        alt="Seminars">
                </div>
                <div class="flex items-start gap-4 not-md:px-5">
                    <div class="flex flex-col">
                        <h3 class="text-2xl font-bold text-primary">الاجتماعات الافتراضية</h3>
                        <div class="p-5">
                            <p class="text-muted-foreground">
                                ابقَ على تواصل دائم مع مجتمعك من أي مكان حول العالم من خلال الاجتماعات الافتراضية
                                الشهرية. هذه اللقاءات التفاعلية توفر لك منصة للنقاش المباشر، متابعة أحدث المستجدات،
                                ومشاركة خبراتك مع زملائك بطريقة مرنة وسلسة. كل اجتماع هو فرصة لتطوير مهاراتك والبقاء على
                                اطلاع دائم بكل ما هو جديد.
                            </p>
                            <ul
                                class="flex flex-col rtl:pr-5 ltr:pl-5 gap-3 mt-5 list-inside text-muted-foreground
                                       *:flex *:items-center *:gap-4">
                                <li>
                                    <i class="flex items-center justify-center p-3 shadow-lg rounded-full bg-card">
                                        <x-ui.icon name="puzzle"
                                            class="size-8 drop-shadow-lg text-primary *:!fill-primary" />
                                    </i>
                                    <span>جلسات تفاعلية عملية ومباشرة</span>
                                </li>
                                <li>
                                    <i class="flex items-center justify-center p-3 shadow-lg rounded-full bg-card">
                                        <x-ui.icon name="chat"
                                            class="size-8 drop-shadow-lg text-primary *:!fill-primary" />
                                    </i>
                                    <span>نقاشات تطبيقية وحلول واقعية</span>
                                </li>
                                <li>
                                    <i class="flex items-center justify-center p-3 shadow-lg rounded-full bg-card">
                                        <x-ui.icon name="chart"
                                            class="size-8 drop-shadow-lg text-primary *:!fill-primary" />
                                    </i>
                                    <span>محتوى غني يمكن تطبيقه بسهولة في العمل اليومي</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- المكتبة الرقمية -->
            <div
                class="Seminars grid place-items-center place-content-center grid-cols-1 md:grid-cols-2 md:gap-14 gap-6">
                <div class="flex items-start gap-4 rtl:pr-6 ltr:pl-6 not-md:px-5">
                    <div class="flex flex-col justify-center">
                        <h3 class="text-2xl font-bold text-primary">المكتبة الرقمية</h3>
                        <div class="p-5">
                            <p class="text-muted-foreground">
                                اكتشف مكتبتك الرقمية في "نسق".. مصدر ثري يجمع أحدث المراجع والأبحاث في مجال التغذية
                                العلاجية بين يديك. محتوى متجدد، معرفة عملية، وإلهام مستمر يساعدك على تطوير مهاراتك وبناء
                                مستقبل مهني أكثر تميزًا. ليست مجرد مكتبة، بل رفيقك اليومي للابتكار والنمو والاحترافية.
                            </p>
                            <ul
                                class="flex flex-col rtl:pr-5 ltr:pl-5 gap-3 mt-5 list-inside text-muted-foreground
                                       *:flex *:items-center *:gap-4">
                                <li>
                                    <i class="flex items-center justify-center p-3 shadow-lg rounded-full bg-card">
                                        <x-ui.icon name="books"
                                            class="size-8 drop-shadow-lg text-primary *:!fill-primary" />
                                    </i>
                                    <span>مكتبة رقمية متجددة تقدم أحدث المراجع والأبحاث في التغذية العلاجية</span>
                                </li>
                                <li>
                                    <i class="flex items-center justify-center p-3 shadow-lg rounded-full bg-card">
                                        <x-ui.icon name="glowing-star"
                                            class="size-8 drop-shadow-lg text-primary *:!fill-primary" />
                                    </i>
                                    <span>مصدر إلهام مستمر لبناء مستقبل مهني متميز واحترافي</span>
                                </li>
                                <li>
                                    <i class="flex items-center justify-center p-3 shadow-lg rounded-full bg-card">
                                        <x-ui.icon name="bolt"
                                            class="size-8 drop-shadow-lg text-primary *:!fill-primary" />
                                    </i>
                                    <span>أدوات عملية تدعم تطوير مهاراتك المهنية بفعالية</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="md:p-7 not-md:px-5 flex justify-center items-center">
                    <img src="{{ asset('images/digital-library-1.webp') }}" width="1200" height="800"
                        class="w-full h-auto object-cover brightness-100
                                dark:!drop-shadow-[0_35px_35px_rgba(255,255,255,0.15)]
                                drop-shadow-[0_35px_35px_rgba(0,0,0,0.30)]"
                        alt="Seminars" />
                </div>
            </div>

        </div>
    </div>
</section>
