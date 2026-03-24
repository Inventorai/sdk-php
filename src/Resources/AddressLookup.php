<?php

namespace Inventorai\SDK\Resources;

use Inventorai\SDK\Http\Client;

class AddressLookup
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Look up addresses by postcode
     *
     * @param string $postcode Postcode to look up
     * @return array
     */
    public function lookup(string $postcode): array
    {
        return $this->client->post('/address-lookup/lookup', ['postcode' => $postcode]);
    }

    /**
     * Bulk look up addresses by multiple postcodes
     *
     * @param array $postcodes Array of postcodes
     * @return array
     */
    public function bulkLookup(array $postcodes): array
    {
        return $this->client->post('/address-lookup/bulk-lookup', ['postcodes' => $postcodes]);
    }

    /**
     * Get detailed address information
     *
     * @param array $data Address details request data
     * @return array
     */
    public function getDetails(array $data): array
    {
        return $this->client->post('/address-lookup/details', $data);
    }

    /**
     * Get address lookup usage statistics
     *
     * @return array
     */
    public function usage(): array
    {
        return $this->client->get('/address-lookup/usage');
    }
}
