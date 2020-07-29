<?php

    use Illuminate\Foundation\Testing\DatabaseMigrations;
    use Tests\TestCase;

    class BoardTest extends TestCase
    {
        use DatabaseMigrations;

        /** @test */
        function it_consists_of_statuses ()
        {
            $board = create('App\Models\Board');
            $status = create('App\Models\Status', ['board_id' => $board->id]);

            $this->assertTrue($board->statuses->contains($status));
        }

    }
