<?php

namespace Tests\Feature\Contact;

use App\Models\ContactCompany;
use App\Models\ContactGeneral;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

use Inertia\Testing\AssertableInertia as Assert;

class CompanyTest extends TestCase
{
    use DatabaseMigrations;


    public function general_edit_get(): void
    {

        ContactGeneral::factory(1)->create();
        // $this->test_create_post();

        $contactGeneral = ContactGeneral::first();

        $this->get(route('contact-general.edit', ['contact_general' => 1]))
            ->assertOk()
            ->assertInertia(
                fn(Assert $page) => $page
                    ->component('Contact/General/Step')
                    ->where('step', $contactGeneral->type == 'person' ? 2.5 : 2)
                    ->has('contactGeneral')
                    ->where('contactGeneral', $contactGeneral)
            );
    }

    public function test_create_get(): void
    {
        $this->get(route('contact-company.create'))
            ->assertOk()
            ->assertInertia(
                fn(Assert $page) => $page
                    // ->where('step', 2)
                    ->component('Contact/Company/Form')
            );
    }

    public function test_create_post(): void
    {

        ContactGeneral::factory(1)->create();
        // dd(ContactGeneral::find(1)->id);
        $data = [
            'name' => 'Name',
            'identification' => 'Identification',
            'email' => 'person@gmail.com',
            'extra' => 'Extra',
            'choices' => 'post',
            'contact_general_id' => 1,
        ];

        $this->post(route('contact-company.store'), $data)
            ->assertRedirect(route('contact-general.edit', ['contact_general' => 1]));
        $this->assertDatabaseHas('contact_companies', $data);
    }

    public function test_edit_get(): void
    {

        // // $this->general_edit_get();

        ContactGeneral::factory(1)->create();
        ContactCompany::factory(1)->create();

        $contactCompany = ContactCompany::first();

        // $this->get(route('contact-general.edit', ['contact_general' => 1]));

        $this->get(route('contact-company.edit', ['contact_company' => 1]))
            ->assertOk()
            ->assertInertia(
                fn(Assert $page) => $page
                    ->component('Contact/Company/Form')
                    // ->where('step',  2)
                    ->has('contactCompany')
                    ->where('contactCompany', $contactCompany)
            );
    }

    public function test_edit_put(): void
    {
        ContactGeneral::factory(1)->create();
        ContactCompany::factory(1)->create();

        $contactCompany = ContactCompany::first();

        $data = [
            'name' => 'Name new',
            'identification' => 'Identification new',
            'email' => 'person@gmail.com',
            'extra' => 'Extra',
            'choices' => 'post',
            'contact_general_id' => 1,
        ];

        $this->put(route('contact-company.update', $contactCompany), $data)
            ->assertRedirect(route('contact-general.edit', $contactCompany));

        $this->assertDatabaseHas('contact_companies', $data);
        $this->assertDatabaseMissing('contact_companies', $contactCompany->toArray());
    }

    // *** invalid form
    public function test_create_post_invalid(): void
    {

        ContactGeneral::factory(1)->create();

        $dataInvalid = [
            'name' => '',
            'identification' => '',
            'email' => '',
            'extra' => '',
            // 'choices' => '',
            // 'contact_general_id' => '',
        ];

        $this->post(route('contact-company.store'), $dataInvalid)
            ->assertSessionHasErrors([
                'name' => 'The name field is required.',
                'identification' => 'The identification field is required.',
                'email' => 'The email field is required.',
                'choices' => 'The choices field is required.',
                'extra' => 'The extra field is required.',
                'contact_general_id' => 'The contact general id field is required.',
            ])
            ->assertRedirect('/');
    }


    public function test_edit_put_invalid(): void
    {
        ContactGeneral::factory(1)->create();
        ContactCompany::factory(1)->create();

        $contactCompany = ContactCompany::first();

        $dataInvalid = [
            'name' => '',
            'identification' => '',
            'email' => 'andres',
            'extra' => '',
            // 'choices' => '',
            // 'contact_general_id' => '',
        ];

        $this->put(route('contact-company.update', $contactCompany), $dataInvalid)
            ->assertSessionHasErrors([
                'name' => 'The name field is required.',
                'identification' => 'The identification field is required.',
                'email' => 'The email field must be a valid email address.',
                'choices' => 'The choices field is required.',
                'extra' => 'The extra field is required.',
                'contact_general_id' => 'The contact general id field is required.',
            ])
            ->assertRedirect('/');

        $this->assertDatabaseMissing('contact_companies', $dataInvalid);
    }
}
