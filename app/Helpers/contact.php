<?php

use App\Models\ContactGeneral;

function getStep(ContactGeneral $contactGeneral = null): float
{
    // step 1
    if ($contactGeneral == null) {
        return 1;
    }

    // step 2
    if ($contactGeneral->company == null && $contactGeneral->type == 'company') {
        return 2;
    }
    if ($contactGeneral->person == null && $contactGeneral->type == 'person') {
        return 2.5;
    }

    // step 3
    if($contactGeneral->detail == null){
        return 3;
    }

    // step 4
    return 4;
}
