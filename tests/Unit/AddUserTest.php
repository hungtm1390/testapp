<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AddUserTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

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
}
