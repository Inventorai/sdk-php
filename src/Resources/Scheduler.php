<?php

namespace Inventorai\SDK\Resources;

use Inventorai\SDK\Http\Client;

class Scheduler
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Get scheduler calendar
     *
     * @param array $params Query parameters
     * @return array
     */
    public function calendar(array $params = []): array
    {
        return $this->client->get('/inspections/scheduler/calendar', $params);
    }

    /**
     * Set weekly availability
     *
     * @param array $data Availability data
     * @return array
     */
    public function weeklyAvailability(array $data): array
    {
        return $this->client->post('/inspections/scheduler/availability/weekly', $data);
    }

    /**
     * Check for scheduling conflicts
     *
     * @param array $data Conflict check data
     * @return array
     */
    public function checkConflicts(array $data): array
    {
        return $this->client->post('/inspections/scheduler/availability/check-conflicts', $data);
    }

    /**
     * Get office hours
     *
     * @return array
     */
    public function officeHours(): array
    {
        return $this->client->get('/inspections/scheduler/office-hours');
    }

    /**
     * Estimate inspection duration
     *
     * @param array $data Estimation parameters
     * @return array
     */
    public function estimateDuration(array $data): array
    {
        return $this->client->post('/inspections/scheduler/estimate-duration', $data);
    }
}
