<?php

namespace App\Models;

use App\Casts\MoneyCast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Treatment extends Model
{
     /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'description',
        'notes',
        'patient_id',
        'price',
    ];

    protected $casts = [
        'price' => MoneyCast::class,
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
