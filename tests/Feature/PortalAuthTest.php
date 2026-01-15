<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Member;

class PortalAuthTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function portal_page_loads_correctly()
    {
        $response = $this->get('/portal');
        $response->assertStatus(200);
        $response->assertViewIs('portal');
    }

    /** @test */
    public function member_can_login_with_valid_nis()
    {
        // Create Dummy Member
        $member = Member::factory()->create([
            'nis' => '998877',
            'name' => 'Test Santri',
            'rfid_code' => 'RFID998877'
        ]);

        // Attempt Login via Standard POST
        $response = $this->post(route('portal.login'), [
            'nis' => '998877'
        ]);

        // Assert Session
        $this->assertAuthenticatedAsSantri($member);
        
        // Assert Redirect
        $response->assertRedirect(route('portal.index'));
        $response->assertSessionHasNoErrors();
    }

    /** @test */
    public function member_can_login_with_rfid()
    {
        $member = Member::factory()->create([
            'nis' => '112233',
            'rfid_code' => 'RFID112233'
        ]);

        $response = $this->post(route('portal.login'), [
            'nis' => 'RFID112233' // Input field name is 'nis' but accepts RFID
        ]);

        $this->assertAuthenticatedAsSantri($member);
        $response->assertRedirect(route('portal.index'));
    }

    /** @test */
    public function invalid_login_returns_error()
    {
        $response = $this->post(route('portal.login'), [
            'nis' => 'INVALID000'
        ]);

        $response->assertSessionHas('error');
        $this->assertFalse(session('santri_logged_in'));
    }

    /** @test */
    public function member_can_logout()
    {
        // Login first
        $member = Member::factory()->create();
        session(['santri_logged_in' => true, 'santri_id' => $member->id]);

        $response = $this->post(route('portal.logout'));
        
        $response->assertRedirect(route('portal.index'));
        $this->assertFalse(session()->has('santri_logged_in'));
    }

    // Helper
    private function assertAuthenticatedAsSantri($member)
    {
        $this->assertTrue(session('santri_logged_in'));
        $this->assertEquals($member->id, session('santri_id'));
    }
}
