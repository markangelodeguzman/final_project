<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patron extends Model
{
    use HasFactory;

    protected $table = 'patron';
    protected $primaryKey = 'patron_id';
    public $timestamps = false;

    protected $fillable = ['first_name', 'last_name', 'contact_number', 'email', 'address', 'account_status'];
}