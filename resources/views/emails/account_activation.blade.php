@component('mail::message')

<h1>Thank you for registering!</h1>

Dear {{ $username }}, please use the link below to log in to your account with our online transaction management system. That system will allow you to manage your transaction online. You can submit documents, fill forms, monitor the progress of your case, communicate with your admin and legal teams.

<a href="https://app.squarico.com/login">https://app.squarico.com/login</a>

Your login is your email.<br>
Your password is: {{ $password }}

@endcomponent
