<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    public function customFieldValues()
{
    return $this->hasMany(CustomFieldValue::class);
}

public function mergedInto()
{
    return $this->belongsTo(Contact::class, 'merged_into');
}

}
