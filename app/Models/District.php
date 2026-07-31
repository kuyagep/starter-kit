<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class District extends Model
{
    use HasUlids;

    protected $fillable = ['name', 'code'];

    /**
     * Get all schools managed under this district jurisdiction.
     */
    public function schools(): HasMany
    {
        return $this->hasMany(School::class);
    }
}
