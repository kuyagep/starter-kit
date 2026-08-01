<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Yajra\Address\HasAddress;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles, HasUlids, HasAddress;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        // Step 1: Personal Profile Info
        'prefix',
        'first_name',
        'middle_name',
        'last_name',
        'suffix',
        'name',
        'email',
        'mobile_number',
        'birthdate',
        'gender',
        'religion',
        'disability',
        'ethnic_group',

        // Step 2: Address Structural Identifiers
        'province_id',
        'city_id',
        'barangay_id',
        'street', // Used for your $request->purok, street value

        // Step 3: Application Access Rules
        'username',
        'password',
        'status',
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function office(): BelongsTo
    {
        return $this->belongsTo(Office::class);
    }
}
