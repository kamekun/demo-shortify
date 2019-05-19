<?php
namespace App\Foundation\Database\Eloquent;

use App\Foundation\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model as BaseModel;

abstract class Model extends BaseModel
{
    /**
     * Create a new Eloquent Collection instance.
     *
     * @param  array  $models
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function newCollection(array $models = [])
    {
        return new Collection($models);
    }

    /**
     * Determine if the model uses the SoftDeletes trait
     *
     * @return boolean
     */
    public function usesSoftDeletes(): bool
    {
        return in_array(Illuminate\Database\Eloquent\SoftDeletes::class, class_uses($this));
    }
}