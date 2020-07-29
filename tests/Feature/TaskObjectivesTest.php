<?php

    use Illuminate\Foundation\Testing\DatabaseMigrations;
    use Tests\TestCase;

    class TaskObjectivesTest extends TestCase
    {
        use DatabaseMigrations;

        /** @test */
        function an_objective_can_be_added_to_a_task()
        {
            $objective = make('App\Models\Objective', ['body' => 'new objective']);
            $task = create('App\Models\Task');

            $this->json('post', "api/tasks/{$task->id}/objectives", $objective->toArray())
                ->assertStatus(201);

            $this->assertDatabaseHas('objectives', ['body' => 'new objective']);
        }

        /** @test */
        function an_objective_can_be_deleted()
        {
            $objective = create('App\Models\Objective', ['body' => 'deleted objective']);

            $this->json('delete', $objective->path())
                ->assertStatus(200);

            $this->assertDatabaseMissing('objectives', ['body' => 'deleted objective']);
        }

        /** @test */
        function an_objective_can_be_updated()
        {
            $objective = create('App\Models\Objective');

            $this->json('patch', $objective->path(), ['body' => 'updated', 'completed' => true])
                ->assertStatus(201);

            $this->assertDatabaseHas('objectives', [
                'body' => 'updated',
                'completed' => true
            ]);
        }
    }
