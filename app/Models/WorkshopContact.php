<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkshopContact extends Model
{
    use HasFactory;

    protected $fillable = [
        'partner_id',
        'name',
        'position',
        'phone',
        'email',
        'is_primary',
    ];

    public function partner()
    {
        return $this->belongsTo(WorkshopPartner::class, 'partner_id');
    }

    public function subscriptions()
    {
        return $this->hasMany(WorkshopSubscription::class, 'contact_id');
    }
}
