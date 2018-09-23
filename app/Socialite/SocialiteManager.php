<?php

namespace app\Socialite;

class SocialiteManager extends \Laravel\Socialite\SocialiteManager
{
    protected function createYahooDriver()
    {
        $config = $this->app['config']['services.yahoo'];

        return $this->buildProvider('app\Socialite\Two\YahooProvider', $config);
    }

    protected function createLineDriver()
    {
        $config = $this->app['config']['services.line'];

        return $this->buildProvider('app\Socialite\Two\LineProvider', $config);
    }
}
