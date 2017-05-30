<?php

$ApiCodes = array(
    'unauthorized' => 'The account is unauthorized.',

    // users
    'users_not_found' => 'The account is not found.',
    'users_deleted' => 'The account is deleted.',
    'users_social' => 'The account is registered as :social Account. Cannot request to reset password.',
    'users_username_required' => 'The username is required.',
    'users_username_invalid' => 'The username is invalid.',
    'users_username_unique' => 'The username has already been taken.',
    'users_username_min' => 'The username must be at least 6 characters',
    'users_username_max' => 'The username may not be greater than 100 characters',
    'users_email_required' => 'The email is required.',
    'users_email_email' => 'The email must be a valid email address.',
    'users_email_invalid' => 'The email is invalid',
    'users_email_unique' => 'The email has already been taken.',
    'users_confirm_email_required' => 'The confirm email is required',
    'users_confirm_email_same' => 'The confirm email and email field must match.',
    'users_password_required' => 'The password is required.',
    'users_password_regex' => 'The password format is invalid.',
    'users_password_min' => 'The password must be at least 8 characters.',
    'users_password_max' => 'The password may not be greater than 36 characters.',
    'users_password_incorrect' => 'The password is incorrect.',
    'users_confirm_password_required' => 'The confirm password is required.',
    'users_confirm_password_same' => 'The confirm password and password must match.',
    'users_location_required' => 'The country is required',
    'users_date_of_birth_required' => 'The date of birth is required.',
    'users_is_term_required' => 'The term and condition is required.',
    'users_is_privacy_required' => 'The privacy and policy is required.',
    'users_current_password_required' => 'The current password is required.',
    'users_current_password_incorrect' => 'The current password is incorrect',
    'users_phone_required' => 'The phone is required.',
    'users_phone_phone' => 'The phone must be a validate phone number.',
    'users_phone_invalid' => 'The phone is invalid.',
    'users_social_id_required' => 'The social id is required',
    'users_social_type_required' => 'The social type is required',
    'users_term_boolean' => 'The term field must be true or false',
    'users_privacy_boolean' => 'The privacy field must be true or false',
    'users_phone_min' => 'The phone number must be at least 8 characters',
    'users_phone_max' => 'The phone number may not be greater than 14 characters',

    // tokens
    'tokens_not_found' => 'The Token is not found.',
    'tokens_expired' => 'The Token is expired.',
    'tokens_deleted' => 'The Token is deleted.',
    'tokens_token_required' => 'The token is required.',

    // permission
    'permissions_access_denied' => 'Your permission access denied.',

    //categories
    'categories_not_found' => 'The categories is not found',

    //collections
    'collections_not_found' => 'The collections is not found'

);

$ApiErrorCodes = array(

    'unauthorized' => 1000,

    // user 30xx
    'users_not_found' => 3000,
    'users_deleted' => 3001,
    'users_social' => 3002,
    'users_username_required' => 3011,
    'users_username_invalid' => 3012,
    'users_username_unique' => 3013,
    'users_email_required' => 3014,
    'users_email_email' => 3015,
    'users_email_invalid' => 3016,
    'users_email_unique' => 3017,
    'users_confirm_email_required' => 3018,
    'users_confirm_email_same' => 3019,
    'users_password_required' => 3020,
    'users_password_regex' => 3021,
    'users_password_min' => 3022,
    'users_password_max' => 3023,
    'users_password_incorrect' => 3024,
    'users_confirm_password_required' => 3025,
    'users_confirm_password_same' => 3026,
    'users_location_required' => 3027,
    'users_date_of_birth_required' => 3028,
    'users_is_term_required' => 3029,
    'users_is_privacy_required' => 3030,
    'users_is_subscribe_required' => 3031,
    'users_current_password_required' => 3032,
    'users_current_password_incorrect' => 3033,
    'users_phone_required' => 3034,
    'users_phone_phone' => 3035,
    'users_phone_invalid' => 3036,
    'users_username_min' => 3037,
    'users_username_max' => 3038,
    'users_social_id_required' => 3039,
    'users_social_type_required' => 3040,
    'users_term_boolean' => 3041,
    'users_privacy_boolean' => 3042,
    'users_phone_min' => 3043,
    'users_phone_max' => 3044,

    // tokens 40xx
    'tokens_not_found' => 4000,
    'tokens_expired' => 4001,
    'tokens_deleted' => 4002,
    'tokens_token_required' => 4011,

    //categories : 50xx
    'categories_not_found' => 5001,

    //catalog : 60xx
    'catalogs_not_found' => 6001,

    //collections : 70xx
    'collections_not_found' => 7001,

    // permission: 98xx
    'permissions_access_denied' => 9800,
);

$ApiCodes['ApiErrorCodes'] = $ApiErrorCodes;
$ApiErrorCodesFlip = array_flip($ApiErrorCodes);
$ApiCodes['ApiErrorCodesFlip'] = $ApiErrorCodesFlip;

return $ApiCodes;
