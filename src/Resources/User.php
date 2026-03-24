<?php

namespace Inventorai\SDK\Resources;

use Inventorai\SDK\Http\Client;

class User
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Get the authenticated user's profile
     *
     * @return array
     */
    public function me(): array
    {
        return $this->client->get('/user');
    }
}
