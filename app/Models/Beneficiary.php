<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Beneficiary extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'bank_name',
        'account_number'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}