<?php

namespace Tests\Feature;

use App\Trending;
use function create;


use Illuminate\Support\Facades\Redis;
use function json_decode;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;


class TrendingThreadsTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();

        $this->trending = new Trending();

        $this->trending->reset();
    }

    /** @test */
    public function it_increments_a_thread_score_each_time_its_read()
    {
        $this->assertCount(0, $this->trending->get());

        $thread = create('App\Thread');

        $this->call('GET', $thread->path());

        $this->assertCount(1, $trending = $this->trending->get());

        $this->assertEquals($thread->title, $trending[0]->title);

    }
}
