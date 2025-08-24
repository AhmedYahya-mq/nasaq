<section id="hero">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 p-4 bg-card lg:h-[calc(100dvh-6.9rem)]">
        <div class="flex flex-col items-start justify-center p-5 h-full order-2 lg:order-1">
            <h1 class="text-3xl font-bold mb-4">مجتمع التغذية العلاجية</h1>
            <p class="text-lg text-muted-foreground mb-6">
                نسق هي منصة وموقع مجتمع متخصص في التغذية العلاجية، تهدف إلى تقديم محتوى علمي موثوق وعملي للمهتمين
                بالصحة والتغذية.
                تجمع المنصة بين الخبراء، الأخصائيين، والأشخاص الراغبين في تحسين نمط حياتهم الغذائي.
            </p>
            <button aria-label="سجل معنا" class="bg-primary !text-white px-4 py-2 rounded-lg hover:bg-primary/80 transition-colors">
                <a class="text-white" href="{{ '/' }}">سجل معنا</a>
            </button>
        </div>
        <div
            class="flex items-center justify-center *:not-first:p-2 aspect-[3/2] *:not-first:w-[250px] relative h-[calc(100dvh-6.9rem)] w-full lg:aspect-square order-1 lg:order-2">
            <img src="{{ asset('images/froot.webp') }}" class="size-auto" alt="{{ config('app.name') }}">
            <div class="absolute top-[15%] left-2  bg-muted/60 shadow rounded-xl">
                <h2 class="text-xs font-medium">📚 مرجعك في أي وقت وأي مكان</h3>
                <p class="text-[11px] mt-1">المكتبة الرقمية توفر لك محتوى علمي موثوق ومتجدد يساعدك على تطوير مهاراتك
                    وبناء خبرتك الطبية بثقة.</p>
            </div>
            <div class="absolute bottom-[15%] left-2 bg-muted/60 shadow rounded-xl">
                <h2 class="text-xs font-medium">🎤 معرفة تلامس واقعك</h3>
                <p class="text-[11px] mt-1">الندوات التفاعلية تفتح لك الطريق لاكتشاف أحدث الأبحاث والممارسات الطبية
                    من خلال محاضرات وورش عمل عملية وسهلة الفهم.</p>
            </div>
            <div class="absolute right-2 bg-muted/60 shadow rounded-xl">
                <h2 class="text-xs font-medium">📅 كن في قلب النقاشات العلمية</h3>
                <p class="text-[11px] mt-1">الاجتماعات الدورية تمنحك محتوى حيّ، وتبقيك على تواصل مباشر مع نخبة
                    الأطباء والخبراء في مختلف التخصصات.</p>
            </div>
        </div>
    </div>
</section>
