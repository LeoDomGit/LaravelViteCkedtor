<?php

namespace Leo\Services\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceBillsDetails extends Model
{
    use HasFactory;
    protected $table = 'service_bill_details';
    protected $fillable = ['id_bill', 'id_service', 'id_booking', 'created_at', 'updated_at'];

    public function service_bills()
    {
        return $this->belongsTo(ServiceBills::class, 'id_bill');
    }

    public function service()
    {
        return $this->belongsTo(Services::class, 'id_service');
    }
}