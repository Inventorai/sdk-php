<?php

namespace Inventorai\SDK\Tests\Unit\Resources;

use PHPUnit\Framework\TestCase;
use Mockery;
use Inventorai\SDK\Http\Client;
use Inventorai\SDK\Resources\User;

class UserTest extends TestCase
{
    protected User $user;
    protected $mockClient;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockClient = Mockery::mock(Client::class);
        $this->user = new User($this->mockClient);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_me_returns_authenticated_user(): void
    {
        $this->mockClient->shouldReceive('get')
            ->once()
            ->with('/user')
            ->andReturn(['data' => ['id' => 1, 'name' => 'Test User', 'email' => 'test@example.com']]);

        $result = $this->user->me();
        $this->assertEquals(['data' => ['id' => 1, 'name' => 'Test User', 'email' => 'test@example.com']], $result);
    }
}
