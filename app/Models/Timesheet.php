<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timesheet extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'timesheet_status_id',
        'amount',
        'note',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class)->withTrashed();
    }

    public function timesheetStatus()
    {
        return $this->belongsTo(TimesheetStatus::class);
    }

    public function paymentPeriods()
    {
        return $this->belongsToMany(PaymentPeriod::class, 'payment_period_timesheet')->withTimestamps();
    }
}
