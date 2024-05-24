<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Payroll extends Model
{
    use HasFactory;
    protected $fillable = [
        'pay_id',
        'userName',
        'employee_id',
        'name',
        'week_id',
        'month_id',
        'year_id',
        'week',
        'job',
        'rate',
        'days',
        'late',
        'salary',
        'rph',
        'hrs',
        'otpay',
        'holiday',
        'philhealth',
        'sss',
        'advance',
        'gross',
        'deduction',
        'net',
    ]; 
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);    
    }

    public function emp(): BelongsTo
    {
        return $this->belongsTo(Employee::class);    
    }
}
