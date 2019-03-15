<?php

namespace App;

class Spam
{
    /**
     * @param $body
     * @return bool
     * @throws \Exception
     */
    public function detect($body)
    {
        $this->detectInvalidKeywords($body);

        return false;
    }

    protected function detectInvalidKeywords($body)
    {
        $invalidKeywords = [
            'yahoo customer support'
        ];

        foreach ($invalidKeywords as $keyword) {
            if (stripos($body, $keyword) !== false) {
                throw new \Exception('Your reply contains spam');
            }
        }
    }
}