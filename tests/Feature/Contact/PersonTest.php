<?php

namespace Tests\Feature\Contact;

use App\Models\ContactGeneral;
use App\Models\ContactPerson;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

use Inertia\Testing\AssertableInertia as Assert;

class PersonTest extends TestCase
{
    use DatabaseMigrations;

    public function test_create_get(): void
    {
        $this->get(route('contact-person.create'))
            ->assertOk()
            ->assertInertia(
                fn(Assert $page) => $page
                    // ->where('step', 2.5)
                    ->component('Contact/Person/Form')
            );
    }

    public function test_create_post(): void
    {

        ContactGeneral::factory(1)->create();
        // dd(ContactGeneral::find(1)->id);
        $data = [
            'name' => 'Name',
            'surname' => 'Surname',
            'other' => 'Extra',
            'choices' => 'post',
            'contact_general_id' => 1,
        ];

        $this->post(route('contact-person.store'), $data)
            ->assertRedirect(route('contact-general.edit', ['contact_general' => 1]));
        $this->assertDatabaseHas('contact_persons', $data);
    }

    public function test_edit_get(): void
    {

        ContactGeneral::factory(1)->create();
        ContactPerson::factory(1)->create();

        $contactPerson = ContactPerson::first();

        $this->get(route('contact-person.edit', ['contact_person' => 1]))
            ->assertOk()
            ->assertInertia(
                fn(Assert $page) => $page
                    ->component('Contact/Person/Form')
                    ->has('contactPerson')
                    ->where('contactPerson', $contactPerson)
            );
    }

    public function test_edit_put(): void
    {
        ContactGeneral::factory(1)->create();
        ContactPerson::factory(1)->create();

        $contactPerson = ContactPerson::first();

        $data = [
            'name' => 'Name New',
            'surname' => 'Surname New',
            'other' => 'Extra New',
            'choices' => 'post',
            'contact_general_id' => 1,
        ];

        $this->put(route('contact-person.update', $contactPerson), $data)
            ->assertRedirect(route('contact-general.edit', $contactPerson));

        $this->assertDatabaseHas('contact_persons', $data);
        $this->assertDatabaseMissing('contact_persons', $contactPerson->toArray());
    }

    // invalid
    public function test_create_post_invalid(): void
    {

        ContactGeneral::factory(1)->create();
        $dataInvalid = [
            'name' => '',
            'surname' => '',
            'other' => 'a',
            // 'choices' => '',
            // 'contact_general_id' => '',
        ];

        $this->post(route('contact-person.store'), $dataInvalid)
            ->assertSessionHasErrors([
                'name' => 'The name field is required.',
                'surname' => 'The surname field is required.',
                'other' => 'The other field must be at least 2 characters.',
                'choices' => 'The choices field is required.',
                'contact_general_id' => 'The contact general id field is required.',
            ])
            ->assertRedirect('/');
    }

    public function test_edit_put_invalid(): void
    {
        ContactGeneral::factory(1)->create();
        ContactPerson::factory(1)->create();

        $contactPerson = ContactPerson::first();

        $dataInvalid = [
            'name' => '',
            'surname' => '',
            'other' => '',
            // 'choices' => '',
            // 'contact_general_id' => '',
        ];

        $this->put(route('contact-person.update', $contactPerson), $dataInvalid)
            ->assertSessionHasErrors([
                'name' => 'The name field is required.',
                'surname' => 'The surname field is required.',
                'other' => 'The other field is required.',
                'choices' => 'The choices field is required.',
                'contact_general_id' => 'The contact general id field is required.',
            ])
            ->assertRedirect('/');
    }
}
