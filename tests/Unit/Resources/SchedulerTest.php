<?php

namespace Inventorai\SDK\Tests\Unit\Resources;

use PHPUnit\Framework\TestCase;
use Mockery;
use Inventorai\SDK\Http\Client;
use Inventorai\SDK\Resources\Scheduler;

class SchedulerTest extends TestCase
{
    protected Scheduler $scheduler;
    protected $mockClient;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockClient = Mockery::mock(Client::class);
        $this->scheduler = new Scheduler($this->mockClient);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_calendar(): void
    {
        $this->mockClient->shouldReceive('get')
            ->once()
            ->with('/inspections/scheduler/calendar', [])
            ->andReturn(['data' => ['events' => []]]);

        $result = $this->scheduler->calendar();
        $this->assertEquals(['data' => ['events' => []]], $result);
    }

    public function test_calendar_with_params(): void
    {
        $params = ['month' => '2026-03', 'user_id' => 1];

        $this->mockClient->shouldReceive('get')
            ->once()
            ->with('/inspections/scheduler/calendar', $params)
            ->andReturn(['data' => ['events' => [['id' => 1, 'date' => '2026-03-15']]]]);

        $result = $this->scheduler->calendar($params);
        $this->assertEquals(['data' => ['events' => [['id' => 1, 'date' => '2026-03-15']]]], $result);
    }

    public function test_weekly_availability(): void
    {
        $data = [
            'monday' => ['09:00', '17:00'],
            'tuesday' => ['09:00', '17:00'],
        ];

        $this->mockClient->shouldReceive('post')
            ->once()
            ->with('/inspections/scheduler/availability/weekly', $data)
            ->andReturn(['data' => ['updated' => true]]);

        $result = $this->scheduler->weeklyAvailability($data);
        $this->assertEquals(['data' => ['updated' => true]], $result);
    }

    public function test_check_conflicts(): void
    {
        $data = ['date' => '2026-03-20', 'start_time' => '10:00', 'end_time' => '12:00'];

        $this->mockClient->shouldReceive('post')
            ->once()
            ->with('/inspections/scheduler/availability/check-conflicts', $data)
            ->andReturn(['data' => ['has_conflicts' => false, 'conflicts' => []]]);

        $result = $this->scheduler->checkConflicts($data);
        $this->assertEquals(['data' => ['has_conflicts' => false, 'conflicts' => []]], $result);
    }

    public function test_office_hours(): void
    {
        $this->mockClient->shouldReceive('get')
            ->once()
            ->with('/inspections/scheduler/office-hours')
            ->andReturn(['data' => ['start' => '09:00', 'end' => '17:00']]);

        $result = $this->scheduler->officeHours();
        $this->assertEquals(['data' => ['start' => '09:00', 'end' => '17:00']], $result);
    }

    public function test_estimate_duration(): void
    {
        $data = ['property_id' => 1, 'inspection_type' => 'check_in'];

        $this->mockClient->shouldReceive('post')
            ->once()
            ->with('/inspections/scheduler/estimate-duration', $data)
            ->andReturn(['data' => ['estimated_minutes' => 60]]);

        $result = $this->scheduler->estimateDuration($data);
        $this->assertEquals(['data' => ['estimated_minutes' => 60]], $result);
    }
}
