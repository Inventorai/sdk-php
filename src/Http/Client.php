<?php

namespace Inventorai\SDK\Http;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Inventorai\SDK\Exceptions\ApiException;
use Inventorai\SDK\Exceptions\AuthenticationException;
use Inventorai\SDK\Exceptions\RateLimitException;

class Client
{
    protected GuzzleClient $client;
    protected string $baseUrl;
    protected string $apiToken;

    public function __construct(string $apiToken, string $baseUrl = 'https://api.inventorai.co.uk/v1/team')
    {
        $this->apiToken = $apiToken;
        $this->baseUrl = rtrim($baseUrl, '/') . '/';

        $this->client = new GuzzleClient([
            'base_uri' => $this->baseUrl,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiToken,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
            'timeout' => 30,
        ]);
    }

    /**
     * Make a GET request
     */
    public function get(string $endpoint, array $query = []): array
    {
        return $this->request('GET', $endpoint, ['query' => $query]);
    }

    /**
     * Make a POST request
     */
    public function post(string $endpoint, array $data = []): array
    {
        return $this->request('POST', $endpoint, ['json' => $data]);
    }

    /**
     * Make a PUT request
     */
    public function put(string $endpoint, array $data = []): array
    {
        return $this->request('PUT', $endpoint, ['json' => $data]);
    }

    /**
     * Make a PATCH request
     */
    public function patch(string $endpoint, array $data = []): array
    {
        return $this->request('PATCH', $endpoint, ['json' => $data]);
    }

    /**
     * Make a DELETE request
     */
    public function delete(string $endpoint): array
    {
        return $this->request('DELETE', $endpoint);
    }

    /**
     * Upload a file via multipart form data
     *
     * @param string $endpoint API endpoint
     * @param string|resource $file File path or stream resource
     * @param string $fieldName Form field name for the file
     * @param string|null $filename Original filename (used when the file path lacks an extension, e.g. temp files)
     * @return array
     */
    public function upload(string $endpoint, $file, string $fieldName = 'file', ?string $filename = null): array
    {
        $multipart = [
            [
                'name' => $fieldName,
                'contents' => is_string($file) ? fopen($file, 'r') : $file,
                'filename' => $filename ?? (is_string($file) ? basename($file) : 'upload'),
            ],
        ];

        return $this->request('POST', $endpoint, [
            'multipart' => $multipart,
        ]);
    }

    /**
     * Make an HTTP request
     */
    protected function request(string $method, string $endpoint, array $options = []): array
    {
        // Strip leading slash so Guzzle resolves relative to base_uri path
        $endpoint = ltrim($endpoint, '/');

        try {
            $response = $this->client->request($method, $endpoint, $options);
            return json_decode($response->getBody()->getContents(), true);
        } catch (ClientException $e) {
            $this->handleClientException($e);
        } catch (ServerException $e) {
            throw new ApiException(
                'Server error: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        } catch (\Exception $e) {
            throw new ApiException(
                'Request failed: ' . $e->getMessage(),
                0,
                $e
            );
        }
    }

    /**
     * Handle client exceptions (4xx errors)
     */
    protected function handleClientException(ClientException $e): void
    {
        $statusCode = $e->getResponse()->getStatusCode();
        $body = json_decode($e->getResponse()->getBody()->getContents(), true);
        $message = $body['message'] ?? $e->getMessage();

        switch ($statusCode) {
            case 401:
                throw new AuthenticationException($message, $statusCode, $e);
            case 429:
                throw new RateLimitException($message, $statusCode, $e);
            default:
                throw new ApiException($message, $statusCode, $e);
        }
    }

    /**
     * Build query string with filters, includes, sorting
     */
    public function buildQuery(array $params): array
    {
        $query = [];

        // Handle filters
        if (isset($params['filter'])) {
            foreach ($params['filter'] as $key => $value) {
                $query["filter[{$key}]"] = $value;
            }
        }

        // Handle includes
        if (isset($params['include'])) {
            $query['include'] = is_array($params['include'])
                ? implode(',', $params['include'])
                : $params['include'];
        }

        // Handle sorting
        if (isset($params['sort'])) {
            $query['sort'] = $params['sort'];
        }

        // Handle pagination
        if (isset($params['per_page'])) {
            $query['per_page'] = $params['per_page'];
        }
        if (isset($params['page'])) {
            $query['page'] = $params['page'];
        }

        // Pass through any additional params not handled above
        $handled = ['filter', 'include', 'sort', 'per_page', 'page'];
        foreach ($params as $key => $value) {
            if (!in_array($key, $handled)) {
                $query[$key] = $value;
            }
        }

        return $query;
    }
}
