<?php

namespace Inventorai\SDK\Tests\Unit\Resources;

use PHPUnit\Framework\TestCase;
use Mockery;
use Inventorai\SDK\Http\Client;
use Inventorai\SDK\Resources\AddressLookup;

class AddressLookupTest extends TestCase
{
    protected AddressLookup $addressLookup;
    protected $mockClient;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockClient = Mockery::mock(Client::class);
        $this->addressLookup = new AddressLookup($this->mockClient);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_lookup(): void
    {
        $this->mockClient->shouldReceive('post')
            ->once()
            ->with('/address-lookup/lookup', ['postcode' => 'SW1A 1AA'])
            ->andReturn(['data' => [['address' => '10 Downing Street']]]);

        $result = $this->addressLookup->lookup('SW1A 1AA');
        $this->assertEquals(['data' => [['address' => '10 Downing Street']]], $result);
    }

    public function test_bulk_lookup(): void
    {
        $postcodes = ['SW1A 1AA', 'EC1A 1BB'];

        $this->mockClient->shouldReceive('post')
            ->once()
            ->with('/address-lookup/bulk-lookup', ['postcodes' => $postcodes])
            ->andReturn(['data' => ['SW1A 1AA' => [['address' => '10 Downing Street']]]]);

        $result = $this->addressLookup->bulkLookup($postcodes);
        $this->assertEquals(['data' => ['SW1A 1AA' => [['address' => '10 Downing Street']]]], $result);
    }

    public function test_get_details(): void
    {
        $data = ['udprn' => '12345678'];

        $this->mockClient->shouldReceive('post')
            ->once()
            ->with('/address-lookup/details', $data)
            ->andReturn(['data' => ['address_line_1' => '10 Downing Street', 'postcode' => 'SW1A 1AA']]);

        $result = $this->addressLookup->getDetails($data);
        $this->assertEquals(['data' => ['address_line_1' => '10 Downing Street', 'postcode' => 'SW1A 1AA']], $result);
    }

    public function test_usage(): void
    {
        $this->mockClient->shouldReceive('get')
            ->once()
            ->with('/address-lookup/usage')
            ->andReturn(['data' => ['used' => 150, 'limit' => 1000]]);

        $result = $this->addressLookup->usage();
        $this->assertEquals(['data' => ['used' => 150, 'limit' => 1000]], $result);
    }
}
