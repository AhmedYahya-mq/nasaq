
<div x-data="{
    showFilters: false,
    search: '',
    activeFilter: 'All',
    books: [
        {
            id: 1,
            title: 'مقدمة في البرمجة',
            authors: ['أحمد علي'],
            type: 'Programming',
            coverImage: 'https://via.placeholder.com/300x400.png?text=كتاب+1',
            publisher: 'دار المعرفة',
            publicationDate: '2022-01-10'
        },
        {
            id: 2,
            title: 'الذكاء الاصطناعي للجميع',
            authors: ['سارة محمد'],
            type: 'AI',
            coverImage: 'https://via.placeholder.com/300x400.png?text=كتاب+2',
            publisher: 'دار التقنية',
            publicationDate: '2023-05-15'
        },
        {
            id: 3,
            title: 'تطوير مواقع الويب الحديث',
            authors: ['خالد يوسف', 'ريم عبدالله'],
            type: 'Web Development',
            coverImage: 'https://via.placeholder.com/300x400.png?text=كتاب+3',
            publisher: 'دار البرمجة',
            publicationDate: '2021-09-20'
        },
        {
            id: 4,
            title: 'تطوير مواقع الويب الحديث',
            authors: ['خالد يوسف', 'ريم عبدالله'],
            type: 'Web Development',
            coverImage: 'https://via.placeholder.com/300x400.png?text=كتاب+3',
            publisher: 'دار البرمجة',
            publicationDate: '2021-09-20'
        },
        {
            id: 5,
            title: 'تطوير مواقع الويب الحديث',
            authors: ['خالد يوسف', 'ريم عبدالله'],
            type: 'Web Development',
            coverImage: 'https://share.google/images/53XxOzW69Ln8bWHDj',
            publisher: 'دار البرمجة',
            publicationDate: '2021-09-20'
        }
    ]
}" class="space-y-4 w-full">
    <!-- البحث + الفلاتر -->
    <div class="flex items-center gap-2 w-full relative">
        <!-- شريط البحث -->
        <x-forms.input type="search" x-model="search" placeholder="ابحث عن كتاب..." icon="search" class="flex-1" />

        <!-- زر الفلاتر -->
        <button @click="showFilters = !showFilters"
            class="p-2 rounded-full border border-border bg-card hover:bg-accent/20 transition relative z-20">
            <x-icons.filter-icon class="h-5 w-5 text-foreground" />
        </button>
    </div>

    <!-- قائمة الفلاتر -->
    <div x-show="showFilters" x-transition class="flex justify-center gap-2 flex-wrap mt-2">
        <template x-for="filter in ['All', 'Programming', 'AI', 'Web Development', 'Science']" :key="filter">
            <button @click="activeFilter = filter; showFilters = false"
                class="px-3 py-1.5 text-xs md:text-sm font-semibold rounded-full border transition
                       :class="activeFilter === filter ? 'bg-primary text-primary-foreground' : 'bg-card text-muted-foreground hover:bg-accent/20'\">
                <span x-text="filter"></span>
            </button>
        </template>
    </div>

    <!-- شبكة الكتب -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        <template x-for="book in books.filter(b =>
            (activeFilter === 'All' || b.type === activeFilter) &&
            b.title.toLowerCase().includes(search.toLowerCase())
        )" :key="book.id">
            <div class="group relative overflow-hidden rounded-xl bg-card shadow-md p-4 hover:shadow-lg transition">
                <!-- صورة الغلاف -->
                <div class="w-full h-48 overflow-hidden rounded-md">
                    <img :src="book.coverImage" :alt="book.title + ' cover'"
                        class="w-full h-full object-cover object-center hover:scale-105 transition-transform duration-200">
                </div>

                <!-- عنوان الكتاب والمؤلفين -->
                <div class="mt-2">
                    <h3 class="text-md font-semibold line-clamp-2 group-hover:text-primary transition-colors" x-text="book.title"></h3>
                    <p class="text-sm text-muted-foreground" x-text="'by ' + book.authors.join(', ')"></p>
                </div>

                <!-- ناشر وتاريخ النشر -->
                <div class="flex justify-between text-xs text-muted-foreground mt-2">
                    <span x-text="book.publisher"></span>
                    <span x-text="new Date(book.publicationDate).toLocaleDateString()"></span>
                </div>

                <!-- زر التحميل -->
                <div class="flex justify-end mt-3">
                    <button @click="alert('تحميل: ' + book.title)"
                        class="bg-primary text-white px-3 py-1.5 rounded-md hover:bg-primary/70 text-sm">
                        تحميل
                    </button>
                </div>

                <!-- تأثير الهور Hover Accent -->
                <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-primary to-purple-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            </div>
        </template>

        <template x-if="books.filter(b =>
            (activeFilter === 'All' || b.type === activeFilter) &&
            b.title.toLowerCase().includes(search.toLowerCase())
        ).length === 0">
            <p class="text-center text-muted-foreground col-span-full py-10">📚 لم تجد أي كتب مطابقة.</p>
        </template>
    </div>
</div>
