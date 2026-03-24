<?php

namespace Inventorai\SDK\Resources;

use Inventorai\SDK\Http\Client;

class InspectionItems
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * List all items for an inspection
     *
     * @param int|string $inspectionId Inspection ID
     * @param array $params Query parameters
     * @return array
     */
    public function list(int|string $inspectionId, array $params = []): array
    {
        return $this->client->get("/inspections/{$inspectionId}/items", $params);
    }

    /**
     * Get a specific item
     *
     * @param int|string $inspectionId Inspection ID
     * @param string $itemId Item ID
     * @param array $params Query parameters
     * @return array
     */
    public function get(int|string $inspectionId, string $itemId, array $params = []): array
    {
        return $this->client->get("/inspections/{$inspectionId}/items/{$itemId}", $params);
    }

    /**
     * Create a new item
     *
     * @param int|string $inspectionId Inspection ID
     * @param array $data Item data
     * @return array
     */
    public function create(int|string $inspectionId, array $data): array
    {
        return $this->client->post("/inspections/{$inspectionId}/items", $data);
    }

    /**
     * Update an item
     *
     * @param int|string $inspectionId Inspection ID
     * @param string $itemId Item ID
     * @param array $data Item data
     * @return array
     */
    public function update(int|string $inspectionId, string $itemId, array $data): array
    {
        return $this->client->patch("/inspections/{$inspectionId}/items/{$itemId}", $data);
    }

    /**
     * Delete an item
     *
     * @param int|string $inspectionId Inspection ID
     * @param string $itemId Item ID
     * @return array
     */
    public function delete(int|string $inspectionId, string $itemId): array
    {
        return $this->client->delete("/inspections/{$inspectionId}/items/{$itemId}");
    }

    /**
     * Duplicate an item
     *
     * @param int|string $inspectionId Inspection ID
     * @param string $itemId Item ID
     * @return array
     */
    public function duplicate(int|string $inspectionId, string $itemId): array
    {
        return $this->client->post("/inspections/{$inspectionId}/items/{$itemId}/duplicate");
    }

    /**
     * Upload a photo for an item
     *
     * @param int|string $inspectionId Inspection ID
     * @param string $itemId Item ID
     * @param string|resource $file File path or stream resource
     * @return array
     */
    public function uploadPhoto(int|string $inspectionId, string $itemId, $file, ?string $filename = null): array
    {
        return $this->client->upload("/inspections/{$inspectionId}/items/{$itemId}/photos", $file, 'photo', $filename);
    }

    /**
     * Delete a photo from an item
     *
     * @param int|string $inspectionId Inspection ID
     * @param string $itemId Item ID
     * @param string $photoId Photo ID
     * @return array
     */
    public function deletePhoto(int|string $inspectionId, string $itemId, string $photoId): array
    {
        return $this->client->delete("/inspections/{$inspectionId}/items/{$itemId}/photos/{$photoId}");
    }
}
