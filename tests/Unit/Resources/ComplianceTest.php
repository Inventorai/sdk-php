<?php

namespace Inventorai\SDK\Tests\Unit\Resources;

use PHPUnit\Framework\TestCase;
use Mockery;
use Inventorai\SDK\Http\Client;
use Inventorai\SDK\Resources\Compliance;

class ComplianceTest extends TestCase
{
    protected Compliance $compliance;
    protected $mockClient;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockClient = Mockery::mock(Client::class);
        $this->compliance = new Compliance($this->mockClient);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_list_compliance_forms(): void
    {
        $this->mockClient->shouldReceive('get')
            ->once()
            ->with('/inspections/42/compliance')
            ->andReturn(['data' => []]);

        $result = $this->compliance->list(42);
        $this->assertEquals(['data' => []], $result);
    }

    public function test_attach_compliance_form(): void
    {
        $this->mockClient->shouldReceive('post')
            ->once()
            ->with('/inspections/42/compliance/attach', ['form_id' => 5])
            ->andReturn(['data' => ['id' => 1, 'form_id' => 5]]);

        $result = $this->compliance->attach(42, 5);
        $this->assertEquals(['data' => ['id' => 1, 'form_id' => 5]], $result);
    }

    public function test_attach_multiple_compliance_forms(): void
    {
        $formIds = [1, 2, 3];

        $this->mockClient->shouldReceive('post')
            ->once()
            ->with('/inspections/42/compliance/attach-multiple', ['form_ids' => $formIds])
            ->andReturn(['data' => ['attached' => 3]]);

        $result = $this->compliance->attachMultiple(42, $formIds);
        $this->assertEquals(['data' => ['attached' => 3]], $result);
    }

    public function test_update_response(): void
    {
        $data = ['value' => 'Yes', 'notes' => 'All clear'];

        $this->mockClient->shouldReceive('patch')
            ->once()
            ->with('/inspections/42/compliance/fields/10', $data)
            ->andReturn(['data' => ['id' => 10, 'value' => 'Yes']]);

        $result = $this->compliance->updateResponse(42, 10, $data);
        $this->assertEquals(['data' => ['id' => 10, 'value' => 'Yes']], $result);
    }

    public function test_batch_update_responses(): void
    {
        $fields = [
            ['id' => 10, 'value' => 'Yes'],
            ['id' => 11, 'value' => 'No'],
        ];

        $this->mockClient->shouldReceive('post')
            ->once()
            ->with('/inspections/42/compliance/batch', ['fields' => $fields])
            ->andReturn(['data' => ['updated' => 2]]);

        $result = $this->compliance->batchUpdateResponses(42, $fields);
        $this->assertEquals(['data' => ['updated' => 2]], $result);
    }

    public function test_upload_file(): void
    {
        $filePath = '/tmp/compliance-doc.pdf';

        $this->mockClient->shouldReceive('upload')
            ->once()
            ->with('/inspections/42/compliance/upload', $filePath, 'file')
            ->andReturn(['data' => ['id' => 'file-1', 'url' => 'https://example.com/doc.pdf']]);

        $result = $this->compliance->uploadFile(42, $filePath);
        $this->assertEquals(['data' => ['id' => 'file-1', 'url' => 'https://example.com/doc.pdf']], $result);
    }

    public function test_add_section_instance(): void
    {
        $data = ['section_id' => 5, 'label' => 'Additional Section'];

        $this->mockClient->shouldReceive('post')
            ->once()
            ->with('/inspections/42/compliance/section-instance', $data)
            ->andReturn(['data' => ['id' => 20, 'section_id' => 5]]);

        $result = $this->compliance->addSectionInstance(42, $data);
        $this->assertEquals(['data' => ['id' => 20, 'section_id' => 5]], $result);
    }

    public function test_remove_section_instance(): void
    {
        $this->mockClient->shouldReceive('delete')
            ->once()
            ->with('/inspections/42/compliance/section-instance/20')
            ->andReturn(['message' => 'Section instance removed']);

        $result = $this->compliance->removeSectionInstance(42, 20);
        $this->assertEquals(['message' => 'Section instance removed'], $result);
    }

    public function test_summary(): void
    {
        $this->mockClient->shouldReceive('get')
            ->once()
            ->with('/inspections/42/compliance/summary')
            ->andReturn(['data' => ['total' => 10, 'completed' => 8]]);

        $result = $this->compliance->summary(42);
        $this->assertEquals(['data' => ['total' => 10, 'completed' => 8]], $result);
    }

    public function test_update_compliance_form(): void
    {
        $data = ['status' => 'completed'];

        $this->mockClient->shouldReceive('patch')
            ->once()
            ->with('/inspections/42/compliance-forms/5', $data)
            ->andReturn(['data' => ['id' => 5, 'status' => 'completed']]);

        $result = $this->compliance->update(42, 5, $data);
        $this->assertEquals(['data' => ['id' => 5, 'status' => 'completed']], $result);
    }

    public function test_detach_compliance_form(): void
    {
        $this->mockClient->shouldReceive('delete')
            ->once()
            ->with('/inspections/42/compliance-forms/5')
            ->andReturn(['message' => 'Form detached']);

        $result = $this->compliance->detach(42, 5);
        $this->assertEquals(['message' => 'Form detached'], $result);
    }
}
