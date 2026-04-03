<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'full_name',
        'phone',
        'mpin',
        'status',
    ];

    protected $hidden = [
        'mpin',
        'remember_token',
    ];

    // Relations
    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function beneficiaries()
    {
        return $this->hasMany(Beneficiary::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
    public function virtualCards()
    {
        return $this->hasMany(VirtualCard::class);
    }
}