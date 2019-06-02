<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['pickup_id', 'customer_id', 'address_id','runner_id', 'store_id', 'status',
 							'estimated_price', 'gst','cgst','total_price', 'coupon_id', 'coupon_discount', 'delivery_runner_id', 'date_of_arrival', 'discount', 'service_id', 'weight', 'delivery_mode'];
 	protected $dates = ['date_of_arrival', 'created_at', 'modified_at'];
 	public function items(){
 		return $this->hasMany('App\Model\OrderItems', 'order_id', 'id');
 	}

 	public function customer(){
 		return $this->hasOne('App\User', 'id', 'customer_id');
 	}

    public function store(){
        return $this->hasOne('App\User', 'id', 'store_id');
    }

 	public function address(){
 		return $this->hasOne('App\Model\Address', 'id', 'address_id');
 	}

 	public function service(){
 		return $this->hasOne('App\Model\Service', 'id', 'service_id');
 	}

 	public function getCustomerPhoneNumberAttribute(){
 		if ($this->customer()->count()) 
        {
            return $this->customer()->first()->phone_number;
        }
        return "--";
 	}
 	public function getCustomerNameAttribute(){
 		if ($this->customer()->count()) 
        {
            return $this->customer()->first()->name;
        }
        return "--";
 	}

 	public function getCustomerAddressAttribute(){
 		if ($this->address()->count()) 
        {
            return $this->address()->first()->address;
        }
        return "--";
 	}

 	public function getCustomerServiceAttribute(){
 		if ($this->service()->count()) 
        {
            return $this->service()->first()->name;
        }
        return "--";
 	}

    public function getServiceShortNameAttribute(){
        if ($this->service()->count()) 
        {
            if ($this->service()->first()->short_code != null) {
                return $this->service()->first()->short_code;
            }
            return $this->service()->first()->name;
        }
        return "--";
    }

 							
}
