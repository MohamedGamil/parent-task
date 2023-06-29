<?php

namespace Tests\Feature;

use Tests\TestCase;

class ItsAliveTest extends TestCase
{
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_the_api_endpoint_correct_data(): void
    {
        $response = $this->get('/api/v1/users');

        $response->assertJsonCount(8, 'data');
    }

    public function test_the_api_endpoint_filter_provider(): void
    {
        $response = $this->get('/api/v1/users?provider=DataProviderY');

        $response->assertJsonCount(3, 'data');
    }

    public function test_the_api_endpoint_filter_status(): void
    {
        $response = $this->get('/api/v1/users?status=authorised');

        $response->assertJsonCount(4, 'data');
    }

    public function test_the_api_endpoint_filter_range(): void
    {
        $response = $this->get('/api/v1/users?balanceMin=500&balanceMax=1000');

        $response->assertJsonCount(2, 'data');
    }

    public function test_the_api_endpoint_filter_currency(): void
    {
        $response = $this->get('/api/v1/users?currency=USD');

        $response->assertJsonCount(5, 'data');
    }
}
