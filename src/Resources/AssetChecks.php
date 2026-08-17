<?php

namespace Inventorai\SDK\Resources;

use Inventorai\SDK\Http\Client;

class AssetChecks
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Update an alarm / safety equipment check on an inspection
     *
     * @param int|string $inspectionId Inspection ID
     * @param int|string $assetCheckId Asset check ID
     * @param array $data tested (yes|no|not_accessible), test_result (pass|fail|na),
     *                    condition (good|fair|poor|replace), notes
     * @return array
     */
    public function update(int|string $inspectionId, int|string $assetCheckId, array $data): array
    {
        return $this->client->put("/inspections/{$inspectionId}/asset-checks/{$assetCheckId}", $data);
    }

    /**
     * Upload a photo against an asset check
     *
     * @param int|string $inspectionId Inspection ID
     * @param int|string $assetCheckId Asset check ID
     * @param string|resource $file File path or stream resource
     * @return array
     */
    public function uploadPhoto(int|string $inspectionId, int|string $assetCheckId, $file): array
    {
        return $this->client->upload("/inspections/{$inspectionId}/asset-checks/{$assetCheckId}/photos", $file, 'photo');
    }
}
