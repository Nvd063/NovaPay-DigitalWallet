<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'tx_id',
        'type',
        'amount',
        'fee',
        'recipient_detail',
        'status'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}