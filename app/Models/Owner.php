<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Owner extends Model {
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
    * The attributes that are mass assignable.
    *
    * @var list<string>
    */
    protected $fillable = [
        'email',
        'name',
        'phone',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function setPhoneAttribute( $value ) {
        $value = preg_replace( '/[^0-9]/', '', $value );

        if ( str_starts_with( $value, '0' ) ) {
            $value = '62' . substr( $value, 1 );
        } elseif ( !str_starts_with( $value, '62' ) ) {
            $value = '62' . $value;
        }

        $this->attributes[ 'phone' ] = $value;
    }

    public function getPhoneAttribute( $value ) {
        // Jika data di DB diawali 62, hilangkan 62 agar user isi ulang bagian belakangnya saja
        if ( str_starts_with( $value, '62' ) ) {
            return substr( $value, 2 );
            // tampilkan hanya angka setelah 62
        }

        return $value;
    }

    public function patients() {
        return $this->hasMany( Patient::class );
    }
}
