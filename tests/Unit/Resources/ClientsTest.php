<?php

namespace Inventorai\SDK\Tests\Unit\Resources;

use PHPUnit\Framework\TestCase;
use Mockery;
use Inventorai\SDK\Http\Client;
use Inventorai\SDK\Resources\Clients;

class ClientsTest extends TestCase
{
    protected Clients $clients;
    protected $mockClient;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockClient = Mockery::mock(Client::class);
        $this->clients = new Clients($this->mockClient);
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
            ->with('/clients', [])
            ->andReturn(['data' => []]);

        $result = $this->clients->list();
        $this->assertEquals(['data' => []], $result);
    }

    public function test_get(): void
    {
        $this->mockClient->shouldReceive('buildQuery')->once()->with([])->andReturn([]);
        $this->mockClient->shouldReceive('get')
            ->once()
            ->with('/clients/42', [])
            ->andReturn(['data' => ['id' => 42, 'name' => 'Acme Lettings']]);

        $result = $this->clients->get(42);
        $this->assertEquals(['data' => ['id' => 42, 'name' => 'Acme Lettings']], $result);
    }

    public function test_list_with_scope_and_filters(): void
    {
        $params = ['scope' => 'mine', 'filter' => ['kind' => 'agency']];
        $this->mockClient->shouldReceive('buildQuery')->once()->with($params)->andReturn(['scope' => 'mine', 'filter[kind]' => 'agency']);
        $this->mockClient->shouldReceive('get')
            ->once()
            ->with('/clients', ['scope' => 'mine', 'filter[kind]' => 'agency'])
            ->andReturn(['data' => []]);

        $this->assertEquals(['data' => []], $this->clients->list($params));
    }

    public function test_groups(): void
    {
        $this->mockClient->shouldReceive('buildQuery')->once()->with([])->andReturn([]);
        $this->mockClient->shouldReceive('get')
            ->once()
            ->with('/clients/groups', [])
            ->andReturn(['data' => []]);

        $this->assertEquals(['data' => []], $this->clients->groups());
    }

    public function test_group(): void
    {
        $this->mockClient->shouldReceive('buildQuery')->once()->with([])->andReturn([]);
        $this->mockClient->shouldReceive('get')
            ->once()
            ->with('/clients/groups/9', [])
            ->andReturn(['data' => ['id' => 9]]);

        $this->assertEquals(['data' => ['id' => 9]], $this->clients->group(9));
    }
}
