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
    // Test it can delete user with id
    public function DeleteMember()
    {
        $id = "34";
        $response = $this->call('GET', "/details-member/$id");
        $this->assertDatabaseHas('members', ['id' => "$id"]);
        $response = $this->call('POST', "/delete-member/$id");
        $this->assertDatabaseHas('members', ['id' => "$id"]);
    }
}
