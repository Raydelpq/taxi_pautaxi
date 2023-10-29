<?php

namespace App\Models;

use App\Models\User;
use App\Models\Taxista;
use App\Models\Comercial;
use Laravel\Fortify\Fortify;
use App\Models\Administrador;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Support\Facades\Hash;
use Laravel\Jetstream\HasProfilePhoto;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements HasMedia 
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;
    use InteractsWithMedia;
    use SoftDeletes;
    

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];


    /**
     * Send the password reset notification.
     *
     * @param string $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * Get the comercial associated with the comercial
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function comercial(): HasOne 
    {
        if($this->hasRole('Administrador'))
            return $this->hasOne(Administrador::class,'user_id')->withTrashed();

        return $this->hasOne(Comercial::class,'user_id')->withTrashed();
    }

    /**
     * Get the taxista associated with the taxista
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function taxista(): HasOne
    {
        return $this->hasOne(Taxista::class)->withTrashed();
    }

    /**
     * Get the comercial associated with the comercial
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function tipo(): HasOne
    {
        return $this->taxista ? $this->taxista : $this->comercial;
    }

}
