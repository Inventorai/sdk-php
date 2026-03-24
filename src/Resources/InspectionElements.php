<?php

namespace Inventorai\SDK\Resources;

use Inventorai\SDK\Http\Client;

class InspectionElements
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * List all elements for an inspection
     *
     * @param int|string $inspectionId Inspection ID
     * @param array $params Query parameters
     * @return array
     */
    public function list(int|string $inspectionId, array $params = []): array
    {
        return $this->client->get("/inspections/{$inspectionId}/elements", $params);
    }

    /**
     * Get a specific element
     *
     * @param int|string $inspectionId Inspection ID
     * @param string $elementId Element ID
     * @param array $params Query parameters
     * @return array
     */
    public function get(int|string $inspectionId, string $elementId, array $params = []): array
    {
        return $this->client->get("/inspections/{$inspectionId}/elements/{$elementId}", $params);
    }

    /**
     * Create a new element
     *
     * @param int|string $inspectionId Inspection ID
     * @param array $data Element data
     * @return array
     */
    public function create(int|string $inspectionId, array $data): array
    {
        return $this->client->post("/inspections/{$inspectionId}/elements", $data);
    }

    /**
     * Update an element
     *
     * @param int|string $inspectionId Inspection ID
     * @param string $elementId Element ID
     * @param array $data Element data
     * @return array
     */
    public function update(int|string $inspectionId, string $elementId, array $data): array
    {
        return $this->client->patch("/inspections/{$inspectionId}/elements/{$elementId}", $data);
    }

    /**
     * Delete an element
     *
     * @param int|string $inspectionId Inspection ID
     * @param string $elementId Element ID
     * @return array
     */
    public function delete(int|string $inspectionId, string $elementId): array
    {
        return $this->client->delete("/inspections/{$inspectionId}/elements/{$elementId}");
    }

    /**
     * Upload a photo for an element
     *
     * @param int|string $inspectionId Inspection ID
     * @param string $elementId Element ID
     * @param string|resource $file File path or stream resource
     * @return array
     */
    public function uploadPhoto(int|string $inspectionId, string $elementId, $file, ?string $filename = null): array
    {
        return $this->client->upload("/inspections/{$inspectionId}/elements/{$elementId}/photos", $file, 'photo', $filename);
    }

    /**
     * Delete a photo from an element
     *
     * @param int|string $inspectionId Inspection ID
     * @param string $elementId Element ID
     * @param string $photoId Photo ID
     * @return array
     */
    public function deletePhoto(int|string $inspectionId, string $elementId, string $photoId): array
    {
        return $this->client->delete("/inspections/{$inspectionId}/elements/{$elementId}/photos/{$photoId}");
    }
}
