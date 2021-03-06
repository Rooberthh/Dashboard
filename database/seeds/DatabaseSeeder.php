<?php

    use App\Models\Status;
    use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        collect([
            [
                'name' => 'Todo',
                'color' => '#3c40c6'
            ],
            [
                'name' => 'In progress',
                'color' => '#0fbcf9'
            ],
            [
                'name' => 'Done',
                'color' => '#f53b57'
            ]
        ])->each(function ($status) {
            factory(Status::class)->create([
                'name' => $status['name'],
                'color' => $status['color']
            ]);
        });

        factory('App\Models\Task', 10)->states('from_existing_statuses')->create();
    }
}
