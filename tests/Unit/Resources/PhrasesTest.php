<?php

namespace Inventorai\SDK\Tests\Unit\Resources;

use PHPUnit\Framework\TestCase;
use Mockery;
use Inventorai\SDK\Http\Client;
use Inventorai\SDK\Resources\Phrases;

class PhrasesTest extends TestCase
{
    protected Phrases $phrases;
    protected $mockClient;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockClient = Mockery::mock(Client::class);
        $this->phrases = new Phrases($this->mockClient);
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
            ->with('/phrases/sync')
            ->andReturn(['data' => ['phrases' => []]]);

        $result = $this->phrases->sync();
        $this->assertEquals(['data' => ['phrases' => []]], $result);
    }

    public function test_search(): void
    {
        $params = ['query' => 'clean', 'category' => 'condition'];

        $this->mockClient->shouldReceive('get')
            ->once()
            ->with('/phrases/search', $params)
            ->andReturn(['data' => [['id' => 1, 'text' => 'Clean and tidy']]]);

        $result = $this->phrases->search($params);
        $this->assertEquals(['data' => [['id' => 1, 'text' => 'Clean and tidy']]], $result);
    }

    public function test_create(): void
    {
        $data = ['text' => 'In good condition', 'category' => 'condition'];

        $this->mockClient->shouldReceive('post')
            ->once()
            ->with('/phrases', $data)
            ->andReturn(['data' => ['id' => 10, 'text' => 'In good condition']]);

        $result = $this->phrases->create($data);
        $this->assertEquals(['data' => ['id' => 10, 'text' => 'In good condition']], $result);
    }

    public function test_generate(): void
    {
        $data = ['context' => 'kitchen condition', 'count' => 5];

        $this->mockClient->shouldReceive('post')
            ->once()
            ->with('/phrases/generate', $data)
            ->andReturn(['data' => ['phrases' => ['Clean and tidy', 'Well maintained']]]);

        $result = $this->phrases->generate($data);
        $this->assertEquals(['data' => ['phrases' => ['Clean and tidy', 'Well maintained']]], $result);
    }

    public function test_learn(): void
    {
        $data = ['text' => 'Slight wear and tear on carpet', 'context' => 'flooring'];

        $this->mockClient->shouldReceive('post')
            ->once()
            ->with('/phrases/learn', $data)
            ->andReturn(['data' => ['learned' => true]]);

        $result = $this->phrases->learn($data);
        $this->assertEquals(['data' => ['learned' => true]], $result);
    }

    public function test_stats(): void
    {
        $this->mockClient->shouldReceive('get')
            ->once()
            ->with('/phrases/stats')
            ->andReturn(['data' => ['total' => 200, 'custom' => 50]]);

        $result = $this->phrases->stats();
        $this->assertEquals(['data' => ['total' => 200, 'custom' => 50]], $result);
    }
}
