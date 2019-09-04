<?php
// require_once 'PHPUNIT/TestCase.php';
// namespace Tests\Feature;
// require './vendor/autoload.php';
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HelloWorldTest extends TestCase
{
    /**
     * 
     *
     * @return void
     */
    public function test_when_client_send_a_request_a_hello_world_is_responded()
    {
        $response = $this->call('GET','/products');

        // $response->assertStatus(200);
        $this->assertEquals(200, $response->status());
        $this->assertEquals('"Hello world"', $response->content());
        # We receive the texts "Hello World!" inside the response
        // $response->assertSeeText('Hello World!');
    }
}