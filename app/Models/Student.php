<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;


class Student extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table ="students";

    protected $guarded = ['id'];

    public $timestamps = false;
}
