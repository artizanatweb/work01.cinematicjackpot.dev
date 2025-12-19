<div>
    <h2>{{ __("Hi") }} {{ $user->name }},</h2>
</div>
<div>
    <p>{{ __("Your sign-in code is") }}:</p>
    <p>
        <strong style="font-size: 1.25em; font-family: Arial, SansSerif">{{ $code }}</strong>
    </p>
    <p>{{ __("This code will expire in :minutes minutes", [ 'minutes' => 5 ]) }}.</p>
</div>
<div>
    <p>
        {{ __("Thanks") }}, <br>
        {{ __("CinematicJackpot team") }}
    </p>
</div>
