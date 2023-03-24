<?php

namespace App\Models;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordReser extends Model
{
    protected $table = 'password_reset';
    protected $guarded = [];

const UPDATED_AT = null;
    use HasFactory;
}
