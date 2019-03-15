<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Inspections\Spam;



class SpamTest extends TestCase
{
    /** @test
     * @throws \Exception
     */
    public function it_checks_for_invalid_keywords()
    {
        $spam = new Spam();

        $this->assertFalse($spam->detect('Innocent reply here'));

        $this->expectException('Exception');

        $spam->detect('yahoo customer support');

    }

    /** @test
     * @throws \Exception
     */
    function it_checks_for_any_key_being_held_down()
    {
        $spam = new Spam();

        $this->expectException('Exception');

        $spam->detect('Hello World aaaaaaaaaaaa');



    }
}
