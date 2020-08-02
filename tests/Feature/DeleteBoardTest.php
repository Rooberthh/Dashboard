<?php

    use App\Models\Status;
    use Illuminate\Foundation\Testing\DatabaseMigrations;
    use Tests\TestCase;

    class DeleteBoardTest extends TestCase
    {
        use DatabaseMigrations;

        /*
        function a_user_can_delete_a_board ()
        {
            $this->signIn();

            $board = create('App\Models\Board', ['user_id' => auth()->id()]);

            $this->actingAs($board->owner)
                ->json('delete', $board->path())
                ->assertStatus(200);

            $this->assertDatabaseMissing('boards', $board->only('id'));
        }
        */

        /** @test */
        function when_a_board_is_deleted_its_corresponding_statuses_are_deleted()
        {
            $board = create('App\Models\Board');
            create('App\Models\Status', ['board_id' => $board->id], 10);

            $this->assertCount(10, Status::all());

            $board->delete();

            $this->assertCount(0, Status::all());
        }

    }
