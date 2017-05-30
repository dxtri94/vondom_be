<?php

return array(

    'NAME' => env('MAIL_NAME'),
    'EMAILs' => array(
        'INFO' => env('MAIL_INFO', env('MAIL_ADDRESS')),
        'SUPPORT' => env('MAIL_SUPPORT', env('MAIL_ADDRESS')),
        'MARKETING' => env('MAIL_MARKETING', env('MAIL_ADDRESS')),
        'CASHIER' => env('MAIL_CASHIER', env('MAIL_ADDRESS')),

        'SUBJECT' => array(
            'NEW_REGISTER' => 'Verify Email',
            'WELCOME' => 'Welcome to Play Or Go',
            'FORGOT' => 'Request Reset Password'
        )
    ),

    'PATH' => array(
        'RESULT' => '/upload/results'
    ),

    'NOTIFICATIONs' => array(
        'NEW_CHALLENGE' => 'You have received a Head to Head Challenge from @user.',
        'RAISE_CHALLENGE' => '@user has raised the @game challenge from @old_amount to @new_amount.',
        'ACCEPT_CHALLENGE' => '@user has accepted the @game challenge with you.',
        'DECLINE_CHALLENGE' => '@user has declined the @game challenge with you.',
        'DECISION' => array(
            'USER' => 'Please wait for your opponent response.',
            'OPPONENT' => 'Your opponent has taken a decision.',
            'DNF' => '@user has cancelled the challenge.'
        ),
        'WON' => 'Congratulation! You have won the @game challenge against @user.',
        'LOST' => 'Your have lost the @game challenge with @user.',
        'DNF' => 'Your @game challenge with @user has ended',
        'DISPUTE' => 'A dispute has been lodged for @game challenge with @user. Please wait for admin confirmation. We will inform you shortly. Thanks!'
    ),

    'LINKs' => array(
        'VERIFY_EMAIL' => env('FRONTEND_URL') . "/verify",
        "FORGOT" => env('FRONTEND_URL') . "/reset",
    ),

    'ROLEs' => array(
        'SUPER_ADMIN' => 1,
        'ADMIN' => 2,
        'USER' => 3
    ),

    'CHALLENGE_STATUS' => array(
        'NEW' => 1,
        'WAITING' => 2,
        'ACTIVATED' => 3,
        'ACCEPTED' => 4,
        'DECLINED' => 5,
        'COMPLETED' => 6,
        'DISPUTED' => 7
    ),

    'USER_STATUS' => array(
        'NEW' => 1,
        'VERIFY_OTP' => 2,
        'VERIFY_EMAIL' => 3,
        'UPDATE' => 4,
        'DONE' => 5
    ),

    'NOTIFICATION_STATUS' => array(
        'NEW' => 1,
        'READ' => 2
    ),

    'RESULT_STATUS' => array(
        'WON' => 1,
        'LOST' => 2,
        'DNF' => 3, //DO NOT FINISH
        'NP' => 4, // NOT PROVIDED
    ),
    'DISPUTE_STATUS' => array(
        'NEW' => 1,
        'PENDING' => 2,
        'SOLVING' => 3,
        'WON' => 4,
        'LOST' => 5
    ),

    'NEWSLETTER_STATUS' => array(
        'HOT_GAME' => 1,
        'NEWEST_GAME' => 2
    ),

    'GENDER' => array(
        'FEMALE' => false,
        'MALE' => true
    ),

    'TRANSACTION_TYPE' => array(
        'WON' => 1,
        'LOST' => 2,
        'PLATFORM_FEE' => 3,
        'DISPUTE_FEE' => 4,
        'TOP_UP' => 5,
        'WITHDRAWAL' => 6,
        'REFUND' => 7
    ),

    'CURRENCY' => array(
        'DOLLAR' => '$'
    ),

    'LIVE_HOURS_TOKEN' => 2,
    'LIVE_HOURS_VERIFY_TOKEN' => 48,
    'LIVE_MINUTE_VERIFY_CODE' => 5,

    'PLATFORMS_TYPE' => array(
        'PC' => 1,
        'CONSOLE' => 2,
        'ARCADE' => 3,
        'MOBILE' => 4
    )
);