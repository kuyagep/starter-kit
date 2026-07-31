<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class School extends Model
{
    use HasUlids;

    protected $fillable = ['name', 'school_code', 'district_id'];

    /**
     * Get the parent district jurisdiction overseeing this facility.
     */
    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }
}
