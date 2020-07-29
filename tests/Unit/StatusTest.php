<?php

    use App\Models\Board;
    use Illuminate\Foundation\Testing\DatabaseMigrations;
    use Tests\TestCase;

    class StatusTest extends TestCase
    {
        use DatabaseMigrations;

        /** @test */
        function it_consists_of_tasks ()
        {
            $status = create('App\Models\Status');
            $task = create('App\Models\Task', ['status_id' => $status->id]);

            $this->assertTrue($status->tasks->contains($task));
        }

        /** @test */
        function it_belongs_to_a_board()
        {
            $status = create('App\Models\Status');

            $this->assertInstanceOf(Board::class, $status->board);
        }
    }
