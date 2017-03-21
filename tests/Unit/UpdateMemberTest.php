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
        $response = $this->call('POST', '/edit-member/77', $request_array);
        $this->assertDatabaseMissing(
            'members', ['name' => $request_array['name'],
            'address' => $request_array['address'],
            'age' => $request_array['age']]
        );
    }

    // Test it can edit member
    public function test_it_can_edit_member()
    {
        $request_array = [
            'name' => "HaHa",
            'address' => "Thái Thịnh",
            'age' => "20",
        ];
        $response = $this->call('POST', '/edit-member/77', $request_array);
        $this->assertEquals(200, $response->status());
        $this->assertDatabaseHas('members',
                [
                    'name' => $request_array['name'],
                    'address' => $request_array['address'],
                    'age' => $request_array['age']
                ]
        );
    }

    // Test it return fail if name is inval
    public function test_it_is_return_false_if_name_is_inval()
    {
        $request_array = [
            // 101 characters
            'name' => "01234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789",
            'address' => "address test",
            'age' => "56",
        ];
        $this->assertDatabaseMissingStatus($request_array);
    }

    // Test it return fail if name is inval
    public function test_it_is_return_false_if_address_is_inval()
    {
        $request_array = [
            'name' => "90123456789012345678901234567890123456789012345678901234567890123456789",
            'address' => "01234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678999",
            'age' => "56",
        ];
        $this->assertDatabaseMissingStatus($request_array);
    }

    // Test it return fail if name is inval
    public function test_it_is_return_false_if_age_is_inval()
    {
        $request_array = [
            'name' => "data name test",
            'address' => "data address test",
            'age' => "aksdjfks",
        ];
        $this->assertDatabaseMissingStatus($request_array);
    }
}
