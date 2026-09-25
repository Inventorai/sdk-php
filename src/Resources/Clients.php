<?php

namespace Inventorai\SDK\Resources;

use Inventorai\SDK\Http\Client;

class Clients
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * List clients. Required scope: `clients:read`.
     *
     * @param array $params Query parameters
     *   - scope: string 'mine' or 'all'
     *   - filter: array ['search' => 'Acme', 'kind' => 'agency', 'group_id' => '...', 'is_active' => true, 'branch_id' => '...']
     *   - include: array|string ['group', 'defaultBranch', 'branches']
     *   - sort: string 'name', 'created_at' or 'inspections_count' (prefix with - for desc)
     *   - per_page: int (max 100)
     *   - page: int
     * @return array
     */
    public function list(array $params = []): array
    {
        $query = $this->client->buildQuery($params);
        return $this->client->get('/clients', $query);
    }

    /**
     * Get a specific client. Required scope: `clients:read`.
     *
     * @param int|string $id Client ID
     * @param array $params Query parameters
     * @return array
     */
    public function get(int|string $id, array $params = []): array
    {
        $query = $this->client->buildQuery($params);
        return $this->client->get("/clients/{$id}", $query);
    }

    /**
     * List client groups. Required scope: `clients:read`.
     *
     * @param array $params Query parameters
     *   - filter: array ['search' => 'North', 'type' => 'agency'|'segment']
     *   - include: array|string ['clients']
     *   - sort: string 'name', 'created_at' or 'clients_count' (prefix with - for desc)
     *   - per_page: int (max 100)
     *   - page: int
     * @return array
     */
    public function groups(array $params = []): array
    {
        $query = $this->client->buildQuery($params);
        return $this->client->get('/clients/groups', $query);
    }

    /**
     * Get a specific client group. Required scope: `clients:read`.
     *
     * @param int|string $id Client group ID
     * @param array $params Query parameters
     * @return array
     */
    public function group(int|string $id, array $params = []): array
    {
        $query = $this->client->buildQuery($params);
        return $this->client->get("/clients/groups/{$id}", $query);
    }
}
