<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\OphthalmologyEncounterRecord;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExaminationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test creating a new examination record.
     */
    public function test_can_create_examination_record()
    {
        $user = User::factory()->create(['location_id' => 1]);
        $customer = Customer::create([
            'name' => 'Jane Doe',
            'location_id' => 1,
            'created_by' => $user->id
        ]);

        $this->actingAs($user);

        $data = [
            'customer_id' => $customer->id,
            'chief_complaint' => 'Blurred vision',
            'hpi' => 'Started 2 days ago',
            'body_temperature' => 36.5,
            'iop_od' => 15.5,
            'sle_od_cornea' => 'Clear',
            'management_plan' => 'Prescribed glasses',
        ];

        $response = $this->post(route('examination.store'), $data);

        $response->assertRedirect(route('examination.all'));
        $this->assertDatabaseHas('ophthalmology_encounter_records', [
            'customer_id' => $customer->id,
            'chief_complaint' => 'Blurred vision',
            'location_id' => 1,
            'created_by' => $user->id,
            'sle_od_cornea' => 'Clear',
        ]);
    }

    /**
     * Test that examinations are correctly scoped to the user's location.
     */
    public function test_examination_records_are_location_scoped()
    {
        $user1 = User::factory()->create(['location_id' => 1, 'role' => 2]); // Location 1
        $user2 = User::factory()->create(['location_id' => 2, 'role' => 2]); // Location 2
        
        $customer1 = Customer::create(['name' => 'Patient 1', 'location_id' => 1]);
        $customer2 = Customer::create(['name' => 'Patient 2', 'location_id' => 2]);

        $record1 = OphthalmologyEncounterRecord::create([
            'customer_id' => $customer1->id,
            'chief_complaint' => 'Complaint Location 1',
            'location_id' => 1,
            'created_by' => $user1->id,
            'date' => now()
        ]);

        $record2 = OphthalmologyEncounterRecord::create([
            'customer_id' => $customer2->id,
            'chief_complaint' => 'Complaint Location 2',
            'location_id' => 2,
            'created_by' => $user2->id,
            'date' => now()
        ]);

        $this->assertEquals(1, $record1->location_id);
        $this->assertEquals(2, $record2->location_id);

        // Acting as user from location 1 (Super Admin because location_id is 1)
        $this->actingAs($user1);
        $response = $this->get(route('examination.all'));
        $response->assertStatus(200);
        $response->assertSee('Complaint Location 1');
        $response->assertSee('Complaint Location 2'); // Location 1 users see everything

        // Acting as user from location 2
        $this->actingAs($user2);
        
        // Let's check what the query sees
        $recordsForUser2 = OphthalmologyEncounterRecord::all();
        $this->assertCount(1, $recordsForUser2);
        $this->assertEquals('Complaint Location 2', $recordsForUser2->first()->chief_complaint);

        $response = $this->get(route('examination.all'));
        $response->assertStatus(200);
        $response->assertSee('Complaint Location 2');
        $response->assertDontSee('Complaint Location 1');
    }

    /**
     * Test deleting an examination record.
     */
    public function test_can_delete_examination_record()
    {
        $user = User::factory()->create(['location_id' => 1]);
        $customer = Customer::create(['name' => 'Jane Doe', 'location_id' => 1]);
        
        $record = OphthalmologyEncounterRecord::create([
            'customer_id' => $customer->id,
            'location_id' => 1,
            'created_by' => $user->id,
            'date' => now()
        ]);

        $this->actingAs($user);

        $response = $this->get(route('examination.delete', $record->id));

        $response->assertRedirect(route('examination.all'));
        $this->assertDatabaseMissing('ophthalmology_encounter_records', [
            'id' => $record->id
        ]);
    }
}
