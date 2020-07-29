<?php

    use App\Models\Objective;
    use Illuminate\Foundation\Testing\DatabaseMigrations;
    use Tests\TestCase;

    class CreateTaskTest extends TestCase
    {
        use DatabaseMigrations;

        /** @test */
        function a_user_can_create_a_task ()
        {
            $status = create('App\Models\Status');
            $task = make('App\Models\Task', ['status_id' => $status->id]);

            $this->json('post', "api/statuses/{$status->id}/tasks", $task->toArray())
                ->assertStatus(200);

            $this->assertDatabaseHas('tasks', $task->toArray());
        }

        /** @test */
        function a_user_can_delete_a_task()
        {
            $task = create('App\Models\Task');

            $this->json('delete', $task->path())
                ->assertStatus(200);

            // $this->notSeeInDatabase('tasks', $task->toArray());
        }

        /** @test */
        function when_a_task_is_deleted_its_corresponding_objectives_are_deleted()
        {
            $task = create('App\Models\Task');
            create('App\Models\Objective', ['task_id' => $task->id], 10);

            $this->assertCount(10, Objective::all());
            $task->delete();
            $this->assertCount(0, Objective::all());
        }
    }
