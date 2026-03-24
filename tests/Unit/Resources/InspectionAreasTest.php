<?php

namespace Inventorai\SDK\Tests\Unit\Resources;

use PHPUnit\Framework\TestCase;
use Mockery;
use Inventorai\SDK\Http\Client;
use Inventorai\SDK\Resources\InspectionAreas;

class InspectionAreasTest extends TestCase
{
    protected InspectionAreas $areas;
    protected $mockClient;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockClient = Mockery::mock(Client::class);
        $this->areas = new InspectionAreas($this->mockClient);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_list_areas(): void
    {
        $this->mockClient->shouldReceive('get')
            ->once()
            ->with('/inspections/42/areas', [])
            ->andReturn(['data' => []]);

        $result = $this->areas->list(42);
        $this->assertEquals(['data' => []], $result);
    }

    public function test_list_areas_with_params(): void
    {
        $params = ['include' => 'items'];

        $this->mockClient->shouldReceive('get')
            ->once()
            ->with('/inspections/42/areas', $params)
            ->andReturn(['data' => [['id' => 'area-1']]]);

        $result = $this->areas->list(42, $params);
        $this->assertEquals(['data' => [['id' => 'area-1']]], $result);
    }

    public function test_get_area(): void
    {
        $this->mockClient->shouldReceive('get')
            ->once()
            ->with('/inspections/42/areas/area-1', [])
            ->andReturn(['data' => ['id' => 'area-1', 'name' => 'Living Room']]);

        $result = $this->areas->get(42, 'area-1');
        $this->assertEquals(['data' => ['id' => 'area-1', 'name' => 'Living Room']], $result);
    }

    public function test_get_area_with_params(): void
    {
        $params = ['include' => 'items'];

        $this->mockClient->shouldReceive('get')
            ->once()
            ->with('/inspections/42/areas/area-1', $params)
            ->andReturn(['data' => ['id' => 'area-1']]);

        $result = $this->areas->get(42, 'area-1', $params);
        $this->assertEquals(['data' => ['id' => 'area-1']], $result);
    }

    public function test_create_area(): void
    {
        $data = ['name' => 'Kitchen', 'type' => 'room'];

        $this->mockClient->shouldReceive('post')
            ->once()
            ->with('/inspections/42/areas', $data)
            ->andReturn(['data' => ['id' => 'area-2', 'name' => 'Kitchen']]);

        $result = $this->areas->create(42, $data);
        $this->assertEquals(['data' => ['id' => 'area-2', 'name' => 'Kitchen']], $result);
    }

    public function test_update_area(): void
    {
        $data = ['name' => 'Updated Kitchen'];

        $this->mockClient->shouldReceive('patch')
            ->once()
            ->with('/inspections/42/areas/area-1', $data)
            ->andReturn(['data' => ['id' => 'area-1', 'name' => 'Updated Kitchen']]);

        $result = $this->areas->update(42, 'area-1', $data);
        $this->assertEquals(['data' => ['id' => 'area-1', 'name' => 'Updated Kitchen']], $result);
    }

    public function test_delete_area(): void
    {
        $this->mockClient->shouldReceive('delete')
            ->once()
            ->with('/inspections/42/areas/area-1')
            ->andReturn(['message' => 'Area deleted']);

        $result = $this->areas->delete(42, 'area-1');
        $this->assertEquals(['message' => 'Area deleted'], $result);
    }

    public function test_duplicate_area(): void
    {
        $this->mockClient->shouldReceive('post')
            ->once()
            ->with('/inspections/42/areas/area-1/duplicate')
            ->andReturn(['data' => ['id' => 'area-3', 'name' => 'Living Room (Copy)']]);

        $result = $this->areas->duplicate(42, 'area-1');
        $this->assertEquals(['data' => ['id' => 'area-3', 'name' => 'Living Room (Copy)']], $result);
    }

    public function test_reorder_areas(): void
    {
        $order = ['area-2', 'area-1', 'area-3'];

        $this->mockClient->shouldReceive('post')
            ->once()
            ->with('/inspections/42/areas/reorder', ['order' => $order])
            ->andReturn(['message' => 'Areas reordered']);

        $result = $this->areas->reorder(42, $order);
        $this->assertEquals(['message' => 'Areas reordered'], $result);
    }

    public function test_upload_photo(): void
    {
        $filePath = '/tmp/photo.jpg';

        $this->mockClient->shouldReceive('upload')
            ->once()
            ->with('/inspections/42/areas/area-1/photos', $filePath, 'photo')
            ->andReturn(['data' => ['id' => 'photo-1', 'url' => 'https://example.com/photo.jpg']]);

        $result = $this->areas->uploadPhoto(42, 'area-1', $filePath);
        $this->assertEquals(['data' => ['id' => 'photo-1', 'url' => 'https://example.com/photo.jpg']], $result);
    }

    public function test_delete_photo(): void
    {
        $this->mockClient->shouldReceive('delete')
            ->once()
            ->with('/inspections/42/areas/area-1/photos/photo-1')
            ->andReturn(['message' => 'Photo deleted']);

        $result = $this->areas->deletePhoto(42, 'area-1', 'photo-1');
        $this->assertEquals(['message' => 'Photo deleted'], $result);
    }
}
