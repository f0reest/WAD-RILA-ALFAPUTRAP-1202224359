<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkshopSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'partner_id',
        'location_id',
        'contact_id',
        'service_type_id',
        'subscription_code',
        'status',
        'starts_at',
        'ends_at',
        'monthly_fee',
        'notes',
    ];

    protected $casts = [
        'starts_at' => 'date',
        'ends_at' => 'date',
        'monthly_fee' => 'decimal:2',
    ];

    public function partner()
    {
        return $this->belongsTo(WorkshopPartner::class, 'partner_id');
    }

    public function location()
    {
        return $this->belongsTo(WorkshopLocation::class, 'location_id');
    }

    public function contact()
    {
        return $this->belongsTo(WorkshopContact::class, 'contact_id');
    }

    public function serviceType()
    {
        return $this->belongsTo(WorkshopServiceType::class, 'service_type_id');
    }
}
