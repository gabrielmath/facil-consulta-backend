<?php

it('should access test endpoint', function () {
    $this->get('/api/v1/test')
        ->assertStatus(200);
});
