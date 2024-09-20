<?php

namespace App\Http\Controllers\Contact;

use App\Http\Controllers\Controller;
use App\Http\Requests\Contact\DetailRequest;
use App\Models\ContactDetail;
use Illuminate\Http\Request;

class DetailController extends Controller
{
    public function create()
    {
        return inertia('Contact/Detail/Form');
    }

    public function store(DetailRequest $request)
    {
        $contactDetail = ContactDetail::create($request->validated());
        return to_route('contact-general.edit', ['contact_general' => $contactDetail->contact_general_id]);
    }

    public function edit(ContactDetail $contactDetail)
    {
        return inertia('Contact/Detail/Form', compact('contactDetail'));
    }

    public function update(DetailRequest $request, ContactDetail $contactDetail)
    {
        $contactDetail->update($request->validated());
        return to_route('contact-general.edit', ['contact_general' => $contactDetail->contact_general_id]);
    }
}
