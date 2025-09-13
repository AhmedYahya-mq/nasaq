<?php

namespace Database\Factories;

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
        $excerpt = $this->faker->text(100);

        return [
            'admin_id' => 1,
            'views' => $this->faker->numberBetween(0, 1000),
            'featured_image' => $this->faker->imageUrl(800, 600),
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
                    'content' => $fakerEn->paragraph(),
                    'excerpt' => $fakerEn->text(100),
                ],
                'ar' => [
                    'title' => $fakerAr->sentence(),
                    'content' => $fakerAr->paragraph(),
                    'excerpt' => $fakerAr->text(100),
                ],
            ];

            foreach ($translations as $locale => $data) {
                $blog->updateTranslations($data, $locale);
            }
        });
    }
}
