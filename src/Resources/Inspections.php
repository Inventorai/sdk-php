<?php

namespace Inventorai\SDK\Resources;

use Inventorai\SDK\Http\Client;

class Inspections
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * List all inspections
     *
     * @param array $params Query parameters (filter, include, sort, per_page, page)
     * @return array
     */
    public function list(array $params = []): array
    {
        $query = $this->client->buildQuery($params);
        return $this->client->get('/inspections', $query);
    }

    /**
     * Get a specific inspection
     *
     * @param int|string $id Inspection ID
     * @param array $params Query parameters (include)
     * @return array
     */
    public function get($id, array $params = []): array
    {
        $query = $this->client->buildQuery($params);
        return $this->client->get("/inspections/{$id}", $query);
    }

    /**
     * Create a new inspection.
     *
     * Accepts an optional client-built ULID (`id`) for offline-first sync
     * idempotency, plus a nested `areas[]` tree containing `items[]` and
     * `elements[]` so the entire structure can be created in a single call.
     *
     * @param array $data Inspection data — common keys: property_id, type,
     *                    scheduled_at, scheduled_end_at, id (ULID),
     *                    areas[] => [{id?, name, items[] => [{id?, name,
     *                    elements[] => [{id?, name}]}]}]
     * @return array
     */
    public function create(array $data): array
    {
        return $this->client->post('/inspections', $data);
    }

    /**
     * Initialize an inspection from a property template (async expansion).
     *
     * @param array $data Initialization payload (property_id, template_id, type, scheduled_at, etc.)
     * @return array
     */
    public function initialize(array $data): array
    {
        return $this->client->post('/inspections/initialize', $data);
    }

    /**
     * Check for existing inspections
     *
     * @param array $params Query parameters
     * @return array
     */
    public function checkExisting(array $params = []): array
    {
        return $this->client->get('/inspections/check-existing', $params);
    }

    /**
     * Get comparable inspections
     *
     * @param array $params Query parameters
     * @return array
     */
    public function comparable(array $params = []): array
    {
        return $this->client->get('/inspections/comparable', $params);
    }

    /**
     * Begin an inspection
     *
     * @param int|string $inspectionId Inspection ID
     * @return array
     */
    public function begin(int|string $inspectionId): array
    {
        return $this->client->post("/inspections/{$inspectionId}/begin");
    }

    /**
     * Finalize an inspection
     *
     * @param int|string $inspectionId Inspection ID
     * @param array $data Optional finalization data
     * @return array
     */
    public function finalize(int|string $inspectionId, array $data = []): array
    {
        return $this->client->post("/inspections/{$inspectionId}/finalize", $data);
    }

    /**
     * Reschedule an inspection
     *
     * @param int|string $inspectionId Inspection ID
     * @param array $data Reschedule data
     * @return array
     */
    public function reschedule(int|string $inspectionId, array $data): array
    {
        return $this->client->patch("/inspections/{$inspectionId}/reschedule", $data);
    }

    /**
     * Take over an inspection currently locked by another inspector.
     *
     * @param int|string $inspectionId Inspection ID
     * @return array
     */
    public function takeOver(int|string $inspectionId): array
    {
        return $this->client->post("/inspections/{$inspectionId}/take-over");
    }

    /**
     * Hand the inspection back to the web UI from a mobile takeover state.
     *
     * @param int|string $inspectionId Inspection ID
     * @return array
     */
    public function takeBackToWeb(int|string $inspectionId): array
    {
        return $this->client->post("/inspections/{$inspectionId}/take-back-to-web");
    }

    /**
     * Upload a cover image for an inspection
     *
     * @param int|string $inspectionId Inspection ID
     * @param string|resource $file File path or stream resource
     * @return array
     */
    public function uploadCoverImage(int|string $inspectionId, $file): array
    {
        return $this->client->upload("/inspections/{$inspectionId}/cover-image", $file, 'cover_image');
    }

    /**
     * Delete the cover image for an inspection
     *
     * @param int|string $inspectionId Inspection ID
     * @return array
     */
    public function deleteCoverImage(int|string $inspectionId): array
    {
        return $this->client->delete("/inspections/{$inspectionId}/cover-image");
    }
}
