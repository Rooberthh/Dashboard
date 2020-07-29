<?php

    use Illuminate\Foundation\Testing\DatabaseMigrations;
    use Tests\TestCase;

    class CreateBoardsTest extends TestCase
    {
        use DatabaseMigrations;

        /** @test */
        function a_user_can_create_a_board ()
        {
            $board = make('App\Models\Board');

            $this->json('post', $board->path(), $board->toArray())
                ->assertStatus(200);

            $this->assertDatabaseHas('boards', $board->toArray());
        }

    }
