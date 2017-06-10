<?php

$ApiCodes = array(
    'unauthorized' => 'The account is unauthorized.',

    // users
    'users_not_found' => 'The account is not found.',
    'users_deleted' => 'The account is deleted.',
    'users_username_required' => 'The username is required.',
    'users_username_invalid' => 'The username is invalid.',
    'users_username_unique' => 'The username has already been taken.',
    'users_username_min' => 'The username must be at least 6 characters',
    'users_username_max' => 'The username may not be greater than 100 characters',
    'users_confirm_email_required' => 'The confirm email is required',
    'users_confirm_email_same' => 'The confirm email and email field must match.',
    'users_password_required' => 'The password is required.',
    'users_password_regex' => 'The password format is invalid.',
    'users_password_min' => 'The password must be at least 8 characters.',
    'users_password_max' => 'The password may not be greater than 36 characters.',
    'users_password_incorrect' => 'The password is incorrect.',
    'users_confirm_password_required' => 'The confirm password is required.',
    'users_confirm_password_same' => 'The confirm password and password must match.',

    // tokens
    'tokens_not_found' => 'The Token is not found.',
    'tokens_expired' => 'The Token is expired.',
    'tokens_deleted' => 'The Token is deleted.',
    'tokens_token_required' => 'The token is required.',

    // permission
    'permissions_access_denied' => 'Your permission access denied.',

    //categories
    'categories_not_found' => 'The categories is not found',
    'categories_name_required' => 'The categories name is required',

    //collections
    'collections_not_found' => 'The collections is not found',
    'collections_categories_id_required' => 'The categories is required',
    'collections_name_required' => 'The collection name is required',

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
    'users_confirm_email_required' => 3018,
    'users_confirm_email_same' => 3019,
    'users_password_required' => 3020,
    'users_password_regex' => 3021,
    'users_password_min' => 3022,
    'users_password_max' => 3023,
    'users_password_incorrect' => 3024,
    'users_confirm_password_required' => 3025,
    'users_confirm_password_same' => 3026,

    // tokens 40xx
    'tokens_not_found' => 4000,
    'tokens_expired' => 4001,
    'tokens_deleted' => 4002,
    'tokens_token_required' => 4011,

    //categories : 50xx
    'categories_not_found' => 5001,
    'categories_name_required' => 5002,

    //catalog : 60xx
    'catalogs_not_found' => 6001,

    //collections : 70xx
    'collections_not_found' => 7001,
    'collections_categories_id_required' => 7002,
    'collections_name_required' => 7003,

    // permission: 98xx
    'permissions_access_denied' => 9800,
);

$ApiCodes['ApiErrorCodes'] = $ApiErrorCodes;
$ApiErrorCodesFlip = array_flip($ApiErrorCodes);
$ApiCodes['ApiErrorCodesFlip'] = $ApiErrorCodesFlip;

return $ApiCodes;
