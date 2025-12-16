<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Librarian extends Model
{
    use HasFactory;

    protected $table = 'librarian';
    protected $primaryKey = 'librarian_id';
    public $timestamps = false;

    protected $fillable = ['first_name', 'last_name', 'contact_info'];
}