<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomAttribute extends Model
{
    protected $fillable = ['contact_id', 'key', 'value'];

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }
}
