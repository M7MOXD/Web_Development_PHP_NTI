<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Person extends Authenticatable
{
    use HasFactory;
    protected $table = 'persons';
    protected $fillable = ['name', 'email', 'password'];
    public $timestamps = false;
}
