<?php

namespace Tests\Feature\Middleware;

use Tests\TestCase;

class LocaleMiddlewareTest extends TestCase
{
    public function test_default_locale()
    {
        $response = $this->get('/');
        $response->assertSee('Current locale: ar');
    }

    public function test_ar_locale()
    {
        $response = $this->get('/en');
        $response->assertSee('Current locale: en');
    }

    public function test_en_about()
    {
        $response = $this->get('/en');
        $response->assertSee('Current locale: en');
    }

    public function test_no_prefix_about()
    {
        $response =  $this->get('/');
        $response->assertSee('Current locale: ar');
    }

    public function test_ar_about()
    {
        $response = $this->get('/ar');
        $response->assertSee('Current locale: ar');
    }

    public function test_session_locale()
    {
        $this->withSession(['locale' => 'en']);
        $response = $this->get('/');
        $response->assertSee('Current locale: en');
    }
}
