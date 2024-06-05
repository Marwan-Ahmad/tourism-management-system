@component('mail::message')
# Welcome to {{ config('app.name') }}

Hello {{ $user->Firstname }} {{ $user->Lastname }},

Thank you for registering at {{ config('app.name') }}! We are excited to have you on board. Our app offers a variety of features designed to enhance your experience:

- **Explore Countries:** Discover detailed information about various countries around the world.
- **View Airline Companies:** Get insights into different airline companies to choose the best for your trip.
- **Book Trips at Best Prices:** Reserve your trips at incredibly competitive prices.

We encourage you to explore the app and take full advantage of all the functionalities we offer. If you have any questions or need assistance, our support team is here to help.

@component('mail::button', ['url' => config('MAIL_FROM_ADDRESS')])
Get Started
@endcomponent

Thank you for choosing {{ config('app.name') }}!

Best regards,<br>
The {{ config('app.name') }} Team
@endcomponent
