<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocumentTrail extends Model
{
    use HasUlids;

    protected $fillable = [
        'document_id',
        'action_by_user_id',
        'office_id',
        'action',
        'remarks'
    ];

    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function office(): BelongsTo
    {
        return $this->belongsTo(Office::class);
    }
}
