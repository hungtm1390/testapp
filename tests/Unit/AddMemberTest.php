<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AddMemberTest extends TestCase
{
    /**
     * A basic test example.
     * @test
     * @return void
     */
    protected function assertFalseState($request_array) {
        $response = $this->call('POST', '/list-members', $request_array);
        $data = json_decode($response ->getContent(), true);
        $this->assertEquals(405, $response->status());
        if ($data['status']==false) {
            $this->assertTrue(true);
        } else {
            $this->assertTrue(false);
        }
    }
    // Test add new member
    public function is_new_member()
    {
        $request_array = [
            'name' => "name member test",
            'address' => "address test",
            'age' => "56",
        ];
        $response = $this->call('POST', 'list-members', $request_array);
        $data = json_decode($response ->getContent(), true);
        $this->assertEquals(200, $response->status());
        if ($data['status']) {
            $this->assertTrue(true);
        } else {
            $this->assertTrue(false);
        }
    }

    // Test validate name input is larger than 100 characters
    public function testValidateName()
    {
        $request_array = [
            // 101 characters
            'name' => "01234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890",
            'address' => "address test",
            'age' => "56",
        ];
        $this->assertFalseState($request_array);
    }

    // Test it can returns false if name input is null
    public function isNameEmpty()
    {
        $request_array = [
            'name' => "",
            'address' => "address test",
            'age' => "56",
        ];
        $this->assertFalseState($request_array);
    }

    // Test validate name input is large 100 characters
    public function testValidateAddress()
    {
        $request_array = [
            'name' => "name member test",
            'address' => "0123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890",
            'age' => "56",
        ];
        $this->assertFalseState($request_array);
    }

    // Test it can returns false if address input is blank
    public function isAddressEmpty()
    {
        $request_array = [
            'name' => "name member test",
            'address' => "",
            'age' => "56",
        ];
        $this->assertFalseState($request_array);
    }
}
