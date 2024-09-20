<?php

namespace App\Http\Controllers\Contact;

use App\Http\Controllers\Controller;
use App\Http\Requests\Contact\CompanyRequest;
use App\Models\ContactCompany;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function create()
    {
        
        return inertia('Contact/Company/Form');
    }

    public function store(CompanyRequest $request)
    {
     
        $contactCompany = ContactCompany::create($request->validated());
        return to_route('contact-general.edit', ['contact_general' => $contactCompany->general_id]);
    }

    public function edit(ContactCompany $contactCompany)
    {
        
        return inertia('Contact/Company/Form', compact('contactCompany'));
    }

    public function update(CompanyRequest $request, ContactCompany $contactCompany)
    {
        $contactCompany->update($request->validated());
        return to_route('contact-general.edit', ['contact_general' => $contactCompany->general->id]);
    }
}
