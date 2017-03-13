<?php

namespace Tests\Feature;

use Api\Transformers\UserTransformer;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UserTransformerTest extends TestCase
{
    use DatabaseMigrations;

    private $userTransformer;

    private $user;

    public function setUp()
    {
        parent::setUp();

        $this->userTransformer = new UserTransformer();
        $this->user = factory(User::class)->create();
    }

    public function test_can_transform_user()
    {
        $transformedUser = $this->userTransformer->transform($this->user);

        $this->assertInternalType('array', $transformedUser);
        $this->assertArrayHasKeys($transformedUser, 'id', 'firstname', 'lastname', 'fullname', 'email');
    }
}
