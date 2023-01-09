<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Like::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(\App\User::class)->create()->id;
        },
        'status_id' => function () {
            return factory(\App\Models\Status::class)->create()->id;
        }
    ];
});
