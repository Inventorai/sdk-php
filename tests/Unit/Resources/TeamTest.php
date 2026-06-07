<?php

namespace Inventorai\SDK\Tests\Unit\Resources;

use Inventorai\SDK\Http\Client;
use Inventorai\SDK\Resources\Team;
use Mockery;
use PHPUnit\Framework\TestCase;

class TeamTest extends TestCase
{
    protected Team $team;

    protected $mockClient;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockClient = Mockery::mock(Client::class);
        $this->team = new Team($this->mockClient);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_current_hits_root_of_team_base_url(): void
    {
        $payload = [
            'data' => [
                'id' => '01HXYZ',
                'name' => 'Acme Lettings',
                'slug' => 'acme-lettings',
                'subscription' => ['subscribed' => true],
            ],
        ];

        $this->mockClient->shouldReceive('get')
            ->once()
            ->with('')
            ->andReturn($payload);

        $this->assertSame($payload, $this->team->current());
    }
}
