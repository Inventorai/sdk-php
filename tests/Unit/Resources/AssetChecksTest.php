<?php

namespace Inventorai\SDK\Tests\Unit\Resources;

use PHPUnit\Framework\TestCase;
use Mockery;
use Inventorai\SDK\Http\Client;
use Inventorai\SDK\Resources\AssetChecks;

class AssetChecksTest extends TestCase
{
    protected AssetChecks $assetChecks;
    protected $mockClient;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockClient = Mockery::mock(Client::class);
        $this->assetChecks = new AssetChecks($this->mockClient);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_update(): void
    {
        $data = ['tested' => 'yes', 'test_result' => 'pass', 'condition' => 'good'];

        $this->mockClient->shouldReceive('put')
            ->once()
            ->with('/inspections/42/asset-checks/7', $data)
            ->andReturn(['data' => ['id' => 7, 'tested' => 'yes']]);

        $result = $this->assetChecks->update(42, 7, $data);
        $this->assertEquals(['data' => ['id' => 7, 'tested' => 'yes']], $result);
    }

    public function test_upload_photo(): void
    {
        $filePath = '/tmp/alarm.jpg';

        $this->mockClient->shouldReceive('upload')
            ->once()
            ->with('/inspections/42/asset-checks/7/photos', $filePath, 'photo')
            ->andReturn(['data' => ['id' => 'photo-1']]);

        $result = $this->assetChecks->uploadPhoto(42, 7, $filePath);
        $this->assertEquals(['data' => ['id' => 'photo-1']], $result);
    }
}
