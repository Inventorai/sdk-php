<?php

namespace Inventorai\SDK\Resources;

use Inventorai\SDK\Http\Client;

class ComplianceForms
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * List all available compliance forms
     *
     * @param array $params Query parameters
     * @return array
     */
    public function list(array $params = []): array
    {
        return $this->client->get('/compliance-forms', $params);
    }
}
