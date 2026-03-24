<?php

namespace Inventorai\SDK\Resources;

use Inventorai\SDK\Http\Client;

class PropertyTemplates
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * List all property templates (blueprints)
     *
     * @param array $params Query parameters
     * @return array
     */
    public function list(array $params = []): array
    {
        $query = $this->client->buildQuery($params);
        return $this->client->get('/property-templates', $query);
    }

    /**
     * Get a specific property template
     *
     * @param int|string $id Template ID
     * @param array $params Query parameters
     * @return array
     */
    public function get($id, array $params = []): array
    {
        $query = $this->client->buildQuery($params);
        return $this->client->get("/property-templates/{$id}", $query);
    }
}
