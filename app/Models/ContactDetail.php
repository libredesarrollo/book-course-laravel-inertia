<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactDetail extends Model
{
    use HasFactory;

    protected $table='contact_optionals';

    protected $fillable = ['extra', 'contact_general_id'];

    function general(): BelongsTo
    {
        return $this->belongsTo(ContactGeneral::class);
    }
}
