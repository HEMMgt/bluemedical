<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    use HasFactory;
    protected $fillable = [
        'car_id',
        'check_in',
        'check_out',
        'user_check_in',
        'user_check_out',
        'minutes',
        'completado',
        'user_id',
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'user_check_in',
        'user_check_out',
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
    public function userCheckIn()
    {
        return $this->belongsTo(User::class,'user_check_in','id');
    }
    public function userCheckOut()
    {
        return $this->belongsTo(User::class,'user_check_out','id');
    }
}
