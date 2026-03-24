<?php

namespace Inventorai\SDK\Resources;

use Inventorai\SDK\Http\Client;

class InspectionAi
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Enable AI for an inspection
     *
     * @param int|string $inspectionId Inspection ID
     * @return array
     */
    public function enable(int|string $inspectionId): array
    {
        return $this->client->post("/inspections/{$inspectionId}/ai/enable");
    }

    /**
     * Disable AI for an inspection
     *
     * @param int|string $inspectionId Inspection ID
     * @return array
     */
    public function disable(int|string $inspectionId): array
    {
        return $this->client->post("/inspections/{$inspectionId}/ai/disable");
    }

    /**
     * Get AI status for an inspection
     *
     * @param int|string $inspectionId Inspection ID
     * @return array
     */
    public function status(int|string $inspectionId): array
    {
        return $this->client->get("/inspections/{$inspectionId}/ai/status");
    }

    /**
     * Retry AI credits for an inspection
     *
     * @param int|string $inspectionId Inspection ID
     * @return array
     */
    public function retryCredits(int|string $inspectionId): array
    {
        return $this->client->post("/inspections/{$inspectionId}/ai/retry-credits");
    }

    /**
     * Request an AI retry for an inspection
     *
     * @param int|string $inspectionId Inspection ID
     * @return array
     */
    public function requestRetry(int|string $inspectionId): array
    {
        return $this->client->post("/inspections/{$inspectionId}/ai/request-retry");
    }

    /**
     * Get AI retry status for an inspection
     *
     * @param int|string $inspectionId Inspection ID
     * @return array
     */
    public function retryStatus(int|string $inspectionId): array
    {
        return $this->client->get("/inspections/{$inspectionId}/ai/retry-status");
    }

    /**
     * Submit AI feedback for an inspection
     *
     * @param int|string $inspectionId Inspection ID
     * @param array $data Feedback data
     * @return array
     */
    public function submitFeedback(int|string $inspectionId, array $data): array
    {
        return $this->client->post("/inspections/{$inspectionId}/ai/feedback", $data);
    }
}
