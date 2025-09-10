<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Notifications\EmailVerificationNotification;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;

class User extends Authenticatable implements \Illuminate\Contracts\Auth\MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

    // خاصية داخلية تحدد الـ guard
    protected $guard = 'web';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'photo',
        'phone',
        'birthday',
        'address',
        'job_title',
        'bio',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The accessors to append to the model's array form.
     * @var array{0: 'profile_photo_url'}
     */
    protected $appends=[
        'profile_photo_url',
    ];

    /**
     * Get the user's profile photo URL.
     *
     * @return string
     */
    public function getProfilePhotoUrlAttribute()
    {
        if (empty($this->photo)) {
            return "https://ui-avatars.com/api/?name=" . urlencode($this->name) . "&bold=true&format=svg";
        }
        return asset('storage/' . $this->photo);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'two_factor_confirmed_at' => 'datetime',
            'birthday' => 'date',
        ];
    }


    /**
     * Override the default password reset notification
     *
     * @param string $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * Override the default password reset notification
     *
     * @param string $token
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new EmailVerificationNotification());
    }

    /**
     * Get the guard name attribute.
     * @return string
     */
    public function getGuardNameAttribute(): string
    {
        return $this->guard;
    }

    /**
     * Get the two factor QR code SVG attribute.
     * @return null|string
     * @throws BindingResolutionException
     * @throws InvalidArgumentException
     */
    public function getTwoFactorQrCodeSvgAttribute(): ?string
    {
        if (! $this->two_factor_secret) {
            return null;
        }
        return $this->twoFactorQrCodeSvg();
    }

    /**
     * Get the two factor recovery codes as an array.
     * @return null|array
     * @throws BindingResolutionException
     */
    public function getTwoFactorRecoveryCodesArrayAttribute(): ?array
    {
        if (!$this->two_factor_recovery_codes) {
            return null;
        }
        return json_decode(decrypt($this->two_factor_recovery_codes), true);
    }

    /**
     * Get the two factor enabled attribute.
     * @return bool
     */
    public function getTwoFactorEnabledAttribute(): bool
    {
        return $this->hasEnabledTwoFactorAuthentication();
    }

    /**
     * Get the two factor secret key attribute.
     * @return string
     * @throws BindingResolutionException
     * @throws RuntimeException
     */
    public function getTwoFactorSecretKeyAttribute()
    {
        if (! $this->two_factor_secret) {
            return null;
        }
        return decrypt($this->two_factor_secret);
    }
}
