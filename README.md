# Inventorai PHP SDK

Official PHP SDK for the Inventorai API - AI-powered property inspection and management platform.

## Installation

```bash
composer require inventorai/sdk
```

## Requirements

- PHP 8.3 or higher
- Guzzle HTTP Client

## Quick Start

```php
<?php

require 'vendor/autoload.php';

use Inventorai\SDK\InventoraiClient;

$client = new InventoraiClient('your-api-token-here');

// List properties
$properties = $client->properties()->list([
    'filter' => ['status' => 'active'],
    'include' => 'landlord',
    'per_page' => 20
]);

// Create a property
$property = $client->properties()->create([
    'address_line_1' => '123 High Street',
    'postcode' => 'SW1A 1AA',
    'country' => 'GB',
    'property_type' => 'flat',
    'residential' => true,
]);
```

## Configuration

### Base URL

By default, the SDK uses `https://api.inventorai.co.uk/v1/team` — the third-party Team API surface, authenticated with a team API token. To point at a different host (e.g. local development):

```php
$client = new InventoraiClient(
    'your-api-token',
    'https://api.inventorai.test/v1/team'
);
```

## Resources

### Properties

```php
// List with filters
$properties = $client->properties()->list([
    'filter' => ['status' => 'active', 'property_type' => 'flat'],
    'include' => ['landlord', 'inspections'],
    'sort' => '-created_at',
    'per_page' => 50
]);

// Get single property
$property = $client->properties()->get(123, ['include' => 'landlord']);

// Create
$property = $client->properties()->create([
    'address_line_1' => '10 Downing Street',
    'postcode' => 'SW1A 2AA',
    'country' => 'GB',
    'property_type' => 'house',
    'residential' => true,
]);

// Active tenancy
$tenancy = $client->properties()->activeTenancy(123);

// Cover image
$client->properties()->uploadCoverImage(123, '/path/to/image.jpg');
$client->properties()->deleteCoverImage(123);
```

### Inspections

```php
// List
$inspections = $client->inspections()->list([
    'filter' => ['property_id' => 123, 'status' => 'scheduled']
]);

// Create
$inspection = $client->inspections()->create([
    'property_id' => 123,
    'type' => 'move_in',
    'inspection_date' => '2026-04-01',
    'ai_mode_enabled' => true,
]);

// Create with offline-built ULID + nested tree (lets a client sync a full
// inspection structure in one call and reuse its own row IDs)
$inspection = $client->inspections()->create([
    'id' => '01HZW4N8R7Q5K3JX0V9PT6S2EM',
    'property_id' => 123,
    'type' => 'periodic',
    'scheduled_end_at' => '2026-04-01T11:00:00Z',
    'areas' => [[
        'id' => '01HZW4N8R7Q5K3JX0V9PT6S2A1',
        'name' => 'Living Room',
        'items' => [[
            'id' => '01HZW4N8R7Q5K3JX0V9PT6S2I1',
            'name' => 'Sofa',
            'elements' => [[
                'id' => '01HZW4N8R7Q5K3JX0V9PT6S2E1',
                'name' => 'Cushion',
            ]],
        ]],
    ]],
]);

// Initialize from a property template (async server-side expansion)
$client->inspections()->initialize([
    'property_id' => 123,
    'template_id' => 7,
    'type' => 'move_in',
]);

// Get with relations — one call returns the whole inspection tree.
// You almost never need the per-resource list() methods below for *reads* —
// pass everything you want through `include` and you'll get it inline.
$inspection = $client->inspections()->get(456, [
    'include' => [
        // property + tenancy context
        'property', 'property.currentTenancy.tenants', 'inspector',
        // the area → item → element tree (photos auto-load when these are included)
        'areas.items.elements',
        // optional sections
        'meterReadings', 'keysFobs',
        'assetChecks.propertyAsset.propertyArea',
        'complianceForms.sections.fields.responses',
    ],
]);

// The per-resource sections below (Inspection Areas, Items, Elements, …)
// are for **writes**: create, update, delete, duplicate, reorder, photo upload —
// and for mobile/offline sync where a client re-pulls one slice or pages a leaf
// (e.g. an HMO inspection with hundreds of items). For normal reads, prefer the
// `include` call above.

// Lifecycle
$client->inspections()->begin(456);
$client->inspections()->takeOver(456);          // claim an inspection locked by another inspector
$client->inspections()->takeBackToWeb(456);     // hand a mobile-takeover inspection back to the web UI
$client->inspections()->reschedule(456, ['inspection_date' => '2026-04-15']);
$client->inspections()->finalize(456);
$client->inspections()->reopen(456);            // reopen a finalised inspection for edits
$client->inspections()->delete(456);

// Check existing / comparable
$existing = $client->inspections()->checkExisting(['property_id' => 123, 'type' => 'move_in']);
$comparable = $client->inspections()->comparable(['property_id' => 123]);
```

