<?php

namespace Inventorai\SDK\Resources;

use Inventorai\SDK\Http\Client;

class Modifiers
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * List all modifiers
     *
     * @return array
     */
    public function list(): array
    {
        return $this->client->get('/modifiers');
    }

    /**
     * Get modifier types
     *
     * @return array
     */
    public function types(): array
    {
        return $this->client->get('/modifiers/types');
    }

    /**
     * Get modifiers for an item
     *
     * @param array $params Query parameters
     * @return array
     */
    public function forItem(array $params = []): array
    {
        return $this->client->get('/modifiers/for-item', $params);
    }

    /**
     * Search modifiers
     *
     * @param array $params Search parameters
     * @return array
     */
    public function search(array $params): array
    {
        return $this->client->get('/modifiers/search', $params);
    }

    /**
     * Get disabled modifiers
     *
     * @return array
     */
    public function disabled(): array
    {
        return $this->client->get('/modifiers/disabled');
    }

    /**
     * Get master modifier list
     *
     * @return array
     */
    public function master(): array
    {
        return $this->client->get('/modifiers/master');
    }

    /**
     * Create a custom modifier
     *
     * @param array $data Modifier data
     * @return array
     */
    public function createCustom(array $data): array
    {
        return $this->client->post('/modifiers/custom', $data);
    }

    /**
     * Delete a custom modifier
     *
     * @param int|string $id Modifier ID
     * @return array
     */
    public function deleteCustom(int|string $id): array
    {
        return $this->client->delete("/modifiers/custom/{$id}");
    }

    /**
     * Disable a modifier
     *
     * @param int|string $id Modifier ID
     * @return array
     */
    public function disable(int|string $id): array
    {
        return $this->client->post("/modifiers/{$id}/disable");
    }

    /**
     * Enable a modifier
     *
     * @param int|string $id Modifier ID
     * @return array
     */
    public function enable(int|string $id): array
    {
        return $this->client->post("/modifiers/{$id}/enable");
    }

    /**
     * Compose modifiers
     *
     * @param array $data Composition data
     * @return array
     */
    public function compose(array $data): array
    {
        return $this->client->post('/modifiers/compose', $data);
    }

    /**
     * Sync the modifier library (full snapshot for offline caches)
     *
     * @param array $params Optional query parameters
     * @return array
     */
    public function sync(array $params = []): array
    {
        return $this->client->get('/modifiers/sync', $params);
    }
}
