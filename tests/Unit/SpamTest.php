<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Spam;
use Illuminate\Foundation\Testing\DatabaseMigrations;


class SpamTest extends TestCase
{
    /** @test */
    public function it_validates_spam()
    {
        $spam = new Spam();

        $this->assertFalse($spam->detect('Innocent reply here'));
    }
}
