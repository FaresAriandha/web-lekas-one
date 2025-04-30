<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, HasUlids;

    protected $primaryKey = 'user_ID';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'courier_ID',
        'user_name',
        'username',
        'password',
        'user_role',
        'user_img',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'user_ID' => 'string',
    ];

    public function getAuthIdentifierName()
    {
        return 'user_ID';
    }


    public function courier()
    {
        return $this->belongsTo(Courier::class, 'courier_ID', 'courier_ID');
    }
}
