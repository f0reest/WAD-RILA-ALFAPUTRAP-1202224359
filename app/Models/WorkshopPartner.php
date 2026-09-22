<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkshopPartner extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'email',
        'phone',
        'address',
        'city',
        'is_active',
    ];

    public function locations()
    {
        return $this->hasMany(WorkshopLocation::class, 'partner_id');
    }

    public function contacts()
    {
        return $this->hasMany(WorkshopContact::class, 'partner_id');
    }

    public function subscriptions()
    {
        return $this->hasMany(WorkshopSubscription::class, 'partner_id');
    }
}
