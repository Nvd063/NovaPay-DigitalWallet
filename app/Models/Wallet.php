<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $fillable = [
        'user_id',
        'balance',
        'card_number',
        'expiry_date',
        'card_holder_name'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}