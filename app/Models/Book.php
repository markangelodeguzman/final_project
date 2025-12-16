<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $table = 'book';
    protected $primaryKey = 'book_id';
    public $timestamps = false; // Assuming your custom DB doesn't have created_at/updated_at

    protected $fillable = ['title', 'author', 'isbn', 'category_id', 'condition', 'location', 'availability_status'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function borrows()
    {
        return $this->hasMany(Borrow::class, 'book_id');
    }
}