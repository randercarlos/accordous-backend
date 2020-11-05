<?php

namespace Tests\Unit;

use App\Models\Property;
use App\Models\Contract;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PropertyUnitTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_can_get_the_status()
    {
        $property = factory(Property::class)->create();
        factory(Contract::class)->create([
            'property_id' => $property->id
        ]);
        $this->assertTrue($property->status);   // status is true because Property is associate a one contract


        $property = factory(Property::class)->create();
        $this->assertFalse($property->status);  // status is false because Property isn't associate a one contract
    }
}
