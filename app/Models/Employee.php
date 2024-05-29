<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Employee extends Model
{
    use HasFactory;
    protected $fillable = [ 
        'user_name',
        'role',
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'phone',
        'status',
        'job',
        'sss',
        'philhealth',
        'address',
        'eName',
        'ePhone',
        'eAdd',
        'eStatus',
    ];
    public function image(): HasOne
    {
        return $this->hasOne(Image::class);    
    }
    public function user(): HasOne
    {
        return $this->hasOne(User::class);    
    }
    public function payroll(): HasMany
    {
        return $this->hasMany(Payroll::class);    
    }
    public function qr(): HasMany
    {
        return $this->hasMany(QR::class);    
    }
}
