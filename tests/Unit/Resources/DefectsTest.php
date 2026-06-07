<?php

namespace Inventorai\SDK\Tests\Unit\Resources;

use PHPUnit\Framework\TestCase;
use Mockery;
use Inventorai\SDK\Http\Client;
use Inventorai\SDK\Resources\Defects;

class DefectsTest extends TestCase
{
    protected Defects $defects;
    protected $mockClient;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockClient = Mockery::mock(Client::class);
        $this->defects = new Defects($this->mockClient);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_list_defects(): void
    {
        $this->mockClient->shouldReceive('get')
            ->once()
            ->with('/inspections/42/defects', [])
            ->andReturn(['data' => []]);

        $result = $this->defects->list(42);
        $this->assertEquals(['data' => []], $result);
    }

    public function test_list_defects_with_params(): void
    {
        $params = ['include' => 'photos'];

        $this->mockClient->shouldReceive('get')
            ->once()
            ->with('/inspections/42/defects', $params)
            ->andReturn(['data' => [['id' => 'def-1']]]);

        $result = $this->defects->list(42, $params);
        $this->assertEquals(['data' => [['id' => 'def-1']]], $result);
    }

    public function test_get_defect(): void
    {
        $this->mockClient->shouldReceive('get')
            ->once()
            ->with('/inspections/42/defects/def-1')
            ->andReturn(['data' => ['id' => 'def-1', 'description' => 'Crack in wall']]);

        $result = $this->defects->get(42, 'def-1');
        $this->assertEquals(['data' => ['id' => 'def-1', 'description' => 'Crack in wall']], $result);
    }

    public function test_create_defect(): void
    {
        $data = ['description' => 'Water damage', 'severity' => 'high'];

        $this->mockClient->shouldReceive('post')
            ->once()
            ->with('/inspections/42/defects', $data)
            ->andReturn(['data' => ['id' => 'def-2', 'description' => 'Water damage']]);

        $result = $this->defects->create(42, $data);
        $this->assertEquals(['data' => ['id' => 'def-2', 'description' => 'Water damage']], $result);
    }

    public function test_create_for_area(): void
    {
        $data = ['description' => 'Stained carpet', 'severity' => 'medium'];

        $this->mockClient->shouldReceive('post')
            ->once()
            ->with('/inspections/42/areas/area-1/defects', $data)
            ->andReturn(['data' => ['id' => 'def-3', 'area_id' => 'area-1']]);

        $result = $this->defects->createForArea(42, 'area-1', $data);
        $this->assertEquals(['data' => ['id' => 'def-3', 'area_id' => 'area-1']], $result);
    }

    public function test_create_for_item(): void
    {
        $data = ['description' => 'Broken handle', 'severity' => 'low'];

        $this->mockClient->shouldReceive('post')
            ->once()
            ->with('/inspections/42/items/item-1/defects', $data)
            ->andReturn(['data' => ['id' => 'def-4', 'item_id' => 'item-1']]);

        $result = $this->defects->createForItem(42, 'item-1', $data);
        $this->assertEquals(['data' => ['id' => 'def-4', 'item_id' => 'item-1']], $result);
    }

    public function test_create_for_element(): void
    {
        $data = ['description' => 'Scratched surface', 'severity' => 'low'];

        $this->mockClient->shouldReceive('post')
            ->once()
            ->with('/inspections/42/elements/elem-1/defects', $data)
            ->andReturn(['data' => ['id' => 'def-5', 'element_id' => 'elem-1']]);

        $result = $this->defects->createForElement(42, 'elem-1', $data);
        $this->assertEquals(['data' => ['id' => 'def-5', 'element_id' => 'elem-1']], $result);
    }

    public function test_update_defect(): void
    {
        $data = ['severity' => 'critical'];

        $this->mockClient->shouldReceive('patch')
            ->once()
            ->with('/inspections/42/defects/def-1', $data)
            ->andReturn(['data' => ['id' => 'def-1', 'severity' => 'critical']]);

        $result = $this->defects->update(42, 'def-1', $data);
        $this->assertEquals(['data' => ['id' => 'def-1', 'severity' => 'critical']], $result);
    }

    public function test_delete_defect(): void
    {
        $this->mockClient->shouldReceive('delete')
            ->once()
            ->with('/inspections/42/defects/def-1')
            ->andReturn(['message' => 'Defect deleted']);

        $result = $this->defects->delete(42, 'def-1');
        $this->assertEquals(['message' => 'Defect deleted'], $result);
    }

    public function test_upload_photo(): void
    {
        $filePath = '/tmp/defect-photo.jpg';

        $this->mockClient->shouldReceive('upload')
            ->once()
            ->with('/inspections/42/defects/def-1/photos', $filePath, 'photo', null)
            ->andReturn(['data' => ['id' => 'photo-1', 'url' => 'https://example.com/defect.jpg']]);

        $result = $this->defects->uploadPhoto(42, 'def-1', $filePath);
        $this->assertEquals(['data' => ['id' => 'photo-1', 'url' => 'https://example.com/defect.jpg']], $result);
    }

    public function test_delete_photo(): void
    {
        $this->mockClient->shouldReceive('delete')
            ->once()
            ->with('/inspections/42/defects/def-1/photos/photo-1')
            ->andReturn(['message' => 'Photo deleted']);

        $result = $this->defects->deletePhoto(42, 'def-1', 'photo-1');
        $this->assertEquals(['message' => 'Photo deleted'], $result);
    }
}
