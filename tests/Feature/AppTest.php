<?php

test('user register success')
    ->post('/api/register', [
        "username" => "username",
        "password" => "password",
        "name" => "John Doe",
        "email" => "johnd@gmail.com",
        "phonenumber" => "088999222555",
    ])->assertStatus(201)
    ->assertJson([
        "data" => [
            "username" => "username",
            "name" => "John Doe",
            "email" => "johnd@gmail.com",
            "phonenumber" => "088999222555",
            // "token" => getUserToken()
        ]
    ]);

test('user register failed')
    ->post('/api/register', [
        "username" => "",
        "password" => "",
        "name" => "",
        "email" => "",
        "phonenumber" => "",
    ])->assertStatus(400)
    ->assertJson([
        "errors" => [
            "username" => [
                "The username field is required."
            ],
            "password" => [
                "The password field is required."
            ],
            "name" => [
                "The name field is required."
            ],
            "email" => [
                "The email field is required."
            ],
            "phonenumber" => [
                "The phonenumber field is required."
            ],
        ]
    ]);

test('user register allready exist', function () {
    createUser();
    $this->post('/api/register', [
        "username" => "username",
        "password" => "password",
        "name" => "John Doe",
        "email" => "johnd@gmail.com",
        "phonenumber" => "088999222555",
    ])->assertStatus(400)
        ->assertJson([
            "errors" => [
                "username" => [
                    "Username allready exist"
                ]
            ]
        ]);
});

test('user login success', function () {
    createUser();
    $this->withHeaders([
        "Accept" => "application/json"
    ])
        ->post('/api/login', [
            "username" => "username",
            "password" => "password",
        ])->assertStatus(200)
        ->assertJson([
            "data" => [
                "username" => "username",
                "name" => "John Doe",
                "email" => "johnd@gmail.com",
                "phonenumber" => "088999222555",
                // "token" => getUserToken()
            ]
        ]);
});
