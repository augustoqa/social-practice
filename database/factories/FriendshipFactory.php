<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Friendship::class, function (Faker $faker) {
    return [
        'recipient_id' => function () {
            return factory(\App\User::class)->create();
        },
        'sender_id' => function () {
            return factory(\App\User::class)->create();
        },
    ];
});
