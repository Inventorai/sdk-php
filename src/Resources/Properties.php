<?php

namespace Inventorai\SDK\Resources;

use Inventorai\SDK\Http\Client;

class Properties
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * List all properties
     *
     * @param array $params Query parameters
     *   - filter: array ['status' => 'active', 'property_type' => 'flat', 'search' => 'London']
     *   - include: array|string ['landlord', 'inspections'] or 'landlord,inspections'
     *   - sort: string '-created_at' or 'address_line_1'
     *   - per_page: int (max 100)
     *   - page: int
     * @return array
     */
    public function list(array $params = []): array
    {
        $query = $this->client->buildQuery($params);
        return $this->client->get('/properties', $query);
    }

    /**
     * Get a specific property
     *
     * @param int|string $id Property ID
     * @param array $params Query parameters
     *   - include: array|string ['landlord', 'inspections']
     * @return array
     */
    public function get($id, array $params = []): array
    {
        $query = $this->client->buildQuery($params);
        return $this->client->get("/properties/{$id}", $query);
    }

    /**
     * Create a new property
     *
     * @param array $data Property data
     * @return array
     */
    public function create(array $data): array
    {
        return $this->client->post('/properties', $data);
    }

    /**
     * Get the active tenancy for a property
     *
     * @param int|string $propertyId Property ID
     * @return array
     */
    public function activeTenancy(int|string $propertyId): array
    {
        return $this->client->get("/properties/{$propertyId}/active-tenancy");
    }

    /**
     * Upload a cover image for a property
     *
     * @param int|string $propertyId Property ID
     * @param string|resource $file File path or stream resource
     * @return array
     */
    public function uploadCoverImage(int|string $propertyId, $file): array
    {
        return $this->client->upload("/properties/{$propertyId}/cover-image", $file, 'cover_image');
    }

    /**
     * Delete the cover image for a property
     *
     * @param int|string $propertyId Property ID
     * @return array
     */
    public function deleteCoverImage(int|string $propertyId): array
    {
        return $this->client->delete("/properties/{$propertyId}/cover-image");
    }
}
