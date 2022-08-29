<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;
    //transform information
    public function setIdentifierAttribute($value)
    {
        $this->attributes['identifier'] = strtoupper($value);
    }
    
    protected $fillable = [
        'id',
        'identifier',
        'type_id',
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        "type_id",
        "id",
    ];
    /**
     * Relations with another models
     */
    public function records()
    {
        return $this->hasMany(Record::class);
    }
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
    public function type()
    {
        return $this->belongsTo(Type::class);
    }
}
