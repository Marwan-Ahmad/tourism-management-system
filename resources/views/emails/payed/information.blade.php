@component('mail::message')
# Trip Information

# Hello Mr/Ms {{ $user->Firstname }} {{ $user->Lastname }},

# You must pay for the flight you have reserved within four hours to confirm your reservation. Thank you.

**The amount to be paid:** ${{ $reservetrip->amountpeople * $trip->Price }}
<br>
**Number Of People:** {{ $reservetrip->amountpeople }}
<br>

Thank you for choosing us.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
