<?php

declare(strict_types=1);

namespace App\Models;

class Book extends \App\Models\BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'book';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i:s';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'isbn',
        'title',
        'publication_date',
        'weight',
        'wide',
        'long',
        'page',
        'description',
        'publisher_id',
        'language_id',
        'category_id',
    ];

    public function bookImg()
    {
        return $this->hasMany('App\Models\BookImg', 'book_id');
    }

    public function publisher()
    {
        return $this->belongsTo('App\Models\Publisher', 'publisher_id')->withDefault(['name' => '']);
    }

    public function language()
    {
        return $this->belongsTo('App\Models\Language', 'language_id')->withDefault(['name' => '']);
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id')->withDefault(['name' => '']);
    }

    public function author()
    {
        return $this->belongsToMany('App\Models\Author', 'book_author', 'book_id', 'author_id');
    }

    public function getCreatedAtAttribute(string $value): string
    {
        return date("Y-m-d H:i:s", strtotime($value));
    }

    public function getUpdatedAtAttribute(string $value): string
    {
        return date("Y-m-d H:i:s", strtotime($value));
    }
}
