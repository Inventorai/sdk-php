<?php

namespace Inventorai\SDK\Resources;

use Inventorai\SDK\Http\Client;

class Hmo
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Get HMO summary for an inspection — areas grouped by tenant + shared/unassigned.
     *
     * @param int|string $inspectionId Inspection ID
     * @return array
     */
    public function summary(int|string $inspectionId): array
    {
        return $this->client->get("/inspections/{$inspectionId}/hmo/summary");
    }

    /**
     * Get tenants available for this inspection's property.
     *
     * @param int|string $inspectionId Inspection ID
     * @return array
     */
    public function tenants(int|string $inspectionId): array
    {
        return $this->client->get("/inspections/{$inspectionId}/hmo/tenants");
    }

    /**
     * Assign tenant(s) to an inspection area (room).
     *
     * @param int|string $inspectionId Inspection ID
     * @param string $areaId Area ID
     * @param array{tenant_ids?: array<string>, is_shared?: bool, room_identifier?: ?string} $data
     * @return array
     */
    public function assignTenantToArea(int|string $inspectionId, string $areaId, array $data): array
    {
        return $this->client->put("/inspections/{$inspectionId}/hmo/areas/{$areaId}/assign", $data);
    }

    /**
     * Bulk assign tenants across multiple areas.
     *
     * @param int|string $inspectionId Inspection ID
     * @param array{assignments: array<array{area_id: string, tenant_ids?: array<string>, is_shared?: bool, room_identifier?: ?string}>} $data
     * @return array
     */
    public function bulkAssignTenants(int|string $inspectionId, array $data): array
    {
        return $this->client->post("/inspections/{$inspectionId}/hmo/bulk-assign", $data);
    }
}
