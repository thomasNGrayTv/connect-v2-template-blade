<?php

return [

    /*
    |--------------------------------------------------------------------------
    | G-Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | app_url is required to be passed to the SSO provider in order to
    | verify the authentication attempt and to redirect to the proper
    | callback URL.
    |
    | app_id is a key that is used to identify your app various scenarios
    | such as authentication and permissioning.
    | This should be all lowercase and use underscores for spaces.
    | Keep this short but relevant to your application.
    | (i.e. touchboard or sales_form or mobile_tools)
    |
    | sso_redirect_path is the return path after performing the sso login.
    | This authenticates the user by using the code param that is returned.
    | This should not be changed unless /sso is needed for something else.
    | IMPORTANT: If this is changed, the path must be registered as a callback
    | in Cognito.
    |
    */

    'app_url' => env('APP_URL', 'http://localhost'),
    'app_id' => env('APP_ID', 'app_id'),
    'sso_redirect_path' => env('SSO_REDIRECT_PATH', '/sso'),


    /*
    |--------------------------------------------------------------------------
    | G-Authentication Settings
    |--------------------------------------------------------------------------
    |
    | show_login_page is a boolean that when set to true, will show a
    | login page. If set to false, the user will be taken directly to the
    | SSO provider's login page.
    |
    | logout_time is the duration in seconds that the login session is valid.
    | After this time, the user is considered logged out.
    | Default is 4 hours (14400 seconds)
    |
    */

    'show_login_page' => env('SHOW_LOGIN_PAGE', false),
    'logout_time' => env('LOGOUT_TIME', 14400),

];
