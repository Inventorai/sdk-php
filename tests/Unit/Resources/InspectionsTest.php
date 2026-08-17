<?php

namespace Inventorai\SDK\Tests\Unit\Resources;

use PHPUnit\Framework\TestCase;
use Mockery;
use Inventorai\SDK\Http\Client;
use Inventorai\SDK\Resources\Inspections;

class InspectionsTest extends TestCase
{
    protected Inspections $inspections;
    protected $mockClient;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockClient = Mockery::mock(Client::class);
        $this->inspections = new Inspections($this->mockClient);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_list_inspections_with_no_params(): void
    {
        $this->mockClient->shouldReceive('buildQuery')
            ->once()
            ->with([])
            ->andReturn([]);
        $this->mockClient->shouldReceive('get')
            ->once()
            ->with('/inspections', [])
            ->andReturn(['data' => []]);

        $result = $this->inspections->list();
        $this->assertEquals(['data' => []], $result);
    }

    public function test_list_inspections_with_params(): void
    {
        $params = ['filter' => ['status' => 'scheduled'], 'per_page' => 10];
        $builtQuery = ['filter[status]' => 'scheduled', 'per_page' => 10];

        $this->mockClient->shouldReceive('buildQuery')
            ->once()
            ->with($params)
            ->andReturn($builtQuery);
        $this->mockClient->shouldReceive('get')
            ->once()
            ->with('/inspections', $builtQuery)
            ->andReturn(['data' => [['id' => 1]]]);

        $result = $this->inspections->list($params);
        $this->assertEquals(['data' => [['id' => 1]]], $result);
    }

    public function test_get_inspection(): void
    {
        $this->mockClient->shouldReceive('buildQuery')
            ->once()
            ->with([])
            ->andReturn([]);
        $this->mockClient->shouldReceive('get')
            ->once()
            ->with('/inspections/42', [])
            ->andReturn(['data' => ['id' => 42]]);

        $result = $this->inspections->get(42);
        $this->assertEquals(['data' => ['id' => 42]], $result);
    }

    public function test_get_inspection_with_includes(): void
    {
        $params = ['include' => ['property', 'areas']];
        $builtQuery = ['include' => 'property,areas'];

        $this->mockClient->shouldReceive('buildQuery')
            ->once()
            ->with($params)
            ->andReturn($builtQuery);
        $this->mockClient->shouldReceive('get')
            ->once()
            ->with('/inspections/42', $builtQuery)
            ->andReturn(['data' => ['id' => 42]]);

        $result = $this->inspections->get(42, $params);
        $this->assertEquals(['data' => ['id' => 42]], $result);
    }

    public function test_create_inspection(): void
    {
        $data = ['property_id' => 1, 'type' => 'check_in'];

        $this->mockClient->shouldReceive('post')
            ->once()
            ->with('/inspections', $data)
            ->andReturn(['data' => ['id' => 100, 'property_id' => 1]]);

        $result = $this->inspections->create($data);
        $this->assertEquals(['data' => ['id' => 100, 'property_id' => 1]], $result);
    }

    public function test_check_existing(): void
    {
        $params = ['property_id' => 1, 'type' => 'check_in'];

        $this->mockClient->shouldReceive('get')
            ->once()
            ->with('/inspections/check-existing', $params)
            ->andReturn(['data' => ['exists' => true]]);

        $result = $this->inspections->checkExisting($params);
        $this->assertEquals(['data' => ['exists' => true]], $result);
    }

    public function test_check_existing_with_no_params(): void
    {
        $this->mockClient->shouldReceive('get')
            ->once()
            ->with('/inspections/check-existing', [])
            ->andReturn(['data' => []]);

        $result = $this->inspections->checkExisting();
        $this->assertEquals(['data' => []], $result);
    }

