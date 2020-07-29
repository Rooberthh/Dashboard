<?php

    use Illuminate\Foundation\Testing\DatabaseMigrations;
    use Tests\TestCase;

    class UpdateStatusTest extends TestCase
    {
        use DatabaseMigrations;

        /** @test */
        function a_user_can_update_a_status()
        {
            $status = create('App\Models\Status');

            $this->json('patch', $status->path(), ['name' => 'is changed', 'color' => $status->color])
                ->assertStatus(200);

            $this->assertEquals('is changed', $status->fresh()->name);
        }

        /** @test */
        function a_user_can_update_the_order_of_a_status()
        {
            $status = create('App\Models\Status', ['order' => 100]);

            $this->json('patch', $status->path(), ['order' => 1, 'name' => "hello", "color" => "#111222"])
                ->assertStatus(200);

            $this->assertEquals(1, $status->fresh()->order);
        }

    }
