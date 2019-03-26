@component('mail::message')
# One Last Step

We just need you to confirm your email address to prove that your a human. I don't want to be the one responsible for the
robot uprising.

@component('mail::button', ['url' => '#'])
Confirm that Shit
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
