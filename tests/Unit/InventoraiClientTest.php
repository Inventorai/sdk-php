<?php

namespace Inventorai\SDK\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Inventorai\SDK\InventoraiClient;
use Inventorai\SDK\Resources\Branches;
use Inventorai\SDK\Resources\Hmo;
use Inventorai\SDK\Resources\Properties;
use Inventorai\SDK\Resources\Inspections;
use Inventorai\SDK\Resources\PropertyTemplates;
use Inventorai\SDK\Resources\AssetChecks;
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
use Inventorai\SDK\Resources\Stats;
use Inventorai\SDK\Resources\Phrases;
use Inventorai\SDK\Resources\Modifiers;
use Inventorai\SDK\Resources\Scheduler;

class InventoraiClientTest extends TestCase
{
    protected InventoraiClient $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = new InventoraiClient('test-api-token');
    }

    public function test_client_can_be_instantiated(): void
    {
        $this->assertInstanceOf(InventoraiClient::class, $this->client);
    }

    public function test_client_can_be_instantiated_with_custom_base_url(): void
    {
        $client = new InventoraiClient('test-api-token', 'https://custom.example.com/api/v1');
        $this->assertInstanceOf(InventoraiClient::class, $client);
    }

    public function test_properties_returns_properties_resource(): void
    {
        $this->assertInstanceOf(Properties::class, $this->client->properties());
    }

    public function test_inspections_returns_inspections_resource(): void
    {
        $this->assertInstanceOf(Inspections::class, $this->client->inspections());
    }

    public function test_property_templates_returns_property_templates_resource(): void
    {
        $this->assertInstanceOf(PropertyTemplates::class, $this->client->propertyTemplates());
    }

    public function test_branches_returns_branches_resource(): void
    {
        $this->assertInstanceOf(Branches::class, $this->client->branches());
    }

    public function test_hmo_returns_hmo_resource(): void
    {
        $this->assertInstanceOf(Hmo::class, $this->client->hmo());
    }

    public function test_components_returns_components_resource(): void
    {
        $this->assertInstanceOf(Components::class, $this->client->components());
    }

    public function test_inspection_areas_returns_inspection_areas_resource(): void
    {
        $this->assertInstanceOf(InspectionAreas::class, $this->client->inspectionAreas());
    }

    public function test_inspection_items_returns_inspection_items_resource(): void
    {
        $this->assertInstanceOf(InspectionItems::class, $this->client->inspectionItems());
    }

    public function test_inspection_elements_returns_inspection_elements_resource(): void
    {
        $this->assertInstanceOf(InspectionElements::class, $this->client->inspectionElements());
    }

    public function test_defects_returns_defects_resource(): void
    {
        $this->assertInstanceOf(Defects::class, $this->client->defects());
    }

    public function test_meter_readings_returns_meter_readings_resource(): void
    {
        $this->assertInstanceOf(MeterReadings::class, $this->client->meterReadings());
    }

    public function test_keys_fobs_returns_keys_fobs_resource(): void
    {
        $this->assertInstanceOf(KeysFobs::class, $this->client->keysFobs());
    }

    public function test_compliance_returns_compliance_resource(): void
    {
        $this->assertInstanceOf(Compliance::class, $this->client->compliance());
    }

    public function test_compliance_forms_returns_compliance_forms_resource(): void
    {
        $this->assertInstanceOf(ComplianceForms::class, $this->client->complianceForms());
    }

    public function test_inspection_ai_returns_inspection_ai_resource(): void
    {
        $this->assertInstanceOf(InspectionAi::class, $this->client->inspectionAi());
    }

    public function test_address_lookup_returns_address_lookup_resource(): void
    {
        $this->assertInstanceOf(AddressLookup::class, $this->client->addressLookup());
    }

    public function test_stats_returns_stats_resource(): void
    {
        $this->assertInstanceOf(Stats::class, $this->client->stats());
    }

    public function test_phrases_returns_phrases_resource(): void
    {
        $this->assertInstanceOf(Phrases::class, $this->client->phrases());
    }

    public function test_modifiers_returns_modifiers_resource(): void
    {
        $this->assertInstanceOf(Modifiers::class, $this->client->modifiers());
    }

    public function test_scheduler_returns_scheduler_resource(): void
    {
        $this->assertInstanceOf(Scheduler::class, $this->client->scheduler());
    }

    public function test_each_call_returns_new_instance(): void
    {
        $properties1 = $this->client->properties();
        $properties2 = $this->client->properties();
        $this->assertNotSame($properties1, $properties2);
    }

    public function test_asset_checks_returns_asset_checks_resource(): void
    {
        $this->assertInstanceOf(AssetChecks::class, $this->client->assetChecks());
    }
}
