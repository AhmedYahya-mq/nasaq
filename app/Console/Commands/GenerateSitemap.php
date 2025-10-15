<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Blog;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapIndex;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'إنشاء Sitemap للمدونة';

    public function handle()
    {
        $this->info('🚀 بدء إنشاء Sitemap للمدونة...');

        $sitemapsPath = public_path('sitemaps');
        if (!is_dir($sitemapsPath)) {
            mkdir($sitemapsPath, 0755, true);
        }

        $blogs = Blog::all();
        $sitemapFile = $sitemapsPath . '/sitemap-blogs.xml';

        if ($blogs->isEmpty()) {
            // إنشاء ملف XML فارغ تمامًا
            $emptyXml = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"></urlset>';
            file_put_contents($sitemapFile, $emptyXml);
            $this->info('⚠️ جدول المدونات فارغ، تم إنشاء Sitemap فارغ.');
        } else {
            $sitemapBlogs = Sitemap::create();

            foreach ($blogs as $blog) {
                try {
                    $sitemapBlogs->add(
                        Url::create(route('client.blog.details', ['blog' => $blog->slug]))
                            ->setLastModificationDate($blog->updated_at)
                            ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                            ->setPriority(0.8)
                    );
                    $sitemapBlogs->add(
                        Url::create(route('client.locale.blog.details', ['blog' => $blog->slug, 'locale' => 'en']))
                            ->setLastModificationDate($blog->updated_at)
                            ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                            ->setPriority(0.8)
                    );
                } catch (\Exception $e) {
                    $this->warn("تخطي المقال: {$blog->slug}");
                }
            }

            $sitemapBlogs->writeToFile($sitemapFile);
            $this->info("✅ تم تحديث Sitemap المدونة: $sitemapFile");
        }

        // تحديث Sitemap الرئيسي
        $index = SitemapIndex::create()
            ->add(url('/sitemaps/sitemap-ar.xml'))
            ->add(url('/sitemaps/sitemap-blogs.xml'))
            ->add(url('/sitemaps/sitemap-en.xml'));

        $index->writeToFile($sitemapsPath . '/sitemap.xml');
        $this->info('✅ تم تحديث الـ sitemap الرئيسي بنجاح!');
    }
}
