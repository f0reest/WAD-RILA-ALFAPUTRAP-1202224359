<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkshopServiceType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    public function subscriptions()
    {
        return $this->hasMany(WorkshopSubscription::class, 'service_type_id');
    }
}
