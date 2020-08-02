<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

    use App\Models\Board;
    use App\Models\Objective;
    use App\Models\Status;
    use App\Models\Task;
    use App\Models\User;
    use Faker\Generator as Faker;
    use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];
});

$factory->define(Task::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'description' => $faker->paragraph,
        'order' => $faker->numberBetween(1, 1000),
        'status_id' => function () {
            return factory(Status::class)->create()->id;
        },
    ];
});

$factory->state(Task::class, 'from_existing_statuses', function ($faker) {
    $title = $faker->sentence;

    return [
        'status_id' => function () {
            return Status::all()->random()->id;
        },
        'title' => $title,
        'description'  => $faker->paragraph,
    ];
});

$factory->define(Board::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'user_id' => function() {
        return 1;
        /*
            return factory(User::class)->create()->id;
        */
        }
    ];
});

$factory->define(Status::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'board_id' => function() {
            return factory(Board::class)->create()->id;
        },
        'color' => '#333',
    ];
});

$factory->define(Objective::class, function (Faker $faker) {
    return [
        'task_id' => function () {
            return factory(Task::class)->create()->id;
        },
        'body' => $faker->paragraph,
        'completed' => false
    ];
});
