<?php

namespace Inventorai\SDK\Resources;

use Inventorai\SDK\Http\Client;

class Vocabulary
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Sync the wording vocabulary behind phrase suggestions, for offline defect detection. Required scope: `phrases:read`.
     *
     * @return array
     */
    public function sync(): array
    {
        return $this->client->get('/vocabulary/sync');
    }
}
