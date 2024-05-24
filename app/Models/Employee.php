<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Employee extends Model
{
    use HasFactory;
    protected $fillable = [ 
        'userName',
        'role',
        'first',
        'middle',
        'last',
        'name',
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
        'created_by',
        'edited_by',
        'eStatus',
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);    
    }
    public function image(): HasOne
    {
        return $this->hasOne(Image::class);    
    }
    public function payroll(): HasMany
    {
        return $this->hasMany(Payroll::class);    
    }
    public function qr(): HasMany
    {
        return $this->hasMany(QRLogin::class);    
    }
}
