<?php

namespace Inventorai\SDK\Resources;

use Inventorai\SDK\Http\Client;

class InspectionAreas
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * List all areas for an inspection
     *
     * @param int|string $inspectionId Inspection ID
     * @param array $params Query parameters
     * @return array
     */
    public function list(int|string $inspectionId, array $params = []): array
    {
        return $this->client->get("/inspections/{$inspectionId}/areas", $params);
    }

    /**
     * Get a specific area
     *
     * @param int|string $inspectionId Inspection ID
     * @param string $areaId Area ID
     * @param array $params Query parameters
     * @return array
     */
    public function get(int|string $inspectionId, string $areaId, array $params = []): array
    {
        return $this->client->get("/inspections/{$inspectionId}/areas/{$areaId}", $params);
    }

    /**
     * Create a new area
     *
     * @param int|string $inspectionId Inspection ID
     * @param array $data Area data
     * @return array
     */
    public function create(int|string $inspectionId, array $data): array
    {
        return $this->client->post("/inspections/{$inspectionId}/areas", $data);
    }

    /**
     * Update an area
     *
     * @param int|string $inspectionId Inspection ID
     * @param string $areaId Area ID
     * @param array $data Area data
     * @return array
     */
    public function update(int|string $inspectionId, string $areaId, array $data): array
    {
        return $this->client->patch("/inspections/{$inspectionId}/areas/{$areaId}", $data);
    }

    /**
     * Delete an area
     *
     * @param int|string $inspectionId Inspection ID
     * @param string $areaId Area ID
     * @return array
     */
    public function delete(int|string $inspectionId, string $areaId): array
    {
        return $this->client->delete("/inspections/{$inspectionId}/areas/{$areaId}");
    }

    /**
     * Duplicate an area
     *
     * @param int|string $inspectionId Inspection ID
     * @param string $areaId Area ID
     * @return array
     */
    public function duplicate(int|string $inspectionId, string $areaId): array
    {
        return $this->client->post("/inspections/{$inspectionId}/areas/{$areaId}/duplicate");
    }

    /**
     * Reorder areas
     *
     * @param int|string $inspectionId Inspection ID
     * @param array $order Array of area IDs in desired order
     * @return array
     */
    public function reorder(int|string $inspectionId, array $order): array
    {
        return $this->client->post("/inspections/{$inspectionId}/areas/reorder", ['order' => $order]);
    }

    /**
     * Upload a photo for an area
     *
     * @param int|string $inspectionId Inspection ID
     * @param string $areaId Area ID
     * @param string|resource $file File path or stream resource
     * @return array
     */
    public function uploadPhoto(int|string $inspectionId, string $areaId, $file, ?string $filename = null): array
    {
        return $this->client->upload("/inspections/{$inspectionId}/areas/{$areaId}/photos", $file, 'photo', $filename);
    }

    /**
     * Delete a photo from an area
     *
     * @param int|string $inspectionId Inspection ID
     * @param string $areaId Area ID
     * @param string $photoId Photo ID
     * @return array
     */
    public function deletePhoto(int|string $inspectionId, string $areaId, string $photoId): array
    {
        return $this->client->delete("/inspections/{$inspectionId}/areas/{$areaId}/photos/{$photoId}");
    }
}
