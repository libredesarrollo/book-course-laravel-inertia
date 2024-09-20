<?php

namespace App\Http\Controllers\Contact;

use App\Http\Controllers\Controller;
use App\Http\Requests\Contact\GeneralRequest;
use App\Models\ContactCompany;
use App\Models\ContactGeneral;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GeneralController extends Controller
{
    public function create()
    {
        Inertia::share('step', getStep());
        return inertia('Contact/General/Step');
    }

    public function store(GeneralRequest $request)
    {
        $contactGeneral = ContactGeneral::create($request->validated());
        return to_route('contact-general.edit', ['contact_general' => $contactGeneral->id]);
    }

    public function edit(ContactGeneral $contactGeneral)
    {
        // dd(ContactCompany::find(4)->general);
        Inertia::share('step', getStep($contactGeneral));

        // dd($contactGeneral->company);
        $contactGeneral->company;
        $contactGeneral->person;
        $contactGeneral->detail;

        if ($contactGeneral->company == null) {
            unset($contactGeneral->company);
        }
        if ($contactGeneral->person == null) {
            unset($contactGeneral->person);
        }
        if ($contactGeneral->detail == null) {
            unset($contactGeneral->detail);
        }

        return inertia('Contact/General/Step', compact('contactGeneral'));
    }

    public function update(GeneralRequest $request, ContactGeneral $contactGeneral)
    {
        $contactGeneral->update($request->validated());
        return to_route('contact-general.edit', ['contact_general' => $contactGeneral->id]);
    }
}
