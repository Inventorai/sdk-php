<?php

namespace Inventorai\SDK\Resources;

use Inventorai\SDK\Http\Client;

class MeterReadings
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * List all meter readings for an inspection
     *
     * @param int|string $inspectionId Inspection ID
     * @param array $params Query parameters
     * @return array
     */
    public function list(int|string $inspectionId, array $params = []): array
    {
        return $this->client->get("/inspections/{$inspectionId}/meter-readings", $params);
    }

    /**
     * Get a specific meter reading
     *
     * @param int|string $inspectionId Inspection ID
     * @param string $meterReadingId Meter Reading ID
     * @return array
     */
    public function get(int|string $inspectionId, string $meterReadingId): array
    {
        return $this->client->get("/inspections/{$inspectionId}/meter-readings/{$meterReadingId}");
    }

    /**
     * Create a new meter reading
     *
     * @param int|string $inspectionId Inspection ID
     * @param array $data Meter reading data
     * @return array
     */
    public function create(int|string $inspectionId, array $data): array
    {
        return $this->client->post("/inspections/{$inspectionId}/meter-readings", $data);
    }

    /**
     * Update a meter reading
     *
     * @param int|string $inspectionId Inspection ID
     * @param string $meterReadingId Meter Reading ID
     * @param array $data Meter reading data
     * @return array
     */
    public function update(int|string $inspectionId, string $meterReadingId, array $data): array
    {
        return $this->client->patch("/inspections/{$inspectionId}/meter-readings/{$meterReadingId}", $data);
    }

    /**
     * Delete a meter reading
     *
     * @param int|string $inspectionId Inspection ID
     * @param string $meterReadingId Meter Reading ID
     * @return array
     */
    public function delete(int|string $inspectionId, string $meterReadingId): array
    {
        return $this->client->delete("/inspections/{$inspectionId}/meter-readings/{$meterReadingId}");
    }

    /**
     * Upload a photo for a meter reading
     *
     * @param int|string $inspectionId Inspection ID
     * @param string $meterReadingId Meter Reading ID
     * @param string|resource $file File path or stream resource
     * @return array
     */
    public function uploadPhoto(int|string $inspectionId, string $meterReadingId, $file, ?string $filename = null): array
    {
        return $this->client->upload("/inspections/{$inspectionId}/meter-readings/{$meterReadingId}/photos", $file, 'photo', $filename);
    }

    /**
     * Delete a photo from a meter reading
     *
     * @param int|string $inspectionId Inspection ID
     * @param string $meterReadingId Meter Reading ID
     * @param string $photoId Photo ID
     * @return array
     */
    public function deletePhoto(int|string $inspectionId, string $meterReadingId, string $photoId): array
    {
        return $this->client->delete("/inspections/{$inspectionId}/meter-readings/{$meterReadingId}/photos/{$photoId}");
    }
}