### Inspection Areas

```php
$areas = $client->inspectionAreas()->list($inspectionId);
$area = $client->inspectionAreas()->get($inspectionId, $areaId);
$area = $client->inspectionAreas()->create($inspectionId, [
    'name' => 'Living Room', 'condition' => 'good', 'cleanliness' => 'clean'
]);
$client->inspectionAreas()->update($inspectionId, $areaId, ['condition' => 'fair']);
$client->inspectionAreas()->delete($inspectionId, $areaId);
$client->inspectionAreas()->duplicate($inspectionId, $areaId);
$client->inspectionAreas()->reorder($inspectionId, ['area1', 'area2', 'area3']);
$client->inspectionAreas()->uploadPhoto($inspectionId, $areaId, '/path/to/photo.jpg');
$client->inspectionAreas()->deletePhoto($inspectionId, $areaId, $photoId);
```

### Inspection Items

```php
$items = $client->inspectionItems()->list($inspectionId);
$item = $client->inspectionItems()->create($inspectionId, [
    'area_id' => $areaId, 'name' => 'Sofa', 'condition' => 'good'
]);
$client->inspectionItems()->update($inspectionId, $itemId, ['condition' => 'poor']);
$client->inspectionItems()->delete($inspectionId, $itemId);
$client->inspectionItems()->duplicate($inspectionId, $itemId);
$client->inspectionItems()->uploadPhoto($inspectionId, $itemId, '/path/to/photo.jpg');
```

### Inspection Elements

```php
$elements = $client->inspectionElements()->list($inspectionId);
$element = $client->inspectionElements()->create($inspectionId, [
    'item_id' => $itemId, 'name' => 'Cushion', 'condition' => 'fair'
]);
$client->inspectionElements()->update($inspectionId, $elementId, ['condition' => 'poor']);
$client->inspectionElements()->delete($inspectionId, $elementId);
$client->inspectionElements()->uploadPhoto($inspectionId, $elementId, '/path/to/photo.jpg');
```

### Defects

```php
$defects = $client->defects()->list($inspectionId);
$defect = $client->defects()->create($inspectionId, [
    'defectable_type' => 'item', 'defectable_id' => $itemId,
    'title' => 'Scratch on surface',
    'severity' => 'minor',           // nullable — omit if uncategorised
    'item_label' => 'Top-left drawer', // optional free-text label for the affected part
]);

// Contextual creation
$client->defects()->createForArea($inspectionId, $areaId, ['title' => 'Damp patch', 'severity' => 'major']);
$client->defects()->createForItem($inspectionId, $itemId, ['title' => 'Broken handle', 'severity' => 'moderate', 'item_label' => 'Right side']);
$client->defects()->createForElement($inspectionId, $elementId, ['title' => 'Stain', 'severity' => 'cosmetic']);

$client->defects()->update($inspectionId, $defectId, ['status' => 'fixed']);
$client->defects()->delete($inspectionId, $defectId);
$client->defects()->uploadPhoto($inspectionId, $defectId, '/path/to/photo.jpg');
```

