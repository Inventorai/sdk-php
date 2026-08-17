<?php

namespace Inventorai\SDK\Resources;

use Inventorai\SDK\Http\Client;

class Compliance
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * List compliance forms for an inspection
     *
     * @param int|string $inspectionId Inspection ID
     * @return array
     */
    public function list(int|string $inspectionId): array
    {
        return $this->client->get("/inspections/{$inspectionId}/compliance");
    }

    /**
     * Attach a compliance form to an inspection
     *
     * @param int|string $inspectionId Inspection ID
     * @param int|string $formId Form ID
     * @return array
     */
    public function attach(int|string $inspectionId, int|string $formId): array
    {
        return $this->client->post("/inspections/{$inspectionId}/compliance/attach", ['form_id' => $formId]);
    }

    /**
     * Attach multiple compliance forms to an inspection
     *
     * @param int|string $inspectionId Inspection ID
     * @param array $formIds Array of form IDs
     * @return array
     */
    public function attachMultiple(int|string $inspectionId, array $formIds): array
    {
        return $this->client->post("/inspections/{$inspectionId}/compliance/attach-multiple", ['form_ids' => $formIds]);
    }

    /**
     * Update a compliance response field
     *
     * @param int|string $inspectionId Inspection ID
     * @param int|string $fieldId Field ID
     * @param array $data Response data
     * @return array
     */
    public function updateResponse(int|string $inspectionId, int|string $fieldId, array $data): array
    {
        return $this->client->patch("/inspections/{$inspectionId}/compliance/fields/{$fieldId}", $data);
    }

    /**
     * Batch update multiple compliance response fields
     *
     * @param int|string $inspectionId Inspection ID
     * @param array $fields Array of field updates
     * @return array
     */
    public function batchUpdateResponses(int|string $inspectionId, array $fields): array
    {
        return $this->client->post("/inspections/{$inspectionId}/compliance/batch", ['fields' => $fields]);
    }

    /**
     * Upload a file for compliance
     *
     * @param int|string $inspectionId Inspection ID
     * @param string|resource $file File path or stream resource
     * @return array
     */
    public function uploadFile(int|string $inspectionId, $file): array
    {
        return $this->client->upload("/inspections/{$inspectionId}/compliance/upload", $file, 'file');
    }

    /**
     * Add a repeatable section instance
     *
     * @param int|string $inspectionId Inspection ID
     * @param array $data Section instance data
     * @return array
     */
    public function addSectionInstance(int|string $inspectionId, array $data): array
    {
        return $this->client->post("/inspections/{$inspectionId}/compliance/section-instance", $data);
    }

    /**
     * Remove a repeatable section instance
     *
     * @param int|string $inspectionId Inspection ID
     * @param int|string $instanceId Section instance ID
     * @return array
     */
    public function removeSectionInstance(int|string $inspectionId, int|string $instanceId): array
    {
        return $this->client->delete("/inspections/{$inspectionId}/compliance/section-instance/{$instanceId}");
    }

    /**
     * Get compliance summary for an inspection
     *
     * @param int|string $inspectionId Inspection ID
     * @return array
     */
    public function summary(int|string $inspectionId): array
    {
        return $this->client->get("/inspections/{$inspectionId}/compliance/summary");
    }

    /**
     * Update a compliance form on an inspection
     *
     * @param int|string $inspectionId Inspection ID
     * @param int|string $formId Form ID
     * @param array $data Form data
     * @return array
     */
    public function update(int|string $inspectionId, int|string $formId, array $data): array
    {
        return $this->client->patch("/inspections/{$inspectionId}/compliance-forms/{$formId}", $data);
    }

    /**
     * Detach a compliance form from an inspection
     *
     * @param int|string $inspectionId Inspection ID
     * @param int|string $formId Form ID
     * @return array
     */
    public function detach(int|string $inspectionId, int|string $formId): array
    {
        return $this->client->delete("/inspections/{$inspectionId}/compliance-forms/{$formId}");
    }
}
