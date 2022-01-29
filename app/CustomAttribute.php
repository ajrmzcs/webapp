<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomAttribute extends Model
{

    protected $fillable = ['contact_id', 'key', 'value'];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

}
