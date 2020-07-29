<?php

    use Illuminate\Foundation\Testing\DatabaseMigrations;
    use Tests\TestCase;

    class CreateStatusTest extends TestCase
    {
        use DatabaseMigrations;

        /** @test */
        function a_user_can_create_a_status ()
        {
            $board = create('App\Models\Board');

            $status = make('App\Models\Status', ['board_id' => $board->id]);

            $this->json('post', $board->path() . '/statuses', $status->toArray())
                ->assertStatus(200);

            $this->assertDatabaseHas('statuses', $status->toArray());
        }

    }
