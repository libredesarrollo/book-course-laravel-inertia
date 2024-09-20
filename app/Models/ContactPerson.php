<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactPerson extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'surname', 'contact_general_id', 'choices', 'other'];

    protected $table = 'contact_persons';

    function general(): BelongsTo
    {
        return $this->belongsTo(ContactGeneral::class);
    }
}
