@component('mail::message')
# One Last Step

Listen up nerd, I just need you to confirm your email address to prove that your a human. I don't want to be the one responsible for the
robot uprising.

@component('mail::button', ['url' => url('/register/confirm?token=' . $user->confirmation_token)])
Confirm That Shit
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
