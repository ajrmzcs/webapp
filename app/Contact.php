<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contact extends Model
{

    protected $fillable = ['team_id', 'name', 'phone', 'email', 'sticky_phone_number_id'];

    public function customAttributes(): HasMany
    {
        return $this->hasMany(CustomAttribute::class);
    }

}
