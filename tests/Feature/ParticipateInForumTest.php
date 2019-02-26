<?php

namespace Tests\Feature;

use function factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Password;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function unauthenticated_users_may_not_add_replies()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $this->post('/threads/1/replies', []);
    }

    /** @test */
    function an_authenticated_user_can_participate_in_forum_threads()
    {
        $this->be($user = create('App\User'));

        $thread = create('App\Thread');

        $reply = make('App\Reply');

        $this->post($thread->path() .'/replies', $reply->toArray());

        $this->get($thread->path())
            ->assertSee($reply->body);
    }
}
