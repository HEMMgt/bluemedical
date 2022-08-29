<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    public function setIdentifierAttribute($value)
    {
        $this->attributes['identifier'] = strtoupper($value);
    }
    protected $fillable = [
        'car_id',
        'identifier',
        'minutes',
        'price',
        'paid',
        'user_id',
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'user_id',
        "car_id",
        "id",
    ];
    /*
    Relations
    */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}
