<?php

namespace App\Services\Apple;

use Carbon\CarbonImmutable;
use Lcobucci\JWT\Configuration;

class AppleToken
{
    public function __construct(
        private Configuration $jwtConfig
    ) {
    }

    public function generate(): string
    {
        $now = CarbonImmutable::now();

        $token = $this->jwtConfig->builder()
            ->issuedBy(config('services.apple.team_id'))
            ->issuedAt($now)
            ->expiresAt($now->addHour())
            ->permittedFor('https://appleid.apple.com')
            ->relatedTo(config('services.apple.client_id'))
            ->withHeader('kid', config('services.apple.key_id'))
            ->getToken($this->jwtConfig->signer(), $this->jwtConfig->signingKey());

        return $token->toString();
    }
}
