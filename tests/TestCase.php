<?php

namespace Tests;

use Faker\Factory;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Create an url.
     *
     * @param  array  $parameters
     * @return array
     */
    public function createShortify(array $parameters = [])
    {
        $faker = Factory::create();
        $parameters = array_merge(['url' => $faker->url], $parameters);
        return $this->postJson(route('api.store'), $parameters)->json();
    }

}
