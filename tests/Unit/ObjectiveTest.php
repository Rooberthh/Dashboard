<?php

    use Illuminate\Foundation\Testing\DatabaseMigrations;
    use Tests\TestCase;

    class ObjectiveTest extends TestCase
    {
        use DatabaseMigrations;

        /** @test */
        function it_belongs_to_a_task()
        {
            $task = create('App\Models\Task');
            $objective = create('App\Models\Objective', ['task_id' => $task->id]);

            $this->assertCount(1, $task->objectives);
            $this->assertTrue($task->objectives->contains($objective));
        }

        /** @test */
        function it_can_be_marked_as_complete ()
        {
            $objective = create('App\Models\Objective');

            $this->assertFalse($objective->completed);

            $objective->complete();

            $this->assertTrue($objective->completed);
        }

        /** @test */
        function it_can_be_marked_as_incomplete ()
        {
            $objective = create('App\Models\Objective', ['completed' => true]);

            $this->assertTrue($objective->completed);

            $objective->incomplete();

            $this->assertFalse($objective->completed);
        }
    }
