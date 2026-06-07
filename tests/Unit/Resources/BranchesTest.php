<?php

namespace Inventorai\SDK\Tests\Unit\Resources;

use PHPUnit\Framework\TestCase;
use Mockery;
use Inventorai\SDK\Http\Client;
use Inventorai\SDK\Resources\Branches;

class BranchesTest extends TestCase
{
    protected Branches $branches;
    protected $mockClient;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockClient = Mockery::mock(Client::class);
        $this->branches = new Branches($this->mockClient);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_list(): void
    {
        $this->mockClient->shouldReceive('buildQuery')->once()->with([])->andReturn([]);
        $this->mockClient->shouldReceive('get')
            ->once()
            ->with('/branches', [])
            ->andReturn(['data' => []]);

        $result = $this->branches->list();
        $this->assertEquals(['data' => []], $result);
    }

    public function test_get(): void
    {
        $this->mockClient->shouldReceive('buildQuery')->once()->with([])->andReturn([]);
        $this->mockClient->shouldReceive('get')
            ->once()
            ->with('/branches/42', [])
            ->andReturn(['data' => ['id' => 42, 'name' => 'London']]);

        $result = $this->branches->get(42);
        $this->assertEquals(['data' => ['id' => 42, 'name' => 'London']], $result);
    }
}
