<?php

it('returns a successful response', function () {
    $response = $this->get('/api/v1/test');

    $response->assertStatus(200);
});
