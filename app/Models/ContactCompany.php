<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactCompany extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'identification', 'contact_general_id', 'choices', 'extra'];

    function general(): BelongsTo
    {
        return $this->belongsTo(ContactGeneral::class, 'contact_general_id');
    }
}
