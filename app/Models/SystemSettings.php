<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemSettings extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'value',
        'previous_value', 
        'other', 
    ];

    protected $casts = [
        'id' => 'int',
    ];
}
