<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UpdateMemberTest extends TestCase
{
    /**
     * A basic test example.
     * @test
     * @return void
     */
    protected function assertDatabaseMissingStatus($request_array) {
        $response = $this->call('POST', '/edit-member/37', $request_array);
        $this->assertDatabaseMissing('users',
            ['name' => $request_array['name'], 'address' => $request_array['address'], 'age' => $request_array['age']]);
    }

    // Test it can edit member's info
    public function isEditMember()
    {
        $request_array = [
            'name' => "HaHa",
            'address' => "Thái Thịnh",
            'age' => "200",
        ];
        $response = $this->call('POST', '/edit-member/57', $request_array);
        $this->assertEquals(200, $response->status());
        $this->assertDatabaseHas('users',
            ['name' => $request_array['name'], 'address' => $request_array['address'], 'age' => $request_array['age']]);
    }

    // // Test it return fail with too long name
    public function isValidateName()
    {
        $request_array = [
            // 101 characters
            'name' => "01234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890",
            'address' => "address test",
            'age' => "56",
        ];
        $this->assertDatabaseMissingStatus($request_array);
    }



    // // Test it return false with blank name field
    public function isNameEmpty()
    {
        $request_array = [
            'name' => "",
            'address' => "address test",
            'age' => "56"
        ];
        $this->assertDatabaseMissingStatus($request_array);
    }


    // // Test it return fail with blank address field
    public function isAddressEmpty()
    {
        $request_array = [
            'name' => "name member test",
            'address' => "",
            'age' => "12",
        ];
        $this->assertDatabaseMissingStatus($request_array);
    }

    // // Test it return fails with blank age field
    public function isAgeEmpty()
    {
        $request_array = [
            'name' => "name member test",
            'address' => "address test",
            'age' => "",
        ];
        $this->assertDatabaseMissingStatus($request_array);
    }
}
