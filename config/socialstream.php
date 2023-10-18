<?php

use JoelButcher\Socialstream\Features;
use JoelButcher\Socialstream\Providers;

return [
    'middleware' => ['web'],
    'prompt' => 'Or',
    'providers' => [
         Providers::github(label: 'Continue with GitHub'),
    ],
    'features' => [
        Features::createAccountOnFirstLogin(),
        Features::generateMissingEmails(),
        Features::loginOnRegistration(),
        Features::rememberSession(),
        Features::providerAvatars(),
        Features::refreshOauthTokens(),
    ],
];
