<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'created_by',
        'queue_number',
        'status',
        'appoint,emt_type'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function receptionist()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}