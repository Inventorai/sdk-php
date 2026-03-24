<?php

namespace Inventorai\SDK\Tests\Unit\Resources;

use PHPUnit\Framework\TestCase;
use Mockery;
use Inventorai\SDK\Http\Client;
use Inventorai\SDK\Resources\Stats;

class StatsTest extends TestCase
{
    protected Stats $stats;
    protected $mockClient;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockClient = Mockery::mock(Client::class);
        $this->stats = new Stats($this->mockClient);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_index(): void
    {
        $this->mockClient->shouldReceive('get')
            ->once()
            ->with('/stats')
            ->andReturn(['data' => ['total_properties' => 50, 'total_inspections' => 120]]);

        $result = $this->stats->index();
        $this->assertEquals(['data' => ['total_properties' => 50, 'total_inspections' => 120]], $result);
    }

    public function test_team(): void
    {
        $this->mockClient->shouldReceive('get')
            ->once()
            ->with('/stats/team')
            ->andReturn(['data' => ['members' => 5, 'inspections_this_month' => 30]]);

        $result = $this->stats->team();
        $this->assertEquals(['data' => ['members' => 5, 'inspections_this_month' => 30]], $result);
    }

    public function test_user(): void
    {
        $this->mockClient->shouldReceive('get')
            ->once()
            ->with('/stats/user')
            ->andReturn(['data' => ['inspections_completed' => 15, 'average_duration' => 45]]);

        $result = $this->stats->user();
        $this->assertEquals(['data' => ['inspections_completed' => 15, 'average_duration' => 45]], $result);
    }

    public function test_schedule(): void
    {
        $this->mockClient->shouldReceive('get')
            ->once()
            ->with('/dashboard/schedule')
            ->andReturn(['data' => ['upcoming' => [['id' => 1, 'date' => '2026-03-15']]]]);

        $result = $this->stats->schedule();
        $this->assertEquals(['data' => ['upcoming' => [['id' => 1, 'date' => '2026-03-15']]]], $result);
    }
}
