<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'payment_type_id',
        'pay_rate',
        'customer_id',
    ];

    protected $dates = [ 'deleted_at' ];

    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function timesheets()
    {
        return $this->hasMany(Timesheet::class);
    }
}
