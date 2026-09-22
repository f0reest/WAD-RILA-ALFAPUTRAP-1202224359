<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkshopLocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'partner_id',
        'name',
        'city',
        'address',
        'latitude',
        'longitude',
        'is_active',
    ];

    public function partner()
    {
        return $this->belongsTo(WorkshopPartner::class, 'partner_id');
    }

    public function subscriptions()
    {
        return $this->hasMany(WorkshopSubscription::class, 'location_id');
    }
}
