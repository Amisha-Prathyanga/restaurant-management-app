<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Concession extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 
        'description', 
        'image', 
        'price', 
        'status'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'created_at' => 'datetime',
    ];

    // Validation rules
    public static function rules($id = null)
    {
        return [
            'name' => [
                'required', 
                'string', 
                'max:255', 
                'unique:concessions,name,' . $id
            ],
            'description' => 'nullable|string|max:1000',
            'image' => [
                'nullable', 
                'image', 
                'mimes:jpeg,png,jpg,gif', 
                'max:2048'
            ],
            'price' => [
                'required', 
                'numeric', 
                'min:0', 
                'max:9999.99'
            ],
            'status' => 'in:active,inactive'
        ];
    }

    // Relationships (if needed)
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_concessions');
    }

    // Image handling
    public function getImageUrlAttribute()
    {
        return $this->image 
            ? asset('storage/' . $this->image) 
            : asset('images/default-concession.png');
    }
}
