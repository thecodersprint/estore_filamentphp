<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'ip_address',
        'first_name',
        'last_name',
        'email',
        'phone',
        'shipping_address_id',
        'shipping_id',
        'payment_method',
        'payment_status',
        'status',
        'coupon_id',
        'sub_total',
        'discount',
        'total_amount',
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }
    public static function countActiveOrder()
    {
        $data = Order::count();
        if ($data) {
            return $data;
        }
        return 0;
    }
    public function cart()
    {
        return $this->hasMany(Cart::class);
    }


    public function getCustomerNameAttribute()
    {
        if (!$this->user?->exists) {
            return $this->user->name;
        }else{
            return $this->first_name . '' . $this->last_name;
        }
    }

    public function getCustomerEmailAttribute()
    {
        if (!$this->user?->exists) {
            return $this->user->email;
        }else{
            return $this->email;
        }
    }

    public function getCustomerAddressAttribute()
    {
        if (!$this->user?->exists) {
            return $this->user->email;
        }else{
            return $this->email;
        }
    }
    public function shipping()
    {
        return $this->belongsTo(Shipping::class, 'shipping_id');
    }

    public function shippingAddress()
    {
        return $this->belongsTo(UserAddress::class, 'shipping_address_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon_id');
    }
    public static function countNewReceivedOrder()
    {
        $data = Order::where('status', 'new')->count();
        return $data;
    }
    public static function countProcessingOrder()
    {
        $data = Order::where('status', 'processing')->count();
        return $data;
    }
    public static function countOutForDeliveryOrder()
    {
        $data = Order::where('status', 'out for delivery')->count();
        return $data;
    }
    public static function countDeliveredOrder()
    {
        $data = Order::where('status', 'delivered')->count();
        return $data;
    }
    public static function countCancelledOrder()
    {
        $data = Order::where('status', 'cancel')->count();
        return $data;
    }
}
