<?php

namespace Inventorai\SDK\Tests\Unit\Http;

use PHPUnit\Framework\TestCase;
use Inventorai\SDK\Http\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;

class ClientTest extends TestCase
{
    protected Client $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = new Client('test-api-token');
    }

    public function test_build_query_returns_empty_array_for_empty_params(): void
    {
        $result = $this->client->buildQuery([]);
        $this->assertEquals([], $result);
    }

    public function test_build_query_handles_filters(): void
    {
        $result = $this->client->buildQuery([
            'filter' => [
                'status' => 'active',
                'property_type' => 'flat',
            ],
        ]);

        $this->assertEquals([
            'filter[status]' => 'active',
            'filter[property_type]' => 'flat',
        ], $result);
    }

    public function test_build_query_handles_include_as_array(): void
    {
        $result = $this->client->buildQuery([
            'include' => ['landlord', 'inspections'],
        ]);

        $this->assertEquals([
            'include' => 'landlord,inspections',
        ], $result);
    }

    public function test_build_query_handles_include_as_string(): void
    {
        $result = $this->client->buildQuery([
            'include' => 'landlord,inspections',
        ]);

        $this->assertEquals([
            'include' => 'landlord,inspections',
        ], $result);
    }

    public function test_build_query_handles_sort(): void
    {
        $result = $this->client->buildQuery([
            'sort' => '-created_at',
        ]);

        $this->assertEquals([
            'sort' => '-created_at',
        ], $result);
    }

    public function test_build_query_handles_pagination(): void
    {
        $result = $this->client->buildQuery([
            'per_page' => 25,
            'page' => 3,
        ]);

        $this->assertEquals([
            'per_page' => 25,
            'page' => 3,
        ], $result);
    }

    public function test_build_query_handles_all_params_together(): void
    {
        $result = $this->client->buildQuery([
            'filter' => ['status' => 'active'],
            'include' => ['landlord'],
            'sort' => '-created_at',
            'per_page' => 50,
            'page' => 2,
        ]);

        $this->assertEquals([
            'filter[status]' => 'active',
            'include' => 'landlord',
            'sort' => '-created_at',
            'per_page' => 50,
            'page' => 2,
        ], $result);
    }

    public function test_build_query_passes_through_unknown_params(): void
    {
        $result = $this->client->buildQuery([
            'unknown_param' => 'value',
        ]);

        $this->assertEquals(['unknown_param' => 'value'], $result);
    }

    public function test_build_query_handles_single_include(): void
    {
        $result = $this->client->buildQuery([
            'include' => ['landlord'],
        ]);

        $this->assertEquals([
            'include' => 'landlord',
        ], $result);
    }

    public function test_build_query_handles_single_filter(): void
    {
        $result = $this->client->buildQuery([
            'filter' => ['search' => 'London'],
        ]);

        $this->assertEquals([
            'filter[search]' => 'London',
        ], $result);
    }

    /**
     * @return array{0: Client, 1: \ArrayObject}
     */
    protected function clientWithHistory(): array
    {
        $history = new \ArrayObject();
        $stack = HandlerStack::create(new MockHandler([new Response(200, [], '{"ok":true}')]));
        $stack->push(Middleware::history($history));

        return [new Client('test-api-token', 'https://api.example.test/v1/team', ['handler' => $stack]), $history];
    }

    public function test_upload_sends_multipart_content_type_with_boundary(): void
    {
        [$client, $history] = $this->clientWithHistory();
        $stream = fopen('php://memory', 'r+');
        fwrite($stream, 'fake-image-bytes');
        rewind($stream);

        $client->upload('/inspections/1/photos', $stream, 'photo', 'photo.jpg');

        $contentType = $history[0]['request']->getHeaderLine('Content-Type');
        $this->assertMatchesRegularExpression('#^multipart/form-data; boundary=.+#', $contentType);
        $this->assertStringNotContainsString('application/json', $contentType);
    }

    public function test_post_sends_json_content_type(): void
    {
        [$client, $history] = $this->clientWithHistory();

        $client->post('/properties', ['address_line_1' => '1 Test Street']);

        $this->assertSame('application/json', $history[0]['request']->getHeaderLine('Content-Type'));
    }
}
