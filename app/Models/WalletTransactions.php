<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WalletTransactions extends Model
{
    protected $table = 'wallet_transactions';
    protected $fillable = [
        'user_id',
        'amount',
        'type',
        'description',
        'status',
        'transaction_id',
        'transaction_data',
        'created_at',
        'updated_at',
    ];
    protected $casts = [
        'transaction_data' => 'array',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    protected $hidden = [
        'updated_at',
    ];
    protected $appends = [
        'created_at_human',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getCreatedAtHumanAttribute()
    {
        return $this->created_at->diffForHumans();
    }
}
