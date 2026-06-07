<?php

namespace Inventorai\SDK\Resources;

use Inventorai\SDK\Http\Client;

class Team
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Get the team behind the current API token.
     *
     * Returns the team's id, name, slug, address, branding, subscription
     * state, inspection hours, and option presets. Call this on startup to
     * resolve the team_id for the `private-team.{id}` socket channel and
     * to surface branding to your users.
     *
     * @return array<string, mixed>
     */
    public function current(): array
    {
        return $this->client->get('');
    }
}
