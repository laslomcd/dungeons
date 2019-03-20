<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MentionUsersTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function mentioned_users_in_a_reply_are_notified()
    {
        $ryan = create('App\User', ['name' => 'Ryan McDonagh']);
        $this->signIn($ryan);

        $norah = create('App\User', ['name' => 'Norah']);
        $this->signIn($norah);

        $thread = create('App\Thread');

        $reply = make('App\Reply', [
            'body' => '@Norah look at this'
        ]);

        $this->json('post', $thread->path() .'/replies', $reply->toArray());

        $this->assertCount(1, $norah->notifications);
    }
}
