<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Http\Request;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @var Request
     */
    public $request;

    public function setUp()
    {
        parent::setUp();

        $this->request = new Request();
    }

    public function setAuthUser()
    {
        $this->request->setUserResolver(function () {
            return factory(User::class)->create();
        });
    }

    public function assertArrayHasKeys()
    {
        $args = func_get_args();

        $array = array_shift($args);

        foreach ($args as $key) {
            $this->assertArrayHasKey($key, $array);
        }
    }
}
