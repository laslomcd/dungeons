<?php

namespace App;

use App\User;
use Request;

class ThreadFilters
{

    /**
     * ThreadFilters constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param $builder
     * @return mixed
     */
    public function apply($builder)
    {
        if (!$username = $this->request->by) return $builder;

        $user = User::where('name', $username)->firstOrFail();

        return $builder->where('user_id', $user->id);

    }


}