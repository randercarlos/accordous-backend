<?php

namespace Tests\Feature;

use App\Models\Contract;
use App\Models\Property;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tymon\JWTAuth\Facades\JWTAuth;

class ContractFeatureTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_can_list_contracts()
    {
        // create 10 contracts
        factory(Contract::class, 10)->create([
            'property_id' => factory(Property::class)->create()->id
        ]);

        $response = $this->get('/api/v1/contracts');

        $response
            ->assertOk()
            ->assertSee('data')
            ->assertJsonCount(10, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'contractor_fullname', 'contractor_email', 'person_type', 'document', 'property_id',
                    'created_at', 'updated_at']
                ]
            ]);
    }

    public function test_it_can_show_a_contract()
    {
        $contract = factory(Contract::class)->create([
            'property_id' => factory(Property::class)->create()->id
        ]);

        $response = $this->get('/api/v1/contracts/' . $contract->id);

        $response
            ->assertOk()
            ->assertJsonStructure([
                'id', 'contractor_fullname', 'contractor_email', 'person_type', 'document', 'property_id',
                    'created_at', 'updated_at'
            ]);
    }

    public function test_it_cant_show_a_contract_with_nonexistent_id()
    {
        factory(Contract::class)->create([
            'property_id' => factory(Property::class)->create()->id
        ]);

        $response = $this->get('/api/v1/contracts/9999999');

        $response->assertNotFound();
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_can_create_a_contract()
    {
        $contract = factory(Contract::class)->make([
            'property_id' => factory(Property::class)->create()->id
        ]);

        $response = $this->post('/api/v1/contracts', $contract->toArray());

        $response
            ->assertCreated()
            ->assertJson([
                'contractor_fullname' => $contract->contractor_fullname,
                'contractor_email' => $contract->contractor_email,
                'person_type' => $contract->person_type,
                'document' => $contract->document,
                'property_id' => $contract->property_id,
            ])
            ->assertJsonStructure([
                'id', 'contractor_fullname', 'contractor_email', 'person_type', 'document', 'property_id',
                    'created_at', 'updated_at'
            ]);

        $this->assertDatabaseCount('contracts', 1);

        $this->assertDatabaseHas('contracts', [
            'contractor_fullname' => $contract->contractor_fullname,
            'contractor_email' => $contract->contractor_email,
            'person_type' => $contract->person_type,
            'document' => $contract->document,
            'property_id' => $contract->property_id,
        ]);
    }




    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_cannot_create_a_contract_without_required_fields()
    {
        $response = $this->post('/api/v1/contracts', []);
        $response->assertStatus(422);

        $response = $this->post('/api/v1/contracts', ['contractor_fullname']);
        $response->assertStatus(422);

        $response = $this->post('/api/v1/contracts', ['contractor_email']);
        $response->assertStatus(422);

        $response = $this->post('/api/v1/contracts', ['person_type']);
        $response->assertStatus(422);

        $response = $this->post('/api/v1/contracts', ['document']);
        $response->assertStatus(422);

        $response = $this->post('/api/v1/contracts', ['property_id']);
        $response->assertStatus(422);

        // make sure there are no contract
        $this->assertDatabaseCount('contracts', 0);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_can_update_a_contract()
    {
        $contract = factory(Contract::class)->create([
            'property_id' => factory(Property::class)->create()->id
        ]);

        $response = $this->put('/api/v1/contracts/' . $contract->id, [
            'contractor_fullname' => 'João da Silva',
            'contractor_email' => 'joao.silva@gmail.com',
            'person_type' => 'PF',
            'document' => '046.495.140-29',
            'property_id' => 1,
        ]);

        $response
            ->assertOk()
            ->assertJson([
                'contractor_fullname' => 'João da Silva',
                'contractor_email' => 'joao.silva@gmail.com',
                'person_type' => 'PF',
                'document' => '046.495.140-29',
                'property_id' => 1,
            ])
            ->assertJsonStructure([
                'id', 'contractor_fullname', 'contractor_email', 'person_type', 'document', 'property_id',
                    'created_at', 'updated_at'
            ]);

        $this->assertDatabaseCount('contracts', 1);

        $this->assertDatabaseHas('contracts', [
            'contractor_fullname' => 'João da Silva',
            'contractor_email' => 'joao.silva@gmail.com',
            'person_type' => 'PF',
            'document' => '046.495.140-29',
            'property_id' => 1,
        ]);

    }


    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_cannot_update_a_contract_with_nonexistent_id()
    {
        factory(Property::class)->create();

        $response = $this->put('/api/v1/contracts/999999', [
            'contractor_fullname' => 'João da Silva',
            'contractor_email' => 'joao.silva@gmail.com',
            'person_type' => 'PF',
            'document' => '046.495.140-29',
            'property_id' => 1,
        ]);

        $response->assertNotFound();
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_cannot_update_a_contract_without_required_fields()
    {
        $contract = factory(Contract::class)->create([
            'property_id' => factory(Property::class)->create()->id
        ]);

        $response = $this->put('/api/v1/contracts/' . $contract->id, ['contractor_fullname']);
        $response->assertStatus(422);

        $response = $this->put('/api/v1/contracts/' . $contract->id, ['contractor_email']);
        $response->assertStatus(422);

        $response = $this->put('/api/v1/contracts/' . $contract->id, ['person_type']);
        $response->assertStatus(422);

        $response = $this->put('/api/v1/contracts/' . $contract->id, ['document']);
        $response->assertStatus(422);

        $response = $this->put('/api/v1/contracts/' . $contract->id, ['property_id']);
        $response->assertStatus(422);

        // make sure there are no contract
        $this->assertDatabaseCount('contracts', 1);
    }


    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_can_soft_delete_a_contract()
    {
        $contract = factory(Contract::class)->create([
            'property_id' => factory(Property::class)->create()->id
        ]);

        $response = $this->delete('/api/v1/contracts/' . $contract->id);

        $response->assertOk();

        $this->assertDatabaseCount('contracts', 1);    // record must stay in database because it was soft delete
        $contract->refresh();   // refresh the record because it was soft delete
        $this->assertTrue($contract->trashed()); // is soft delete
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_cannot_delete_a_contract_with_nonexistent_id()
    {
        $contract = factory(Contract::class)->create([
            'property_id' => factory(Property::class)->create()->id
        ]);

        $response = $this->delete('/api/v1/contracts/999999');

        $response->assertNotFound();

        $this->assertDatabaseCount('contracts', 1);
    }
}