### Meter Readings

```php
$meters = $client->meterReadings()->list($inspectionId);
$meter = $client->meterReadings()->create($inspectionId, [
    'meter_type' => 'gas', 'reading' => 12345, 'meter_location' => 'Under stairs'
]);
$client->meterReadings()->update($inspectionId, $meterId, ['reading' => 12350]);
$client->meterReadings()->delete($inspectionId, $meterId);
$client->meterReadings()->uploadPhoto($inspectionId, $meterId, '/path/to/photo.jpg');
```

### Keys & Fobs

```php
$keys = $client->keysFobs()->list($inspectionId);
$key = $client->keysFobs()->create($inspectionId, [
    'item_type' => 'front_door_key', 'quantity' => 2, 'description' => 'Yale key'
]);
$client->keysFobs()->update($inspectionId, $keyId, ['quantity' => 3]);
$client->keysFobs()->delete($inspectionId, $keyId);
$client->keysFobs()->uploadPhoto($inspectionId, $keyId, '/path/to/photo.jpg');
```

### Compliance

```php
// List forms on an inspection
$forms = $client->compliance()->list($inspectionId);

// Attach / detach
$client->compliance()->attach($inspectionId, $formId);
$client->compliance()->attachMultiple($inspectionId, [$formId1, $formId2]);
$client->compliance()->detach($inspectionId, $formId);

// Update responses
$client->compliance()->updateResponse($inspectionId, $fieldId, ['value' => 'Yes']);
$client->compliance()->batchUpdateResponses($inspectionId, [1 => 'Yes', 2 => 'No']);

// File uploads & section instances
$client->compliance()->uploadFile($inspectionId, '/path/to/document.pdf');
$client->compliance()->addSectionInstance($inspectionId, ['form_id' => 1, 'section_id' => 2]);
$client->compliance()->removeSectionInstance($inspectionId, $instanceId);

// Summary & update
$summary = $client->compliance()->summary($inspectionId);
$client->compliance()->update($inspectionId, $formId, $data);
```

### Compliance Form Templates

```php
$templates = $client->complianceForms()->list();
```

### Inspection AI

```php
$client->inspectionAi()->enable($inspectionId);
$client->inspectionAi()->disable($inspectionId);
$status = $client->inspectionAi()->status($inspectionId);
$client->inspectionAi()->retryCredits($inspectionId);
$client->inspectionAi()->requestRetry($inspectionId);
$retryStatus = $client->inspectionAi()->retryStatus($inspectionId);
$client->inspectionAi()->submitFeedback($inspectionId, ['rating' => 5, 'comment' => 'Great']);
```

### Property Templates (Blueprints)

```php
$templates = $client->propertyTemplates()->list();
$template = $client->propertyTemplates()->get(789);
```

### Branches

```php
$branches = $client->branches()->list();
$branch = $client->branches()->get(1);
```

### HMO (House in Multiple Occupation)

```php
$summary = $client->hmo()->summary($inspectionId);
$tenants = $client->hmo()->tenants($inspectionId);

$client->hmo()->assignTenantToArea($inspectionId, $areaId, [
    'tenant_ids' => ['tenant-1', 'tenant-2'],
    'is_shared' => false,
    'room_identifier' => 'Room 1',
]);

$client->hmo()->bulkAssignTenants($inspectionId, [
    'assignments' => [
        ['area_id' => 'area-1', 'tenant_ids' => ['tenant-1']],
        ['area_id' => 'area-2', 'is_shared' => true],
    ],
]);
```

### Components

```php
$components = $client->components()->list();
```

### Address Lookup

