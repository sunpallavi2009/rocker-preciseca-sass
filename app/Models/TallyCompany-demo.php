<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TallyCompany extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'data' => 'array', // This will cast the JSON data to an array when accessing
    ];
}
