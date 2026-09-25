<?php

namespace Inventorai\SDK\Tests\Unit\Resources;

use PHPUnit\Framework\TestCase;
use Mockery;
use Inventorai\SDK\Http\Client;
use Inventorai\SDK\Resources\Vocabulary;

class VocabularyTest extends TestCase
{
    protected Vocabulary $resource;
    protected $mockClient;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockClient = Mockery::mock(Client::class);
        $this->resource = new Vocabulary($this->mockClient);
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
            ->with('/vocabulary/sync')
            ->andReturn(['data' => []]);

        $result = $this->resource->sync();
        $this->assertEquals(['data' => []], $result);
    }
}
