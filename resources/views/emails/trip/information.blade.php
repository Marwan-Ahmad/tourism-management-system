@component('mail::message')
<h1> Information:</h1>

<h1> Mr/Ms {{ $user->Firstname }}</h1>

<h2>we are happy to inform you that your flight reservation has been successfully completed. and you are paid successfuly Below are the flight details:</h2>

Trip Place: {{ $tripinfo->TripPlace }}
<br>
Time Trip: {{ $tripinfo->TimeTrip }}
<br>
Number Of People:{{ $reservetrip->amountpeople }}
<br>
Total Price: ${{ $reservetrip->amountpeople*$tripinfo->Price }}
<br>
To Wards: {{ $tripinfo->Towards }}
<br>

<h3> You For Choosing us.</h3>
<br>

Thank<br>
{{ config('app.name') }}

in arabic:


# تفاصيل الرحلة

### مرحبا, {{ $user->Firstname }}

نحن سعداء بأن نعلمك بأن حجزك للرحلة قد تم بنجاح. فيما يلي تفاصيل الحجز:

**مكان الرحلة:** {{ $tripinfo->TripPlace }}
<br>
**تاريخ الرحلة:** {{ $tripinfo->TimeTrip }}
<br>
**عدد الأشخاص:** {{ $reservetrip->amountpeople }}
<br>
**السعر الإجمالي:** ${{ $reservetrip->amountpeople*$tripinfo->Price }}
<br>
**الوجهه:** {{ $tripinfo->Towards }}
<br>

نشكرك على اختيارك لنا!
<br>

شكراً,<br>
{{ config('app.name') }}



@endcomponent



