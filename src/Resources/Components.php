<?php

namespace Inventorai\SDK\Resources;

use Inventorai\SDK\Http\Client;

class Components
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * List all components in the library
     *
     * @param array $params Query parameters
     * @return array
     */
    public function list(array $params = []): array
    {
        $query = $this->client->buildQuery($params);
        return $this->client->get('/components', $query);
    }
}
