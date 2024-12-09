<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notebook extends Model
{
    use HasFactory;
    protected $fillable = [
        'fio',
        'company',
        'phone',
        'email',
        'date_of_birth',
        'photo',
    ];
}
