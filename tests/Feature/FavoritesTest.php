<?php

    use Illuminate\Foundation\Testing\DatabaseMigrations;
    use Tests\TestCase;

    class FavoritesTest extends TestCase
    {
        use DatabaseMigrations;

        /** @test */
        function a_user_can_favorite_a_status ()
        {
            $status = create('App\Models\Status');
            $this->json('post', "api/statuses/" . $status->id . "/favorite")
                ->assertStatus(200);

            $this->assertTrue($status->fresh()->isFavorited());
        }

        /** @test */
        function a_user_can_unfavorite_a_status ()
        {
            $status = create('App\Models\Status');

            $status->favorite();

            $this->json('delete', "api/statuses/" . $status->id . '/favorite')
                ->assertStatus(200);

            $this->assertFalse($status->fresh()->isFavorited());
        }
    }
