<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'start',
        'message',
    ];

    protected function setKeysForSaveQuery($query)
    {
        $query
            ->where('user_id', '=', $this->getAttribute('user_id'))
            ->where('book_id', '=', $this->getAttribute('book_id'))
            ->where('start', '=', $this->getAttribute('start'));


        return $query;
    }

    public function books() { 
        return $this->belongsTo(book::class, 'book_id', 'book_id'); // honnan -> hová
    }
    
    public function users() {
        return $this->belongsTo(User::class, 'user_id', 'id'); // honnan -> hová
    }
    
    public function users2() {
        return $this->belongsTo(User::class, 'user_id', 'id'); // honnan -> hová
    }
    
    

}
