<?php

namespace Database\Factories;

use Ahmed\GalleryImages\Models\Photo;
use App\Models\Blog;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BlogFactory extends Factory
{
    protected $model = Blog::class;

    public function definition()
    {
        $title = $this->faker->sentence();
        $content = $this->faker->paragraph();
        $content_en = \Faker\Factory::create('en_US')->paragraph();

        return [
            'admin_id' => 1,
            'views' => $this->faker->numberBetween(0, 1000),
            'content' => [
                'ar' => $content,
                'en' => $content_en,
            ],
            'slug' => Str::slug($title),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Blog $blog) {
            $fakerEn = \Faker\Factory::create('en_US');
            $fakerAr = \Faker\Factory::create('ar_SA');

            $translations = [
                'en' => [
                    'title' => $fakerEn->sentence(),

                    'excerpt' => $fakerEn->text(100),
                ],
                'ar' => [
                    'title' => $fakerAr->sentence(),
                    'excerpt' => $fakerAr->text(100),
                ],
            ];

            foreach ($translations as $locale => $data) {
                $blog->updateTranslations($data, $locale);
            }

            $blog->syncPhotosById(Photo::inRandomOrder()->limit(1)->pluck('id')->toArray());
        });
    }
}
