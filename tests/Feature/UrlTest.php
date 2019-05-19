<?php

namespace Tests\Feature;

use App\Url;

use Tests\TestCase;

class UrlTest extends TestCase
{

    /** @test */
    public function an_url_can_be_shortify()
    {
        $response = $this->createShortify();

        $this->assertNotNull($response['code']);
        $this->assertNotNull($response['hash']);
        $this->assertNotNull($response['shortify']);
    }

    /** @test */
    public function an_url_must_be_valid_on_create()
    {
        $response = $this->createShortify(['url' => 'invalid-url']);
        $this->assertArrayHasKey('url', $response['errors']);
    }

    /** @test */
    public function an_url_cant_have_blacklist()
    {
        $response = $this->createShortify(['url' => 'www.xxx.com']);
        $this->assertArrayHasKey('url', $response['errors']);
       
        $this->assertContains(
            'This url contains blacklisted keyword.',
            $response['errors']['url']
        );
    } 
}
