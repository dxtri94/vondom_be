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

    //platform
    'platforms_not_found' => 'The platforms cannot found.',

    //games
    'games_not_found' => 'The games cannot found.',
    'games_opponents_not_found' => 'The opponents are not found',

    // verifies
    'verifies_code_required' => 'The verify code is required.',
    'verifies_code_incorrect' => 'The verify code is incorrect.',
    'verifies_code_expired' => 'The verify code is expired.',
    'verifies_code_3' => 'The phone number is invalid.',
    'verifies_code_6' => 'The verify code has been activated.',
    'verifies_code_10' => 'Concurrent verifications to the same number are not allowed.',
    'verifies_code_16' => 'The verify code is invalid.',
    'verifies_code_15' => 'The phone number is invalid',
    'verifies_code_numeric' => 'The verify code must be a number',

    // challenges
    'challenges_not_found' => 'The Challenge is not found.',
    'challenges_opponent_id_required' => 'The opponent is not found.',
    'challenges_amount_required' => 'The amount field is required.',
    'challenges_amount_invalid' => 'The amount is invalid',
    'challenges_amount_min' => 'The amount must be at least 1$.',
    'challenges_amount_max' => 'The amount may not be greater than 500$.',
    'challenges_amount_regex' => 'The amount should be have 2 decimals places',
    'challenges_game_id_required' => 'The game id is not found',
    'challenges_confirm_amount_required' => 'The confirm amount is required',
    'challenges_confirm_amount_same' => 'The confirm amount and amount must match',
    'challenges_description_required' => 'The description is required',
    'challenges_users_accepted' => 'The accept field has been clicked',
    'challenges_users_declined' => 'Your opponent has declined',

    //results
    'results_not_found' => 'The result is not found',
    'results_file_required' => 'The image is not found',
    'results_challenge_id_required' => 'The challenge id is required',
    'results_challenge_id_numeric' => 'The challenge id must be a number',
    'results_link_required' => 'The link is required',
    'results_link_url' => 'The url is invalid',
    'results_status_required' => 'The action is required',
    'results_is_positive_required' => 'The positive field is required',
    'results_is_positive_boolean' => 'The positive field should be true or false',
    'results_reason_required' => 'The reason is required',

    //disputes
    'disputes_challenge_id_required' => 'The challenge id is required',
    'disputes_date_required' => 'The date field is required',
    'disputes_date_date' => 'The date is invalid',
    'disputes_challenge_id_number' => 'The challenge id must be a number'

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

    //platform : 50xx
    'platforms_not_found' => 5000,

    //games : 60xx
    'games_not_found' => 6000,
    'games_opponents_not_found' => 6001,

    // challenge: 70xx
    'challenges_not_found' => 7000,
    'challenges_opponent_id_required' => 7001,
    'challenges_amount_required' => 7002,
    'challenges_amount_min' => 7003,
    'challenges_amount_max' => 7004,
    'challenges_amount_invalid' => 7005,
    'challenges_amount_regex' => 7006,
    'challenges_game_id_required' => 7007,
    'challenges_confirm_amount_required' => 7008,
    'challenges_confirm_amount_same' => 7009,
    'challenges_description_required' => 7010,
    'challenges_users_accepted' => 7011,
    'challenges_users_declined' => 7012,

    // results 14xx
    'results_not_found' => 1401,
    'results_file_required' => 1402,
    'results_challenge_id_required' => 1403,
    'results_challenge_id_numeric' => 1404,
    'results_link_required' => 1405,
    'results_link_url' => 1406,
    'results_status_required' => 1407,
    'results_is_positive_required' => 1408,
    'results_is_positive_boolean' => 1409,
    'results_reason_required' => 1410,

    // disputes 80xx
    'disputes_challenge_id_required' => 8001,
    'disputes_date_required' => 8002,
    'disputes_date_date' => 8003,
    'disputes_challenge_id_number' => 8004,

    // transactions 90xx

    // newsletters 11xx
    // notifications 12xx
    // verifies 13xx
    'verifies_code_required' => 1301,
    'verifies_code_incorrect' => 1302,
    'verifies_code_numeric' => 1305,
    'verifies_code_expired' => 1304,
    'verifies_code_3' => 1303,
    'verifies_code_6' => 1306,
    'verifies_code_10' => 1310,
    'verifies_code_15' => 1315,
    'verifies_code_16' => 1316,

    // permission: 98xx
    'permissions_access_denied' => 9800,
);

$ApiCodes['ApiErrorCodes'] = $ApiErrorCodes;
$ApiErrorCodesFlip = array_flip($ApiErrorCodes);
$ApiCodes['ApiErrorCodesFlip'] = $ApiErrorCodesFlip;

return $ApiCodes;
