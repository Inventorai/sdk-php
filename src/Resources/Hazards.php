<?php

namespace Inventorai\SDK\Resources;

use Inventorai\SDK\Http\Client;

class Hazards
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Sync the statutory hazard wordings and per-nation duties, for offline hazard detection. Required scope: `phrases:read`.
     *
     * @return array
     */
    public function sync(): array
    {
        return $this->client->get('/hazards/sync');
    }
}
