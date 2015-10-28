<?php

class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        // create the database, if necessary
        if (!file_exists(storage_path(env('APP_ENV').'.sqlite'))) {
            touch(storage_path(env('APP_ENV').'.sqlite'));
        }

        return $app;
    }
}
