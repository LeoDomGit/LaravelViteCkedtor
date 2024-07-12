<?php

namespace Leo\ServicesCollections\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Leo\Products\Models\Products;

class ServicesCollections extends Model
{
    use HasFactory;
    protected $table='service_collections';
    protected $fillable=['id','name','slug','status','created_at','updated_at'];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

}