    public function test_comparable(): void
    {
        $params = ['property_id' => 5];

        $this->mockClient->shouldReceive('get')
            ->once()
            ->with('/inspections/comparable', $params)
            ->andReturn(['data' => [['id' => 10]]]);

        $result = $this->inspections->comparable($params);
        $this->assertEquals(['data' => [['id' => 10]]], $result);
    }

    public function test_comparable_with_no_params(): void
    {
        $this->mockClient->shouldReceive('get')
            ->once()
            ->with('/inspections/comparable', [])
            ->andReturn(['data' => []]);

        $result = $this->inspections->comparable();
        $this->assertEquals(['data' => []], $result);
    }

    public function test_begin_inspection(): void
    {
        $this->mockClient->shouldReceive('post')
            ->once()
            ->with('/inspections/42/begin')
            ->andReturn(['data' => ['id' => 42, 'status' => 'in_progress']]);

        $result = $this->inspections->begin(42);
        $this->assertEquals(['data' => ['id' => 42, 'status' => 'in_progress']], $result);
    }

    public function test_finalize_inspection(): void
    {
        $data = ['notes' => 'Completed successfully'];

        $this->mockClient->shouldReceive('post')
            ->once()
            ->with('/inspections/42/finalize', $data)
            ->andReturn(['data' => ['id' => 42, 'status' => 'finalized']]);

        $result = $this->inspections->finalize(42, $data);
        $this->assertEquals(['data' => ['id' => 42, 'status' => 'finalized']], $result);
    }

    public function test_finalize_inspection_with_no_data(): void
    {
        $this->mockClient->shouldReceive('post')
            ->once()
            ->with('/inspections/42/finalize', [])
            ->andReturn(['data' => ['id' => 42, 'status' => 'finalized']]);

        $result = $this->inspections->finalize(42);
        $this->assertEquals(['data' => ['id' => 42, 'status' => 'finalized']], $result);
    }

    public function test_reschedule_inspection(): void
    {
        $data = ['scheduled_at' => '2026-04-01 10:00:00'];

        $this->mockClient->shouldReceive('patch')
            ->once()
            ->with('/inspections/42/reschedule', $data)
            ->andReturn(['data' => ['id' => 42, 'scheduled_at' => '2026-04-01 10:00:00']]);

        $result = $this->inspections->reschedule(42, $data);
        $this->assertEquals(['data' => ['id' => 42, 'scheduled_at' => '2026-04-01 10:00:00']], $result);
    }

    public function test_upload_cover_image(): void
    {
        $filePath = '/tmp/cover.jpg';

        $this->mockClient->shouldReceive('upload')
            ->once()
            ->with('/inspections/42/cover-image', $filePath, 'cover_image')
            ->andReturn(['data' => ['url' => 'https://example.com/cover.jpg']]);

        $result = $this->inspections->uploadCoverImage(42, $filePath);
        $this->assertEquals(['data' => ['url' => 'https://example.com/cover.jpg']], $result);
    }

    public function test_delete_cover_image(): void
    {
        $this->mockClient->shouldReceive('delete')
            ->once()
            ->with('/inspections/42/cover-image')
            ->andReturn(['message' => 'Cover image deleted']);

        $result = $this->inspections->deleteCoverImage(42);
        $this->assertEquals(['message' => 'Cover image deleted'], $result);
    }

    public function test_reopen_inspection(): void
    {
        $this->mockClient->shouldReceive('post')
            ->once()
            ->with('/inspections/42/reopen')
            ->andReturn(['data' => ['id' => 42, 'status' => 'in_progress']]);

        $result = $this->inspections->reopen(42);
        $this->assertEquals(['data' => ['id' => 42, 'status' => 'in_progress']], $result);
    }

    public function test_delete_inspection(): void
    {
        $this->mockClient->shouldReceive('delete')
            ->once()
            ->with('/inspections/42')
            ->andReturn(['message' => 'Inspection deleted']);

        $result = $this->inspections->delete(42);
        $this->assertEquals(['message' => 'Inspection deleted'], $result);
    }
}
