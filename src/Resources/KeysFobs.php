<?php

namespace Inventorai\SDK\Resources;

use Inventorai\SDK\Http\Client;

class KeysFobs
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * List all keys/fobs for an inspection
     *
     * @param int|string $inspectionId Inspection ID
     * @param array $params Query parameters
     * @return array
     */
    public function list(int|string $inspectionId, array $params = []): array
    {
        return $this->client->get("/inspections/{$inspectionId}/keys-fobs", $params);
    }

    /**
     * Get a specific key/fob
     *
     * @param int|string $inspectionId Inspection ID
     * @param string $keyFobId Key/Fob ID
     * @return array
     */
    public function get(int|string $inspectionId, string $keyFobId): array
    {
        return $this->client->get("/inspections/{$inspectionId}/keys-fobs/{$keyFobId}");
    }

    /**
     * Create a new key/fob
     *
     * @param int|string $inspectionId Inspection ID
     * @param array $data Key/fob data
     * @return array
     */
    public function create(int|string $inspectionId, array $data): array
    {
        return $this->client->post("/inspections/{$inspectionId}/keys-fobs", $data);
    }

    /**
     * Update a key/fob
     *
     * @param int|string $inspectionId Inspection ID
     * @param string $keyFobId Key/Fob ID
     * @param array $data Key/fob data
     * @return array
     */
    public function update(int|string $inspectionId, string $keyFobId, array $data): array
    {
        return $this->client->patch("/inspections/{$inspectionId}/keys-fobs/{$keyFobId}", $data);
    }

    /**
     * Delete a key/fob
     *
     * @param int|string $inspectionId Inspection ID
     * @param string $keyFobId Key/Fob ID
     * @return array
     */
    public function delete(int|string $inspectionId, string $keyFobId): array
    {
        return $this->client->delete("/inspections/{$inspectionId}/keys-fobs/{$keyFobId}");
    }

    /**
     * Upload a photo for a key/fob
     *
     * @param int|string $inspectionId Inspection ID
     * @param string $keyFobId Key/Fob ID
     * @param string|resource $file File path or stream resource
     * @return array
     */
    public function uploadPhoto(int|string $inspectionId, string $keyFobId, $file, ?string $filename = null): array
    {
        return $this->client->upload("/inspections/{$inspectionId}/keys-fobs/{$keyFobId}/photos", $file, 'photo', $filename);
    }

    /**
     * Delete a photo from a key/fob
     *
     * @param int|string $inspectionId Inspection ID
     * @param string $keyFobId Key/Fob ID
     * @param string $photoId Photo ID
     * @return array
     */
    public function deletePhoto(int|string $inspectionId, string $keyFobId, string $photoId): array
    {
        return $this->client->delete("/inspections/{$inspectionId}/keys-fobs/{$keyFobId}/photos/{$photoId}");
    }
}
