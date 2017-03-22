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
        $response = $this->call('POST', '/add-member', $request_array);
        $data = json_decode($response ->getContent(), true);
        $this->assertEquals(302, $response->status());
        if ($data['status']==false) {
            $this->assertTrue(true);
        } else {
            $this->assertTrue(false);
        }
    }

    // Test add new member
    public function test_is_new_member()
    {
        $request_array = [
            'name' => "name member test 1",
            'address' => "address test 1",
            'age' => "57",
        ];
        $response = $this->call('POST', 'add-member', $request_array);
        $data = json_decode($response ->getContent(), true);
        $this->assertEquals(200, $response->status());
        if ($data['status']) {
            $this->assertTrue(true);
        } else {
            $this->assertTrue(false);
        }
    }

    //Test it is return false if name is inval
    public function test_it_is_return_false_if_name_is_inval()
    {
        $request_array = [
            'name' => "",
            'address' => "address test",
            'age' => "56",
        ];
        $this->assertFalseState($request_array);
    }

    //Test it is return false if address is inval
    public function test_it_is_return_false_if_address_is_inval()
    {
        $request_array = [
            'name' => "name member test",
            'address' => "",
            'age' => "56",
        ];
        $this->assertFalseState($request_array);
    }

    // Test it can return false if address is string or if age is numric larger 3 char
    public function test_it_is_can_return_false_if_age_is_inval()
    {
        $request_array = [
            'name' => "name member test",
            'address' => "address test",
            'age' => "ue45",
        ];
        $this->assertFalseState($request_array);
    }

}
