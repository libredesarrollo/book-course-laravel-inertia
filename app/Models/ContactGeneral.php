<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ContactGeneral extends Model
{
    use HasFactory;

    protected $fillable = ['subject', 'message', 'type'];

    // protected $with = ['company'];

    function person(): HasOne
    {
        return $this->hasOne(ContactPerson::class);
    }
    function company(): HasOne
    {
        return $this->hasOne(ContactCompany::class);
    }
    function detail(): HasOne
    {
        return $this->hasOne(ContactDetail::class);
    }
}
