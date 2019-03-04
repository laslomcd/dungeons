<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 2019-03-04
 * Time: 10:35
 */

namespace App\Filters;


use Illuminate\Http\Request;
use function method_exists;

abstract class Filters
{
    protected $builder;
    protected $request;

    protected $filters = [];

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
        $this->builder = $builder;

        foreach ($this->getFilters() as $filter => $value) {
            if(method_exists($this, $filter)) {
                $this->$filter($value);
            }
        }

        return $this->builder;

    }

    public function getFilters()
    {
        return array_filter($this->request->only($this->filters));
    }
}