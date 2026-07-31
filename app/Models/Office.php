<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Office extends Model
{
    use HasUlids;

    protected $fillable = [
        'name',
        'code',
        'office_type',
        'school_id'
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    // Quick structural checks
    public function isSchool(): bool
    {
        return $this->office_type === 'School';
    }
    public function isDistrict(): bool
    {
        return $this->office_type === 'District';
    }
    public function isDivision(): bool
    {
        return $this->office_type === 'Division Office';
    }
}
