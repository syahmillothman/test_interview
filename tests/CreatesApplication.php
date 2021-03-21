<?php

namespace Tests;

use App\Models\User;
use Illuminate\Contracts\Console\Kernel;

trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }

    /**
     * @param User $user
     */
    public function getAuthToken(User $user)
    {
        return $user->createToken('api_unit_testing', ['*'])->accessToken;
    }

    /**
     * @param $token
     */
    public function buildAuthorizationHeader($token): string
    {
        return sprintf('Bearer %s', $token);
    }
}
