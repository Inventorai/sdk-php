<?php

namespace Inventorai\SDK\Resources;

use Inventorai\SDK\Http\Client;

class Phrases
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Sync phrases
     *
     * @return array
     */
    public function sync(): array
    {
        return $this->client->get('/phrases/sync');
    }

    /**
     * Search phrases
     *
     * @param array $params Search parameters
     * @return array
     */
    public function search(array $params): array
    {
        return $this->client->get('/phrases/search', $params);
    }

    /**
     * Create a new phrase
     *
     * @param array $data Phrase data
     * @return array
     */
    public function create(array $data): array
    {
        return $this->client->post('/phrases', $data);
    }

    /**
     * Generate phrases using AI
     *
     * @param array $data Generation parameters
     * @return array
     */
    public function generate(array $data): array
    {
        return $this->client->post('/phrases/generate', $data);
    }

    /**
     * Learn phrases from context
     *
     * @param array $data Learning data
     * @return array
     */
    public function learn(array $data): array
    {
        return $this->client->post('/phrases/learn', $data);
    }

    /**
     * Get phrase statistics
     *
     * @return array
     */
    public function stats(): array
    {
        return $this->client->get('/phrases/stats');
    }
}
