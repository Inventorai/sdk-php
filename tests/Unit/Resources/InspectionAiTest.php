<?php

namespace Inventorai\SDK\Tests\Unit\Resources;

use PHPUnit\Framework\TestCase;
use Mockery;
use Inventorai\SDK\Http\Client;
use Inventorai\SDK\Resources\InspectionAi;

class InspectionAiTest extends TestCase
{
    protected InspectionAi $ai;
    protected $mockClient;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockClient = Mockery::mock(Client::class);
        $this->ai = new InspectionAi($this->mockClient);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_enable_ai(): void
    {
        $this->mockClient->shouldReceive('post')
            ->once()
            ->with('/inspections/42/ai/enable')
            ->andReturn(['data' => ['enabled' => true]]);

        $result = $this->ai->enable(42);
        $this->assertEquals(['data' => ['enabled' => true]], $result);
    }

    public function test_disable_ai(): void
    {
        $this->mockClient->shouldReceive('post')
            ->once()
            ->with('/inspections/42/ai/disable')
            ->andReturn(['data' => ['enabled' => false]]);

        $result = $this->ai->disable(42);
        $this->assertEquals(['data' => ['enabled' => false]], $result);
    }

    public function test_status(): void
    {
        $this->mockClient->shouldReceive('get')
            ->once()
            ->with('/inspections/42/ai/status')
            ->andReturn(['data' => ['enabled' => true, 'credits' => 5]]);

        $result = $this->ai->status(42);
        $this->assertEquals(['data' => ['enabled' => true, 'credits' => 5]], $result);
    }

    public function test_retry_credits(): void
    {
        $this->mockClient->shouldReceive('post')
            ->once()
            ->with('/inspections/42/ai/retry-credits')
            ->andReturn(['data' => ['credits' => 3]]);

        $result = $this->ai->retryCredits(42);
        $this->assertEquals(['data' => ['credits' => 3]], $result);
    }

    public function test_request_retry(): void
    {
        $this->mockClient->shouldReceive('post')
            ->once()
            ->with('/inspections/42/ai/request-retry')
            ->andReturn(['data' => ['retry_requested' => true]]);

        $result = $this->ai->requestRetry(42);
        $this->assertEquals(['data' => ['retry_requested' => true]], $result);
    }

    public function test_retry_status(): void
    {
        $this->mockClient->shouldReceive('get')
            ->once()
            ->with('/inspections/42/ai/retry-status')
            ->andReturn(['data' => ['status' => 'pending', 'retries_remaining' => 2]]);

        $result = $this->ai->retryStatus(42);
        $this->assertEquals(['data' => ['status' => 'pending', 'retries_remaining' => 2]], $result);
    }

    public function test_submit_feedback(): void
    {
        $data = ['rating' => 4, 'comment' => 'Good accuracy'];

        $this->mockClient->shouldReceive('post')
            ->once()
            ->with('/inspections/42/ai/feedback', $data)
            ->andReturn(['data' => ['id' => 1, 'rating' => 4]]);

        $result = $this->ai->submitFeedback(42, $data);
        $this->assertEquals(['data' => ['id' => 1, 'rating' => 4]], $result);
    }
}
