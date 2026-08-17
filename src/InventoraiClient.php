<?php

namespace Inventorai\SDK;

use Inventorai\SDK\Http\Client;
use Inventorai\SDK\Resources\Branches;
use Inventorai\SDK\Resources\Hmo;
use Inventorai\SDK\Resources\Properties;
use Inventorai\SDK\Resources\Inspections;
use Inventorai\SDK\Resources\PropertyTemplates;
use Inventorai\SDK\Resources\Components;
use Inventorai\SDK\Resources\InspectionAreas;
use Inventorai\SDK\Resources\InspectionItems;
use Inventorai\SDK\Resources\InspectionElements;
use Inventorai\SDK\Resources\Defects;
use Inventorai\SDK\Resources\MeterReadings;
use Inventorai\SDK\Resources\KeysFobs;
use Inventorai\SDK\Resources\Compliance;
use Inventorai\SDK\Resources\ComplianceForms;
use Inventorai\SDK\Resources\InspectionAi;
use Inventorai\SDK\Resources\AddressLookup;
use Inventorai\SDK\Resources\AssetChecks;
use Inventorai\SDK\Resources\Stats;
use Inventorai\SDK\Resources\Phrases;
use Inventorai\SDK\Resources\Modifiers;
use Inventorai\SDK\Resources\Scheduler;
use Inventorai\SDK\Resources\Team;

class InventoraiClient
{
    protected Client $client;

    public function __construct(string $apiToken, string $baseUrl = 'https://api.inventorai.co.uk/v1/team')
    {
        $this->client = new Client($apiToken, $baseUrl);
    }

    /**
     * Access Properties resource
     */
    public function properties(): Properties
    {
        return new Properties($this->client);
    }

    /**
     * Access Inspections resource
     */
    public function inspections(): Inspections
    {
        return new Inspections($this->client);
    }

    /**
     * Access Property Templates (Blueprints) resource
     */
    public function propertyTemplates(): PropertyTemplates
    {
        return new PropertyTemplates($this->client);
    }

    /**
     * Access Branches resource
     */
    public function branches(): Branches
    {
        return new Branches($this->client);
    }

    /**
     * Access HMO (House in Multiple Occupation) resource
     */
    public function hmo(): Hmo
    {
        return new Hmo($this->client);
    }

    /**
     * Access Components resource
     */
    public function components(): Components
    {
        return new Components($this->client);
    }

    /**
     * Access Inspection Areas resource
     */
    public function inspectionAreas(): InspectionAreas
    {
        return new InspectionAreas($this->client);
    }

    /**
     * Access Inspection Items resource
     */
    public function inspectionItems(): InspectionItems
    {
        return new InspectionItems($this->client);
    }

    /**
     * Access Inspection Elements resource
     */
    public function inspectionElements(): InspectionElements
    {
        return new InspectionElements($this->client);
    }

    /**
     * Access Defects resource
     */
    public function defects(): Defects
    {
        return new Defects($this->client);
    }

    /**
     * Access Meter Readings resource
     */
    public function meterReadings(): MeterReadings
    {
        return new MeterReadings($this->client);
    }

    /**
     * Access Asset Checks resource
     */
    public function assetChecks(): AssetChecks
    {
        return new AssetChecks($this->client);
    }

    /**
     * Access Keys/Fobs resource
     */
    public function keysFobs(): KeysFobs
    {
        return new KeysFobs($this->client);
    }

    /**
     * Access Compliance resource
     */
    public function compliance(): Compliance
    {
        return new Compliance($this->client);
    }

    /**
     * Access Compliance Forms resource
     */
    public function complianceForms(): ComplianceForms
    {
        return new ComplianceForms($this->client);
    }

    /**
     * Access Inspection AI resource
     */
    public function inspectionAi(): InspectionAi
    {
        return new InspectionAi($this->client);
    }

    /**
     * Access Address Lookup resource
     */
    public function addressLookup(): AddressLookup
    {
        return new AddressLookup($this->client);
    }

    /**
     * Access Stats resource
     */
    public function stats(): Stats
    {
        return new Stats($this->client);
    }

    /**
     * Access Phrases resource
     */
    public function phrases(): Phrases
    {
        return new Phrases($this->client);
    }

    /**
     * Access Modifiers resource
     */
    public function modifiers(): Modifiers
    {
        return new Modifiers($this->client);
    }

    /**
     * Access Scheduler resource
     */
    public function scheduler(): Scheduler
    {
        return new Scheduler($this->client);
    }

    /**
     * Access Team resource — current team info, including the team_id
     * needed for the `private-team.{id}` socket channel.
     */
    public function team(): Team
    {
        return new Team($this->client);
    }

}
