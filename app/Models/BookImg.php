<?php

declare(strict_types=1);

namespace App\Models;

class BookImg extends \App\Models\BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'book_img';

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
        'name',
        'description',
        'book_id',
    ];

    public function book()
    {
        return $this->belongsTo('App\Models\Book', 'id');
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
