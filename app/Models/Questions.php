<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Questions extends Model
{
    protected $fillable = [
        'question',
        'type',
        'difficulty',
        'options',
        'answer',
        'category_id',
        'uuid',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    protected $casts = [
        'category_id' => 'integer',
        'options' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
