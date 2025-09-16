{{-- سكشن عرض البطاقات وصفحة الارشيف --}}
<section class="py-16 bg-background">
    <div class="container mx-auto px-4">

        {{-- 1. رأس الصفحة والفلترة --}}
        <div class="text-center mb-12">
            <h1 class="text-3xl md:text-5xl font-extrabold text-foreground mb-4 leading-tight">
                {{ __('archive.page.title') }}
            </h1>
            <p class="text-lg text-muted-foreground max-w-2xl mx-auto">
                {{ __('archive.page.subtitle') }}
            </p>

            {{-- شريط البحث والفلترة --}}
            <div class="mt-8 max-w-3xl mx-auto flex flex-col gap-6">
                <div class="flex justify-center">
                    <x-ui.filter-bar
                        :filters="[__('archive.filters.all'), '2025', '2024', '2023']"
                        :active-filter="__('archive.filters.all')"
                        :placeholder="__('archive.filters.search_placeholder')"
                    />
                </div>
            </div>
        </div>

        {{-- 2. شبكة عرض بطاقات الأرشيف (باستخدام المكون x-events.archive-card) --}}
        <div class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

            <x-events.archive-card
                :title="__('archive.samples.0.title')"
                date="2025-06-05"
                time="06:00 مساءً"
                imageUrl="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&w=1170"
                filesUrl="#"
                registrationUrl="#"
                class="h-full"
            />

            <x-events.archive-card
                :title="__('archive.samples.1.title' )"
                date="2025-05-20"
                time="07:00 مساءً"
                imageUrl="https://images.unsplash.com/photo-1555066931-4365d14bab8c"
                filesUrl="#"
                registrationUrl="#"
                class="h-full"
            />

            <x-events.archive-card
                :title="__('archive.samples.2.title' )"
                date="2025-04-15"
                time="08:30 مساءً"
                imageUrl="https://images.unsplash.com/photo-1620712943543-275d2911cf28?auto=format&fit=crop&w=1332"
                filesUrl="#"
                registrationUrl="#"
                class="h-full"
            />


        </div>

        {{-- 3. ترقيم الصفحات (Pagination  ) --}}
        <div class="mt-12">
            <x-pagination x-bind:total-pages="totalPages" x-bind:current-page="currentPage" />
        </div>

    </div>
</section>
