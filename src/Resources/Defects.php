<?php

namespace Inventorai\SDK\Resources;

use Inventorai\SDK\Http\Client;

class Defects
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * List all defects for an inspection
     *
     * @param int|string $inspectionId Inspection ID
     * @param array $params Query parameters
     * @return array
     */
    public function list(int|string $inspectionId, array $params = []): array
    {
        return $this->client->get("/inspections/{$inspectionId}/defects", $params);
    }

    /**
     * Get a specific defect
     *
     * @param int|string $inspectionId Inspection ID
     * @param string $defectId Defect ID
     * @return array
     */
    public function get(int|string $inspectionId, string $defectId): array
    {
        return $this->client->get("/inspections/{$inspectionId}/defects/{$defectId}");
    }

    /**
     * Create a new defect for an inspection
     *
     * @param int|string $inspectionId Inspection ID
     * @param array{title?: string, description?: string, severity?: ?string, item_label?: ?string, location_notes?: string, category?: string, photo_ids?: array<string>} $data Defect data
     * @return array
     */
    public function create(int|string $inspectionId, array $data): array
    {
        return $this->client->post("/inspections/{$inspectionId}/defects", $data);
    }

    /**
     * Create a defect for a specific area
     *
     * @param int|string $inspectionId Inspection ID
     * @param string $areaId Area ID
     * @param array{title?: string, description?: string, severity?: ?string, item_label?: ?string, location_notes?: string, category?: string, photo_ids?: array<string>} $data Defect data
     * @return array
     */
    public function createForArea(int|string $inspectionId, string $areaId, array $data): array
    {
        return $this->client->post("/inspections/{$inspectionId}/areas/{$areaId}/defects", $data);
    }

    /**
     * Create a defect for a specific item
     *
     * @param int|string $inspectionId Inspection ID
     * @param string $itemId Item ID
     * @param array{title?: string, description?: string, severity?: ?string, item_label?: ?string, location_notes?: string, category?: string, photo_ids?: array<string>} $data Defect data
     * @return array
     */
    public function createForItem(int|string $inspectionId, string $itemId, array $data): array
    {
        return $this->client->post("/inspections/{$inspectionId}/items/{$itemId}/defects", $data);
    }

    /**
     * Create a defect for a specific element
     *
     * @param int|string $inspectionId Inspection ID
     * @param string $elementId Element ID
     * @param array{title?: string, description?: string, severity?: ?string, item_label?: ?string, location_notes?: string, category?: string, photo_ids?: array<string>} $data Defect data
     * @return array
     */
    public function createForElement(int|string $inspectionId, string $elementId, array $data): array
    {
        return $this->client->post("/inspections/{$inspectionId}/elements/{$elementId}/defects", $data);
    }

    /**
     * Update a defect
     *
     * @param int|string $inspectionId Inspection ID
     * @param string $defectId Defect ID
     * @param array{title?: string, description?: string, severity?: ?string, item_label?: ?string, location_notes?: string, category?: string, photo_ids?: array<string>} $data Defect data
     * @return array
     */
    public function update(int|string $inspectionId, string $defectId, array $data): array
    {
        return $this->client->patch("/inspections/{$inspectionId}/defects/{$defectId}", $data);
    }

    /**
     * Delete a defect
     *
     * @param int|string $inspectionId Inspection ID
     * @param string $defectId Defect ID
     * @return array
     */
    public function delete(int|string $inspectionId, string $defectId): array
    {
        return $this->client->delete("/inspections/{$inspectionId}/defects/{$defectId}");
    }

    /**
     * Upload a photo for a defect
     *
     * @param int|string $inspectionId Inspection ID
     * @param string $defectId Defect ID
     * @param string|resource $file File path or stream resource
     * @return array
     */
    public function uploadPhoto(int|string $inspectionId, string $defectId, $file, ?string $filename = null): array
    {
        return $this->client->upload("/inspections/{$inspectionId}/defects/{$defectId}/photos", $file, 'photo', $filename);
    }

    /**
     * Delete a photo from a defect
     *
     * @param int|string $inspectionId Inspection ID
     * @param string $defectId Defect ID
     * @param string $photoId Photo ID
     * @return array
     */
    public function deletePhoto(int|string $inspectionId, string $defectId, string $photoId): array
    {
        return $this->client->delete("/inspections/{$inspectionId}/defects/{$defectId}/photos/{$photoId}");
    }
}
