<?php

namespace Tests\Feature\Contact;

use App\Models\ContactDetail;
use App\Models\ContactGeneral;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

use Inertia\Testing\AssertableInertia as Assert;

class DetailTest extends TestCase
{
    use DatabaseMigrations;

    public function test_create_get(): void
    {
        $this->get(route('contact-detail.create'))
            ->assertOk()
            ->assertInertia(
                fn(Assert $page) => $page
                    // ->where('step', 3)
                    ->component('Contact/Detail/Form')
            );
    }

    public function test_create_post(): void
    {

        ContactGeneral::factory(1)->create();

        $data = [
            'extra' => 'Extra',
            'contact_general_id' => 1,
        ];

        $this->post(route('contact-detail.store'), $data)
            ->assertRedirect(route('contact-general.edit', ['contact_general' => 1]));
        $this->assertDatabaseHas('contact_optionals', $data);
    }

    public function test_edit_get(): void
    {

        ContactGeneral::factory(1)->create();
        ContactDetail::factory(1)->create();

        $contactDetail = ContactDetail::first();

        $this->get(route('contact-detail.edit', ['contact_detail' => 1]))
            ->assertOk()
            ->assertInertia(
                fn(Assert $page) => $page
                    ->component('Contact/Detail/Form')
                    ->has('contactDetail')
                    ->where('contactDetail', $contactDetail)
            );
    }

    public function test_edit_put(): void
    {
        ContactGeneral::factory(1)->create();
        ContactDetail::factory(1)->create();

        $contactDetail = ContactDetail::first();

        $data = [
            'extra' => 'Extra New',
            'contact_general_id' => 1,
        ];

        $this->put(route('contact-detail.update', $contactDetail), $data)
            ->assertRedirect(route('contact-general.edit', $contactDetail));

        $this->assertDatabaseHas('contact_optionals', $data);
        $this->assertDatabaseMissing('contact_optionals', $contactDetail->toArray());
    }

    // invalid

    public function test_create_post_invalid(): void
    {

        ContactGeneral::factory(1)->create();

        $dataInvalid = [
            'extra' => '',
            // 'contact_general_id' => 1,
        ];

        $this->post(route('contact-detail.store'), $dataInvalid)
            ->assertSessionHasErrors([
                'extra' => 'The extra field is required.',
                'contact_general_id' => 'The contact general id field is required.',
            ]);
    }

    public function test_edit_put_invalid(): void
    {
        ContactGeneral::factory(1)->create();
        ContactDetail::factory(1)->create();

        $contactDetail = ContactDetail::first();

        $dataInvalid = [
            'extra' => 'a',
            // 'contact_general_id' => 1,
        ];

        $this->put(route('contact-detail.update', $contactDetail), $dataInvalid)
        ->assertSessionHasErrors([
            'extra' => 'The extra field must be at least 2 characters.',
            'contact_general_id' => 'The contact general id field is required.',
        ]);
    }
}
