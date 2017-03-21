<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DeleteMemberTest extends TestCase
{
    /**
     * Test it can delte member.
     * @test
     * @return void
     */
    // Test it can delete member
    public function test_it_can_delete_member_with_memberID()
    {
        $id = "77";
        $response = $this->call('GET', "/details-member/$id");
        $this->assertDatabaseHas('members', ['id' => "$id"]);
        $response = $this->call('POST', "/delete-member", ['id' => "$id"]);
        $this->assertDatabaseMissing('members', ['id' => "$id"]);
    }
}
