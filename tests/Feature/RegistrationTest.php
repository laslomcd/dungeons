<?php

namespace Tests\Feature;


use App\Mail\PleaseConfirmYourEmail;
use App\User;
use function foo\func;
use Illuminate\Auth\Events\Registered;
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

        event (new Registered(create('App\User')));

        Mail::assertSent(PleaseConfirmYourEmail::class);
    }

    /** @test */
    function users_can_fully_confirm_their_email_address()
    {
        \Session::start();

        $this->post('/register', [
            'name' => 'John',
            'email' => 'john@example.com',
            'password' => 'foobar',
            'password_confirmation' => 'foobar',
            '_token' => Session::token()
        ]);

        $user = User::whereName('John')->first();

        $this->assertFalse($user->confirmed);

        $this->assertNotNull($user->confirmation_token);

        $response = $this->get('/register/confirm?token=' . $user->confirmation_token);

        $this->assertTrue($user->fresh()->confirmed);

        $response->assertRedirect('/threads');
    }
}
