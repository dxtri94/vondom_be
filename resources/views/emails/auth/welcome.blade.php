<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Welcome Email</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/fonts.css') }}"/>
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">

    <style type="text/css">
        a:hover,
        a:focus {
            text-decoration: underline;
        }
    </style>
</head>
<body style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background: #0288D1; padding-top: 8px; padding-bottom: 60px; color:#000000; margin: 0;">
<div class="top-email" style="text-align: center; color:#ffffff;">
    <a href="{{env('FRONTEND_URL')}}" style="color:#ffffff; text-decoration: none; font-size: 12px;">
        Welcome to Snazzel</a> |
    <a href="{{env('FRONTEND_URL')}}" style="color:#ffffff; text-decoration: none; font-size: 12px;">View
        in browser</a>
    <p style="margin-top: 37px; margin-bottom: 18px;">
        <img style="width: 30px; height: 30px;" src="{{ asset('images/view-icon.jpg') }}" alt="view"></p>
</div>
<div class="content-email"
     style="max-width: 560px; margin: 0 auto; background: #ffffff; padding: 15px 0 27px; -webkit-border-radius: 10px; -moz-border-radius: 10px; border-radius: 10px; margin-bottom: 25px;">
    <div class="img-banner">
        <img style="max-width: 100%;" src="{{ asset('images/banner.jpg') }}" alt="banner">
    </div>
    <div class="paragraph" style="margin: 19px 35px 0 35px; font-size: 17px;">
        <p style="margin-bottom: 27px; line-height: 1.6;">Hello {{ucfirst($user->name)}}, </p>

        <p style="margin-bottom: 27px; line-height: 1.6; padding-right: 15px;">Welcome to Snazzel. We do things a little
            differently and we
            hope you like it.</p>

        <p style="margin-bottom: 25px; line-height: 1.6; padding-right: 15px;">Snazzel is a great way to sell just about
            anything. It’s also
            a simple way for Charities, clubs etc. to manage fund raising activities.</p>

        <hr>

        <h1 style="font-family: 'Montserrat'; font-size: 24px; font-weight: 700; margin-top: 32px; margin-bottom: 24px;">
            So what’s different…? </h1>
        <p style="margin-bottom: 25px; line-height: 1.6;">Snazzel lets you sell your products or service via a good old
            fashion raffle. This gives people the opportunity to buy ticket(s) to win your item and lets you choose the
            sell price (or how much you want to make) as well as the date and time your item will sell. It’s very easy
            to start and if you’ve ever sold anything online before then it’s not much different.</p>
    </div>
    <div style="padding: 0 15px;">
        <a href="{{ env('FRONTEND_URL') . '/home' }}" class="btn-blue"
           style="font-family: 'Montserrat'; font-weight: 700; max-width: 310px; height: 50px; background: #0288D1; margin: 0 auto; text-align: center; color: #fff; font-size: 18px; line-height: 49px; text-decoration: none; display: inherit;-webkit-box-shadow: 0px 2px 10px 0px rgba(0,0,0,0.42); -moz-box-shadow: 0px 2px 10px 0px rgba(0,0,0,0.42); box-shadow: 0px 2px 10px 0px rgba(0,0,0,0.42);-webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px;">Get
            Started</a>
    </div>
</div>
<div class="bottom" style="text-align: center;">
    <a href="{{ env('FACEBOOK_URL', 'https://facebook.com') }}">
        <img style="width: 35px; height: 35px; display: inline-block; margin-bottom: 25px;"
             src="{{ asset('/images/facebook-icon.jpg') }}" alt="facebook">
    </a>
    <div class="privacy">
        <a style="color: #ffffff; text-decoration: underline; font-size: 13px;"
           href="{{env('FRONTEND_URL') . '/about'}}">About</a>
        <a style="color: #ffffff; text-decoration: underline; font-size: 13px;"
           href="{{env('FRONTEND_URL') . '/terms-of-use'}}">Terms</a>
        <a style="color: #ffffff; text-decoration: underline; font-size: 13px;"
           href="{{env('FRONTEND_URL') . '/about'}}">Privacy</a>
        <a style="color: #ffffff; text-decoration: underline; font-size: 13px;"
           href="{{env('FRONTEND_URL') . '/about'}}">Unsubscribe</a>
        <br><span style="color: #ffffff; font-size: 13px;">&copy; 2016 Snazzel</span>
    </div>
</div>
</body>
</html>