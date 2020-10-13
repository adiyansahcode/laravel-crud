<?php

declare(strict_types=1);

use App\Models\Book;
use App\Models\BookImg;
use App\Models\Author;
use App\Models\Category;
use App\Models\Language;
use App\Models\Publisher;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Author::class, 100)->create();
        factory(Language::class, 10)->create();
        factory(Publisher::class, 100)->create();
        factory(Category::class, 100)->create();
        factory(Book::class, 5)
            ->create()
            ->each(function ($book) {

            $language = Language::all()->random();
            $book->language()->associate($language);

            $publisher = Publisher::all()->random();
            $book->publisher()->associate($publisher);

            $category = Category::all()->random();
            $book->category()->associate($category);

            $author = Author::all();
            $book->author()->attach(
                $author->random(rand(1, 3))->pluck('id')->toArray()
            );

            $bookImg = factory(BookImg::class, 2)->create();
            $book->BookImg()->saveMany($bookImg);

            $book->save();
        });
    }
}
