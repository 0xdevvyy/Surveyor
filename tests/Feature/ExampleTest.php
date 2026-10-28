<?php

test('redirects the home page to login', function (): void {
    $response = $this->get(route('home'));

    $response->assertRedirectToRoute('index.auth');
});
