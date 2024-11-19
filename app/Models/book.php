<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class book extends Model
{
    use HasFactory;

    // új elsődleges kulcs
    protected $primaryKey = 'book_id';

    protected $fillable = [
        'author',
        'title',
        'pieces',
    ];

    public function copies() {
        return $this->hasMany(copy::class, 'book_id', 'book_id');
    }
}
