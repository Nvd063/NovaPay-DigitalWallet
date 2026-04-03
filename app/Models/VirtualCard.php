<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VirtualCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'card_number',
        'card_holder_name',
        'expiry_date',
        'cvv',
        'spending_limit',
        'is_selected',
        'status'
    ];

    /**
     * Relationship: Card belongs to a User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}