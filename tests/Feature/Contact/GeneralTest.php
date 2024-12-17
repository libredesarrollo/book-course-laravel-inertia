<?php

namespace Tests\Feature\Contact;

use App\Models\ContactGeneral;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

use Inertia\Testing\AssertableInertia as Assert;

class GeneralTest extends TestCase
{

    use DatabaseMigrations;

    /**
     * A basic feature test example.
     */
    public function test_create_get(): void
    {
        $this->get(route('contact-general.create'))
            ->assertOk()
            ->assertInertia(
                fn(Assert $page) => $page
                    ->where('step', 1)
                    ->component('Contact/General/Step')
            );
    }

    public function test_create_post(): void
    {

        $data = [
            'subject' => 'Subject',
            'message' => 'Message',
            'type' => 'person'
        ];

        $this->post(route('contact-general.store'), $data)
            ->assertRedirect(route('contact-general.edit', ['contact_general' => 1]));

        $this->assertDatabaseHas('contact_generals', $data);
    }

    public function test_edit_get(): void
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
    public function test_edit_post(): void
    {
        $this->test_create_post();

        $contactGeneral = ContactGeneral::first();

        $data = [
            'subject' => 'Subject new',
            'message' => 'Message new',
            'type' => 'person'
        ];

        $this->put(route('contact-general.update', $contactGeneral), $data)
            ->assertRedirect(route('contact-general.edit', $contactGeneral));

        $this->assertDatabaseHas('contact_generals', $data);
        $this->assertDatabaseMissing('contact_generals', $contactGeneral->toArray());
    }

    public function test_create_post_invalid(): void
    {

        // para tener una respuesta en el back del historial
        $this->get(route('contact-general.create'));

        $dataInvalid = [
            'subject' => '',
            'message' => '',
            'type' => ''
        ];

        $this->post(route('contact-general.store'), $dataInvalid)
            ->assertSessionHasErrors([
                'subject' => 'The subject field is required.',
                'message' => 'The message field is required.',
                'type' => 'The type field is required.',
            ])
            ->assertRedirect(route('contact-general.create'));
    }

    public function test_edit_put_invalid(): void
    {
        ContactGeneral::factory(1)->create();

        $contactGeneral = ContactGeneral::first();

        $dataInvalid = [
            'subject' => '',
            'message' => '',
            'type' => ''
        ];

        $this->put(route('contact-general.update', $contactGeneral), $dataInvalid)
            ->assertSessionHasErrors([
                'subject' => 'The subject field is required.',
                'message' => 'The message field is required.',
                'type' => 'The type field is required.',
            ])
            ->assertRedirect('/');

        $this->assertDatabaseMissing('contact_generals', $dataInvalid);
    }
}
