<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomFieldValue extends Model
{
    public function contact()
{
    return $this->belongsTo(Contact::class);
}

public function customField()
{
    return $this->belongsTo(CustomField::class);
}

}
