<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RouteMemberTest extends TestCase
{
    /**
     * A basic test example.
     * @test
     * @return void
     */

    // Test route index page
    public function indexPage() {
        $response = $this->get('/');
        $response->assertStatus(200);
    }
    // Test route index api
    public function indexAPI() {
        $response = $this->get('/list-members');
        $response->assertStatus(200);
    }
}
