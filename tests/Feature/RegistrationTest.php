<?php

namespace Tests\Feature;


use App\Mail\PleaseConfirmYourEmail;
use function foo\func;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;
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
}
