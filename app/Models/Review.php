<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'reviews';

    protected $guarded = [];


    public function user() {
        return $this->belongsTo(User::class,'user_id');
    }
    public function book() {
        return $this->belongsTo(Book::class,'book_id');
    }

}
