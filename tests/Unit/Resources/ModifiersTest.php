<?php

namespace Inventorai\SDK\Tests\Unit\Resources;

use PHPUnit\Framework\TestCase;
use Mockery;
use Inventorai\SDK\Http\Client;
use Inventorai\SDK\Resources\Modifiers;

class ModifiersTest extends TestCase
{
    protected Modifiers $modifiers;
    protected $mockClient;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockClient = Mockery::mock(Client::class);
        $this->modifiers = new Modifiers($this->mockClient);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_list(): void
    {
        $this->mockClient->shouldReceive('get')
            ->once()
            ->with('/modifiers')
            ->andReturn(['data' => [['id' => 1, 'name' => 'Good']]]);

        $result = $this->modifiers->list();
        $this->assertEquals(['data' => [['id' => 1, 'name' => 'Good']]], $result);
    }

    public function test_types(): void
    {
        $this->mockClient->shouldReceive('get')
            ->once()
            ->with('/modifiers/types')
            ->andReturn(['data' => ['condition', 'cleanliness']]);

        $result = $this->modifiers->types();
        $this->assertEquals(['data' => ['condition', 'cleanliness']], $result);
    }

    public function test_for_item(): void
    {
        $params = ['item_type' => 'carpet'];

        $this->mockClient->shouldReceive('get')
            ->once()
            ->with('/modifiers/for-item', $params)
            ->andReturn(['data' => [['id' => 1, 'name' => 'Worn']]]);

        $result = $this->modifiers->forItem($params);
        $this->assertEquals(['data' => [['id' => 1, 'name' => 'Worn']]], $result);
    }

    public function test_for_item_with_no_params(): void
    {
        $this->mockClient->shouldReceive('get')
            ->once()
            ->with('/modifiers/for-item', [])
            ->andReturn(['data' => []]);

        $result = $this->modifiers->forItem();
        $this->assertEquals(['data' => []], $result);
    }

    public function test_search(): void
    {
        $params = ['query' => 'clean'];

        $this->mockClient->shouldReceive('get')
            ->once()
            ->with('/modifiers/search', $params)
            ->andReturn(['data' => [['id' => 2, 'name' => 'Clean']]]);

        $result = $this->modifiers->search($params);
        $this->assertEquals(['data' => [['id' => 2, 'name' => 'Clean']]], $result);
    }

    public function test_disabled(): void
    {
        $this->mockClient->shouldReceive('get')
            ->once()
            ->with('/modifiers/disabled')
            ->andReturn(['data' => [['id' => 3, 'name' => 'Obsolete']]]);

        $result = $this->modifiers->disabled();
        $this->assertEquals(['data' => [['id' => 3, 'name' => 'Obsolete']]], $result);
    }

    public function test_master(): void
    {
        $this->mockClient->shouldReceive('get')
            ->once()
            ->with('/modifiers/master')
            ->andReturn(['data' => [['id' => 1, 'name' => 'Good'], ['id' => 2, 'name' => 'Fair']]]);

        $result = $this->modifiers->master();
        $this->assertEquals(['data' => [['id' => 1, 'name' => 'Good'], ['id' => 2, 'name' => 'Fair']]], $result);
    }

    public function test_create_custom(): void
    {
        $data = ['name' => 'Custom Modifier', 'type' => 'condition'];

        $this->mockClient->shouldReceive('post')
            ->once()
            ->with('/modifiers/custom', $data)
            ->andReturn(['data' => ['id' => 100, 'name' => 'Custom Modifier']]);

        $result = $this->modifiers->createCustom($data);
        $this->assertEquals(['data' => ['id' => 100, 'name' => 'Custom Modifier']], $result);
    }

    public function test_delete_custom(): void
    {
        $this->mockClient->shouldReceive('delete')
            ->once()
            ->with('/modifiers/custom/100')
            ->andReturn(['message' => 'Modifier deleted']);

        $result = $this->modifiers->deleteCustom(100);
        $this->assertEquals(['message' => 'Modifier deleted'], $result);
    }

    public function test_disable(): void
    {
        $this->mockClient->shouldReceive('post')
            ->once()
            ->with('/modifiers/5/disable')
            ->andReturn(['data' => ['id' => 5, 'disabled' => true]]);

        $result = $this->modifiers->disable(5);
        $this->assertEquals(['data' => ['id' => 5, 'disabled' => true]], $result);
    }

    public function test_enable(): void
    {
        $this->mockClient->shouldReceive('post')
            ->once()
            ->with('/modifiers/5/enable')
            ->andReturn(['data' => ['id' => 5, 'disabled' => false]]);

        $result = $this->modifiers->enable(5);
        $this->assertEquals(['data' => ['id' => 5, 'disabled' => false]], $result);
    }

    public function test_compose(): void
    {
        $data = ['modifiers' => [1, 2, 3], 'context' => 'living room'];

        $this->mockClient->shouldReceive('post')
            ->once()
            ->with('/modifiers/compose', $data)
            ->andReturn(['data' => ['composed' => 'Good, clean and tidy']]);

        $result = $this->modifiers->compose($data);
        $this->assertEquals(['data' => ['composed' => 'Good, clean and tidy']], $result);
    }
}
