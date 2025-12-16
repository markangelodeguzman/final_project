<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    protected $table = 'system_setting';
    protected $primaryKey = 'setting_key';
    public $incrementing = false; // Key is string
    public $timestamps = false;
    protected $fillable = ['setting_key', 'setting_value'];
}