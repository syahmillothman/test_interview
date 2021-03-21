<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Complete extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $table = 'is_complete';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
}
