<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    use HasFactory;

    protected $table = 'borrow';
    protected $primaryKey = 'borrow_id';
    public $timestamps = false;

    protected $fillable = [
        'book_id', 'patron_id', 'librarian_id', 
        'borrow_date', 'due_date', 'return_date', 'status'
    ];

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }

    public function patron()
    {
        return $this->belongsTo(Patron::class, 'patron_id');
    }
    
    public function penalty()
    {
        return $this->hasOne(Penalty::class, 'borrow_id');
    }
}