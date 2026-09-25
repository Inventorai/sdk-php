<?php

namespace Inventorai\SDK\Tests\Unit\Resources;

use PHPUnit\Framework\TestCase;
use Mockery;
use Inventorai\SDK\Http\Client;
use Inventorai\SDK\Resources\Hazards;

class HazardsTest extends TestCase
{
    protected Hazards $resource;
    protected $mockClient;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockClient = Mockery::mock(Client::class);
        $this->resource = new Hazards($this->mockClient);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_sync(): void
    {
        $this->mockClient->shouldReceive('get')
            ->once()
            ->with('/hazards/sync')
            ->andReturn(['data' => []]);

        $result = $this->resource->sync();
        $this->assertEquals(['data' => []], $result);
    }
}
