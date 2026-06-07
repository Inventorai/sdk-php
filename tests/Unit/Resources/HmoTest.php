<?php

namespace Inventorai\SDK\Tests\Unit\Resources;

use PHPUnit\Framework\TestCase;
use Mockery;
use Inventorai\SDK\Http\Client;
use Inventorai\SDK\Resources\Hmo;

class HmoTest extends TestCase
{
    protected Hmo $hmo;
    protected $mockClient;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockClient = Mockery::mock(Client::class);
        $this->hmo = new Hmo($this->mockClient);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_summary(): void
    {
        $this->mockClient->shouldReceive('get')
            ->once()
            ->with('/inspections/1/hmo/summary')
            ->andReturn(['data' => ['tenant_groups' => []]]);

        $this->assertEquals(['data' => ['tenant_groups' => []]], $this->hmo->summary(1));
    }

    public function test_tenants(): void
    {
        $this->mockClient->shouldReceive('get')
            ->once()
            ->with('/inspections/1/hmo/tenants')
            ->andReturn(['data' => []]);

        $this->assertEquals(['data' => []], $this->hmo->tenants(1));
    }

    public function test_assign_tenant_to_area(): void
    {
        $payload = ['tenant_ids' => ['t1'], 'is_shared' => false];
        $this->mockClient->shouldReceive('put')
            ->once()
            ->with('/inspections/1/hmo/areas/area-1/assign', $payload)
            ->andReturn(['data' => ['id' => 'area-1']]);

        $this->assertEquals(['data' => ['id' => 'area-1']], $this->hmo->assignTenantToArea(1, 'area-1', $payload));
    }

    public function test_bulk_assign_tenants(): void
    {
        $payload = ['assignments' => [['area_id' => 'a1', 'tenant_ids' => ['t1']]]];
        $this->mockClient->shouldReceive('post')
            ->once()
            ->with('/inspections/1/hmo/bulk-assign', $payload)
            ->andReturn(['success' => true]);

        $this->assertEquals(['success' => true], $this->hmo->bulkAssignTenants(1, $payload));
    }
}
