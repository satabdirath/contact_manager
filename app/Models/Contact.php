<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{

    protected $fillable = [
        'name',
        'email',
        'phone',
        'gender',
        'profile_image',
        'additional_file',
        // add other fields if needed
    ];
    public function customFieldValues()
{
    return $this->hasMany(CustomFieldValue::class);
}

public function mergedInto()
{
    return $this->belongsTo(Contact::class, 'merged_into');
}

}
