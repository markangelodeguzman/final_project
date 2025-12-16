<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penalty extends Model
{
    use HasFactory;

    protected $table = 'penalty';
    protected $primaryKey = 'penalty_id';
    public $timestamps = false;

    protected $fillable = ['borrow_id', 'amount', 'date_applied', 'remarks'];
}