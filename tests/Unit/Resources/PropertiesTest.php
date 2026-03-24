<?php

namespace Inventorai\SDK\Tests\Unit\Resources;

use PHPUnit\Framework\TestCase;
use Mockery;
use Inventorai\SDK\Http\Client;
use Inventorai\SDK\Resources\Properties;

class PropertiesTest extends TestCase
{
    protected Properties $properties;
    protected $mockClient;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockClient = Mockery::mock(Client::class);
        $this->properties = new Properties($this->mockClient);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_list_properties_with_no_params(): void
    {
        $this->mockClient->shouldReceive('buildQuery')
            ->once()
            ->with([])
            ->andReturn([]);
        $this->mockClient->shouldReceive('get')
            ->once()
            ->with('/properties', [])
            ->andReturn(['data' => []]);

        $result = $this->properties->list();
        $this->assertEquals(['data' => []], $result);
    }

    public function test_list_properties_with_params(): void
    {
        $params = ['filter' => ['status' => 'active'], 'per_page' => 25];
        $builtQuery = ['filter[status]' => 'active', 'per_page' => 25];

        $this->mockClient->shouldReceive('buildQuery')
            ->once()
            ->with($params)
            ->andReturn($builtQuery);
        $this->mockClient->shouldReceive('get')
            ->once()
            ->with('/properties', $builtQuery)
            ->andReturn(['data' => [['id' => 1]]]);

        $result = $this->properties->list($params);
        $this->assertEquals(['data' => [['id' => 1]]], $result);
    }

    public function test_get_property(): void
    {
        $this->mockClient->shouldReceive('buildQuery')
            ->once()
            ->with([])
            ->andReturn([]);
        $this->mockClient->shouldReceive('get')
            ->once()
            ->with('/properties/123', [])
            ->andReturn(['data' => ['id' => 123]]);

        $result = $this->properties->get(123);
        $this->assertEquals(['data' => ['id' => 123]], $result);
    }

    public function test_get_property_with_includes(): void
    {
        $params = ['include' => ['landlord', 'inspections']];
        $builtQuery = ['include' => 'landlord,inspections'];

        $this->mockClient->shouldReceive('buildQuery')
            ->once()
            ->with($params)
            ->andReturn($builtQuery);
        $this->mockClient->shouldReceive('get')
            ->once()
            ->with('/properties/456', $builtQuery)
            ->andReturn(['data' => ['id' => 456]]);

        $result = $this->properties->get(456, $params);
        $this->assertEquals(['data' => ['id' => 456]], $result);
    }

    public function test_create_property(): void
    {
        $data = ['address_line_1' => '123 Test St', 'postcode' => 'SW1A 1AA'];

        $this->mockClient->shouldReceive('post')
            ->once()
            ->with('/properties', $data)
            ->andReturn(['data' => ['id' => 1, 'address_line_1' => '123 Test St']]);

        $result = $this->properties->create($data);
        $this->assertEquals(['data' => ['id' => 1, 'address_line_1' => '123 Test St']], $result);
    }

    public function test_active_tenancy(): void
    {
        $this->mockClient->shouldReceive('get')
            ->once()
            ->with('/properties/123/active-tenancy')
            ->andReturn(['data' => ['id' => 10, 'property_id' => 123]]);

        $result = $this->properties->activeTenancy(123);
        $this->assertEquals(['data' => ['id' => 10, 'property_id' => 123]], $result);
    }

    public function test_upload_cover_image(): void
    {
        $filePath = '/tmp/test-image.jpg';

        $this->mockClient->shouldReceive('upload')
            ->once()
            ->with('/properties/123/cover-image', $filePath, 'cover_image')
            ->andReturn(['data' => ['url' => 'https://example.com/image.jpg']]);

        $result = $this->properties->uploadCoverImage(123, $filePath);
        $this->assertEquals(['data' => ['url' => 'https://example.com/image.jpg']], $result);
    }

    public function test_delete_cover_image(): void
    {
        $this->mockClient->shouldReceive('delete')
            ->once()
            ->with('/properties/123/cover-image')
            ->andReturn(['message' => 'Cover image deleted']);

        $result = $this->properties->deleteCoverImage(123);
        $this->assertEquals(['message' => 'Cover image deleted'], $result);
    }

    public function test_get_property_with_string_id(): void
    {
        $this->mockClient->shouldReceive('buildQuery')
            ->once()
            ->with([])
            ->andReturn([]);
        $this->mockClient->shouldReceive('get')
            ->once()
            ->with('/properties/abc-123', [])
            ->andReturn(['data' => ['id' => 'abc-123']]);

        $result = $this->properties->get('abc-123');
        $this->assertEquals(['data' => ['id' => 'abc-123']], $result);
    }
}
