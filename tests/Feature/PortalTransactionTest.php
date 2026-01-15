<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Member;
use App\Models\Book;
use App\Models\Loan;
use App\Models\Attendance;
use App\Models\SbpRequest;
use Carbon\Carbon;

class PortalTransactionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function member_can_submit_attendance()
    {
        $member = Member::factory()->create(['rfid_code' => 'ABSEN123']);

        $response = $this->postJson(route('portal.attendance.store'), [
            'code' => 'ABSEN123'
        ]);

        $response->assertStatus(200)
                 ->assertJson(['status' => 'success']);

        $this->assertDatabaseHas('attendances', ['member_id' => $member->id]);
    }

    /** @test */
    public function member_cannot_absen_twice_same_day()
    {
        $member = Member::factory()->create(['rfid_code' => 'ABSEN123']);
        Attendance::create([
            'member_id' => $member->id, 
            'scanned_at' => now()
        ]);

        $response = $this->postJson(route('portal.attendance.store'), [
            'code' => 'ABSEN123'
        ]);

        $response->assertStatus(200)
                 ->assertJson(['status' => 'warning']);
    }

    /** @test */
    public function member_can_borrow_book()
    {
        $member = Member::factory()->create();
        $book = Book::factory()->create(['stock' => 5, 'barcode' => 'B001']);

        // Mock Login
        session(['santri_logged_in' => true, 'santri_id' => $member->id]);

        $response = $this->postJson(route('portal.loan.store'), [
            'book_code' => 'B001'
        ]);

        $response->assertStatus(200)
                 ->assertJson(['status' => 'success']);
        
        $this->assertDatabaseHas('loans', ['member_id' => $member->id, 'book_id' => $book->id, 'status' => 'active']);
        $this->assertEquals(4, $book->fresh()->stock);
    }

    /** @test */
    public function member_can_return_book()
    {
        $member = Member::factory()->create();
        $book = Book::factory()->create(['stock' => 5, 'barcode' => 'B001']);
        
        $loan = Loan::create([
            'member_id' => $member->id,
            'book_id' => $book->id,
            'borrow_date' => now()->subDays(3),
            'due_date' => now()->addDays(4),
            'status' => 'active'
        ]);

        session(['santri_logged_in' => true, 'santri_id' => $member->id]);

        $response = $this->postJson(route('portal.return.store'), [
            'book_code' => 'B001'
        ]);

        $response->assertStatus(200)
                 ->assertJson(['status' => 'success']);
        
        $this->assertEquals('returned', $loan->fresh()->status);
        $this->assertEquals(6, $book->fresh()->stock);
    }

    /** @test */
    public function member_can_request_sbp()
    {
        $member = Member::factory()->create();
        session(['santri_logged_in' => true, 'santri_id' => $member->id]);

        $response = $this->postJson(route('portal.sbp.store'));

        $response->assertStatus(200)
                 ->assertJson(['status' => 'success']);

        $this->assertDatabaseHas('sbp_requests', ['member_id' => $member->id, 'status' => 'pending']);
    }

    /** @test */
    public function cannot_request_sbp_with_active_loans()
    {
        $member = Member::factory()->create();
        $book = Book::factory()->create();
        Loan::create([
            'member_id' => $member->id,
            'book_id' => $book->id,
            'borrow_date' => now(),
            'due_date' => now()->addDays(7),
            'status' => 'active'
        ]);

        session(['santri_logged_in' => true, 'santri_id' => $member->id]);

        $response = $this->postJson(route('portal.sbp.store'));

        $response->assertStatus(400)
                 ->assertJson(['status' => 'error']);
    }
    /** @test */
    public function member_cannot_absen_for_others_while_logged_in()
    {
        $memberA = Member::factory()->create(['rfid_code' => 'RFID_A']);
        $memberB = Member::factory()->create(['rfid_code' => 'RFID_B']);

        // Login as Member A
        session(['santri_logged_in' => true, 'santri_id' => $memberA->id]);

        // Attempt scan using Member B's card
        $response = $this->postJson(route('portal.attendance.store'), [
            'code' => 'RFID_B'
        ]);

        // Expect 403 Forbidden
        $response->assertStatus(403)
                 ->assertJson(['status' => 'error']);
    }
}
