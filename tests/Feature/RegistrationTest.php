<?php

namespace Tests\Feature;


use App\Mail\PleaseConfirmYourEmail;
use App\User;
use Illuminate\Support\Facades\Mail;
use Session;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;


class RegistrationTest extends TestCase
{
    use DatabaseMigrations;
    
    /** @test */
    public function a_confirmation_email_is_sent_upon_registration()
    {
        Mail::fake();

        \Session::start();

        $this->post(route('register'), [
            'name' => 'John',
            'email' => 'john@example.com',
            'password' => 'foobar',
            'password_confirmation' => 'foobar',
            '_token' => Session::token()
        ]);

        Mail::assertQueued(PleaseConfirmYourEmail::class);
    }

    /** @test */
    function users_can_fully_confirm_their_email_address()
    {
        \Session::start();

        $this->post(route('register'), [
            'name' => 'John',
            'email' => 'john@example.com',
            'password' => 'foobar',
            'password_confirmation' => 'foobar',
            '_token' => Session::token()
        ]);

        $user = User::whereName('John')->first();

        $this->assertFalse($user->confirmed);

        $this->assertNotNull($user->confirmation_token);

        $this->get(route('register.confirm'), ['token' =>  $user->confirmation_token])
            ->assertRedirect(route('threads'));

        $this->assertTrue($user->fresh()->confirmed);


    }
}
