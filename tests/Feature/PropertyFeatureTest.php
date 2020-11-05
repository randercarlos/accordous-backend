<?php

namespace Tests\Feature;

use App\Models\Property;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tymon\JWTAuth\Facades\JWTAuth;

class PropertyFeatureTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_can_list_properties()
    {
        // create 10 properties
        factory(Property::class, 10)->create();

        $response = $this->get('/api/v1/properties');

        $response
            ->assertOk()
            ->assertSee('data')
            ->assertJsonCount(10, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'owner_email', 'address', 'number', 'complement', 'neighborhood', 'city', 'state',
                    'created_at', 'updated_at']
                ]
            ]);
    }

    public function test_it_can_show_a_property()
    {
        $property = factory(Property::class)->create();

        $response = $this->get('/api/v1/properties/' . $property->id);

        $response
            ->assertOk()
            ->assertJsonStructure([
                'id', 'owner_email', 'address', 'number', 'complement', 'neighborhood', 'city', 'state',
                    'created_at', 'updated_at'
            ]);
    }

    public function test_it_cant_show_a_property_with_nonexistent_id()
    {
        factory(Property::class)->create();

        $response = $this->get('/api/v1/properties/9999999');

        $response->assertNotFound();
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_can_create_a_property()
    {
        $property = factory(Property::class)->make();

        $response = $this->post('/api/v1/properties', $property->toArray());

        $response
            ->assertCreated()
            ->assertJson([
                'owner_email' => $property->owner_email,
                'address' => $property->address,
                'number' => $property->number,
                'complement' => $property->complement,
                'neighborhood' => $property->neighborhood,
                'city' => $property->city,
                'state' => $property->state
            ])
            ->assertJsonStructure([
                'id', 'owner_email', 'address', 'number', 'complement', 'neighborhood', 'city', 'state',
                    'created_at', 'updated_at'
            ]);

        $this->assertDatabaseCount('properties', 1);

        $this->assertDatabaseHas('properties', [
            'owner_email' => $property->owner_email,
            'address' => $property->address,
            'number' => $property->number,
            'complement' => $property->complement,
            'neighborhood' => $property->neighborhood,
            'city' => $property->city,
            'state' => $property->state
        ]);
    }




    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_cannot_create_a_property_without_required_fields()
    {
        $response = $this->post('/api/v1/properties', []);
        $response->assertStatus(422);

        $response = $this->post('/api/v1/properties', ['owner_email']);
        $response->assertStatus(422);

        $response = $this->post('/api/v1/properties', ['address']);
        $response->assertStatus(422);

        $response = $this->post('/api/v1/properties', ['number']);
        $response->assertStatus(422);

        $response = $this->post('/api/v1/properties', ['complement']);
        $response->assertStatus(422);

        $response = $this->post('/api/v1/properties', ['neighborhood']);
        $response->assertStatus(422);

        $response = $this->post('/api/v1/properties', ['city']);
        $response->assertStatus(422);

        $response = $this->post('/api/v1/properties', ['state']);
        $response->assertStatus(422);

        // make sure there are no property
        $this->assertDatabaseCount('properties', 0);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_can_update_a_property()
    {
        $property = factory(Property::class)->create();

        $response = $this->put('/api/v1/properties/' . $property->id, [
            'owner_email' => 'teste@testando.com',
            'address' => 'Rua das Flores',
            'number' => '91',
            'complement' => 'apt. 3C',
            'neighborhood' => 'São João de Meriti',
            'city' => 'Rio de Janeiro',
            'state' => 'RJ'
        ]);

        $response
            ->assertOk()
            ->assertJson([
                'owner_email' => 'teste@testando.com',
                'address' => 'Rua das Flores',
                'number' => '91',
                'complement' => 'apt. 3C',
                'neighborhood' => 'São João de Meriti',
                'city' => 'Rio de Janeiro',
                'state' => 'RJ'
            ])
            ->assertJsonStructure([
                'id', 'owner_email', 'address', 'number', 'complement', 'neighborhood', 'city', 'state',
                    'created_at', 'updated_at'
            ]);

        $this->assertDatabaseCount('properties', 1);

        $this->assertDatabaseHas('properties', [
            'owner_email' => 'teste@testando.com',
            'address' => 'Rua das Flores',
            'number' => '91',
            'complement' => 'apt. 3C',
            'neighborhood' => 'São João de Meriti',
            'city' => 'Rio de Janeiro',
            'state' => 'RJ'
        ]);

    }


    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_cannot_update_a_property_with_nonexistent_id()
    {
        $response = $this->put('/api/v1/properties/999999', [
            'owner_email' => 'teste@testando.com',
            'address' => 'Rua das Flores',
            'number' => '91',
            'complement' => 'apt. 3C',
            'neighborhood' => 'São João de Meriti',
            'city' => 'Rio de Janeiro',
            'state' => 'RJ'
        ]);

        $response->assertNotFound();
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_cannot_update_a_property_without_required_fields()
    {
        $property = factory(Property::class)->create();

        $response = $this->put('/api/v1/properties/' . $property->id, ['owner_email']);
        $response->assertStatus(422);

        $response = $this->put('/api/v1/properties/' . $property->id, ['address']);
        $response->assertStatus(422);

        $response = $this->put('/api/v1/properties/' . $property->id, ['number']);
        $response->assertStatus(422);

        $response = $this->put('/api/v1/properties/' . $property->id, ['complement']);
        $response->assertStatus(422);

        $response = $this->put('/api/v1/properties/' . $property->id, ['neighborhood']);
        $response->assertStatus(422);

        $response = $this->put('/api/v1/properties/' . $property->id, ['city']);
        $response->assertStatus(422);

        $response = $this->put('/api/v1/properties/' . $property->id, ['state']);
        $response->assertStatus(422);


        // make sure there are no property
        $this->assertDatabaseCount('properties', 1);
    }


    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_can_soft_delete_a_property()
    {
        $property = factory(Property::class)->create();

        $response = $this->delete('/api/v1/properties/' . $property->id);

        $response->assertOk();

        $this->assertDatabaseCount('properties', 1);    // record must stay in database because it was soft delete
        $property->refresh();   // refresh the record because it was soft delete
        $this->assertTrue($property->trashed()); // is soft delete
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_cannot_delete_a_property_with_nonexistent_id()
    {
        factory(Property::class)->create();

        $response = $this->delete('/api/v1/properties/999999');

        $response->assertNotFound();

        $this->assertDatabaseCount('properties', 1);
    }
}
