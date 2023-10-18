<?php

namespace Tests\Unit\Services\Apple;

use App\Services\Apple\AppleToken;
use Lcobucci\JWT\Configuration;
use Tests\TestCase;

uses(TestCase::class);

it('s permitted for apple', function () {
    $token = app(Configuration::class)
        ->parser()
        ->parse(app(AppleToken::class)->generate());

    $this->assertTrue($token->isPermittedFor('https://appleid.apple.com'));
});
