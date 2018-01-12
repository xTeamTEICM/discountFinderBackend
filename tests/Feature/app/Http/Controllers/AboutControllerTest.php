<?php

namespace Tests\Feature;

use Tests\TestCase;

class AboutControllerTest extends TestCase
{
    public function testAboutSuccess()
    {
        $response = $this->json('GET', 'api/about', [], []);
        $response->assertStatus(200);
    }
}
