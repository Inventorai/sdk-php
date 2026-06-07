<?php

namespace Inventorai\SDK\Resources;

use Inventorai\SDK\Http\Client;

class Branches
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * List all branches for the team. Required scope: `branches:read`.
     *
     * @param array $params Query parameters
     * @return array
     */
    public function list(array $params = []): array
    {
        $query = $this->client->buildQuery($params);
        return $this->client->get('/branches', $query);
    }

    /**
     * Get a specific branch. Required scope: `branches:read`.
     *
     * @param int|string $id Branch ID
     * @param array $params Query parameters
     * @return array
     */
    public function get(int|string $id, array $params = []): array
    {
        $query = $this->client->buildQuery($params);
        return $this->client->get("/branches/{$id}", $query);
    }
}
