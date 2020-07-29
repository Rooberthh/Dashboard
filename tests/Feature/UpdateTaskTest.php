<?php

    use Illuminate\Foundation\Testing\DatabaseMigrations;
    use Tests\TestCase;

    class UpdateTaskTest extends TestCase
    {
        use DatabaseMigrations;

        /** @test */
        function a_user_can_update_a_task ()
        {
            $task = create('App\Models\Task');

            $this->json('patch', $task->path(), [
                'title' => 'is changed',
                'status_id' => $task->status->id
                ])
                ->assertStatus(200);

            $this->assertEquals('is changed', $task->fresh()->title);
        }

        /** @test */
        function a_user_can_update_the_order_of_a_task ()
        {
            $task = create('App\Models\Task');

            $this->json('patch', $task->path(), [
                'title' => 'is changed',
                'status_id' => $task->status->id,
                'order' => 1
            ])
                ->assertStatus(200);

            $this->assertEquals(1, $task->fresh()->order);

            $this->json('patch', $task->path(), [
                'title' => 'is changed',
                'status_id' => $task->status->id,
            ])
                ->assertStatus(200);

            $this->assertEquals(1, $task->fresh()->order);
        }
    }
