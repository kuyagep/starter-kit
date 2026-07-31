<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Document extends Model
{
    use HasUlids;



    public function trails(): HasMany
    {
        return $this->hasMany(DocumentTrail::class)->orderBy('created_at', 'desc');
    }
}
