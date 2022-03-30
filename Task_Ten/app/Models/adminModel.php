<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class adminModel extends Authenticatable
{
    use HasFactory;
    protected $table = 'admin';
    protected $fillable = ['name', 'email', 'password'];
}
