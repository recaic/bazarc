<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    use WithoutMiddleware;

    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->artisan("migrate");
        $this->artisan("db:seed");

        $this->withExceptionHandling();
    }
}
