<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Administrator extends Model
{
    protected $table = 'administrator';
    protected $primaryKey = 'admin_id';
    public $timestamps = false;
    protected $fillable = ['first_name', 'last_name', 'contact_info'];
}