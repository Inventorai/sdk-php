<?php

namespace Inventorai\SDK\Resources;

use Inventorai\SDK\Http\Client;

class Stats
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Get overall statistics
     *
     * @return array
     */
    public function index(): array
    {
        return $this->client->get('/stats');
    }

    /**
     * Get team statistics
     *
     * @return array
     */
    public function team(): array
    {
        return $this->client->get('/stats/team');
    }

    /**
     * Get user statistics
     *
     * @return array
     */
    public function user(): array
    {
        return $this->client->get('/stats/user');
    }

    /**
     * Get dashboard schedule
     *
     * @return array
     */
    public function schedule(): array
    {
        return $this->client->get('/dashboard/schedule');
    }
}