```php
$results = $client->addressLookup()->lookup('SW1A 1AA');
$bulk = $client->addressLookup()->bulkLookup(['SW1A 1AA', 'EC1A 1BB']);
$details = $client->addressLookup()->getDetails(['id' => 'addr_123']);
$usage = $client->addressLookup()->usage();
```

### Stats & Dashboard

```php
$stats = $client->stats()->index();
$teamStats = $client->stats()->team();
$userStats = $client->stats()->user();
$schedule = $client->stats()->schedule();
```

### Phrases

```php
$synced = $client->phrases()->sync();
$results = $client->phrases()->search(['q' => 'good condition', 'category' => 'item']);
$client->phrases()->create(['text' => 'In good working order', 'category' => 'item']);
$generated = $client->phrases()->generate(['query' => 'clean carpet', 'category' => 'item']);
$client->phrases()->learn(['descriptions' => ['Freshly painted walls']]);
$phraseStats = $client->phrases()->stats();
```

### Modifiers

```php
$modifiers = $client->modifiers()->list();
$types = $client->modifiers()->types();
$forItem = $client->modifiers()->forItem(['item_name' => 'Sofa']);
$search = $client->modifiers()->search(['q' => 'leather']);
$disabled = $client->modifiers()->disabled();
$master = $client->modifiers()->master();

$client->modifiers()->createCustom(['type' => 'brand', 'value' => 'IKEA']);
$client->modifiers()->deleteCustom($modifierId);
$client->modifiers()->disable($modifierId);
$client->modifiers()->enable($modifierId);
$composed = $client->modifiers()->compose(['items' => ['Brown', 'Leather', 'Sofa']]);
$sync = $client->modifiers()->sync();           // full snapshot for offline caches
```

### Asset Checks

Alarm and safety-equipment checks recorded against an inspection.

```php
$client->assetChecks()->update($inspectionId, $assetCheckId, [
    'tested' => 'yes',           // yes | no | not_accessible
    'test_result' => 'pass',     // pass | fail | na
    'condition' => 'good',       // good | fair | poor | replace
    'notes' => 'Sounded on test',
]);
$client->assetChecks()->uploadPhoto($inspectionId, $assetCheckId, '/path/to/photo.jpg');
```

### Scheduler

```php
$calendar = $client->scheduler()->calendar(['month' => '2026-04']);
$client->scheduler()->weeklyAvailability($data);
$conflicts = $client->scheduler()->checkConflicts($data);
$hours = $client->scheduler()->officeHours();
$duration = $client->scheduler()->estimateDuration($data);
```

## Query Parameters

### Filtering
```php
$properties = $client->properties()->list([
    'filter' => ['status' => 'active', 'property_type' => 'house']
]);
```

### Including Relationships
```php
$property = $client->properties()->get(123, [
    'include' => ['landlord', 'inspections']
]);
```

### Sorting
```php
$properties = $client->properties()->list([
    'sort' => '-created_at'  // Prefix with - for descending
]);
```

### Pagination
```php
$properties = $client->properties()->list(['per_page' => 50, 'page' => 2]);
```

## Error Handling

```php
use Inventorai\SDK\Exceptions\ApiException;
use Inventorai\SDK\Exceptions\AuthenticationException;
use Inventorai\SDK\Exceptions\RateLimitException;

try {
    $properties = $client->properties()->list();
} catch (AuthenticationException $e) {
    echo "Authentication failed: " . $e->getMessage();
} catch (RateLimitException $e) {
    echo "Rate limit exceeded: " . $e->getMessage();
} catch (ApiException $e) {
    echo "API error: " . $e->getMessage();
}
```

## API Token

An active [Inventorai](https://app.inventorai.co.uk) subscription is required to use the API.

1. Log in to Inventorai
2. Go to **Team Settings** > **API**
3. Create a new API token
4. Store securely

## Support

- Documentation: https://docs.inventorai.co.uk
- API Reference: https://docs.inventorai.co.uk/api/overview
- Email: support@inventorai.co.uk

## Licence

MIT Licence
