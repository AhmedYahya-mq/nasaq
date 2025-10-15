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

        $sitemap = Sitemap::create();

        // 🔹 جلب المقالات العربية
        $blogs = Blog::all();

        foreach ($blogs as $blog) {
            try {
                $sitemap->add(
                    Url::create(route('client.blog.details', ['blog' => $blog->slug]))
                        ->setLastModificationDate($blog->updated_at)
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                        ->setPriority(0.8)
                );
                $sitemap->add(
                    Url::create(route('client.locale.blog.details', ['blog' => $blog->slug, 'locale' => 'en']))
                        ->setLastModificationDate($blog->updated_at)
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                        ->setPriority(0.8)
                );
            } catch (\Exception $e) {
                $this->warn("تخطي المقال: {$blog->slug}");
            }
        }


        $index = SitemapIndex::create()
            ->add(url('/sitemaps/sitemap-ar.xml'))
            ->add(url('/sitemaps/sitemap-blogs.xml'))
            ->add(url('/sitemaps/sitemap-en.xml'));
        $index->writeToFile(public_path('sitemap.xml'));

        $this->info('✅ تم إنشاء sitemap-blogs.xml بنجاح!');
    }
}
