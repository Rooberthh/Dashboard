<?php

    use App\Models\Status;
    use App\Models\Task;
    use Illuminate\Foundation\Testing\DatabaseMigrations;
    use Tests\TestCase;

    class DeleteStatusTest extends TestCase
    {
        use DatabaseMigrations;
        /** @test */
        function a_user_can_delete_a_status ()
        {
            $status = create('App\Models\Status');

            $this->json('delete', $status->path())
                ->assertStatus(200);

            $this->assertCount(0, Status::all());
        }

        /** @test */
        function when_a_status_is_deleted_its_corresponding_tasks_are_deleted()
        {
            $status = create('App\Models\Status');
            create('App\Models\Task', ['status_id' => $status->id], 10);

            $this->assertCount(10, Task::all());

            $status->delete();

            $this->assertCount(0, Task::all());
        }

    }
