<?php

    use Illuminate\Foundation\Testing\DatabaseMigrations;
    use Tests\TestCase;

    class UpdateBoardTest extends TestCase
    {
        use DatabaseMigrations;

        /** @test */
        function a_user_can_update_a_board ()
        {
            $board = create('App\Models\Board');

            $this->json('patch', $board->path(), ['name' => 'is changed', 'user_id' => 1])
                ->assertStatus(200);

            $this->assertEquals('is changed', $board->fresh()->name);
        }

        /** @test */
        function a_unauthenticated_user_cant_update_a_board ()
        {
            $board = create('App\Models\Board', ['user_id' => 2]);

            $this->json('patch', $board->path(), ['name' => 'is changed', 'user_id' => 1])
                ->assertStatus(403);
        }

    }
