<?php

namespace App\Foundation\Database\Eloquent\Concerns;

trait GeneratesHash
{
    /**
     * Register trait events
     */
    protected static function bootGeneratesHash()
    {
        static::creating(function ($model) {

            if ($model->hasHash()) {
                return true;
            }

            $model->setAttribute(
                $model->getHashColumnName(),
                static::newHash()
            );
        });
    }

    /**
     * Get the hash column name or it's default
     *
     * @return string
     */
    public function getHashColumnName(): string
    {
        return method_exists($this, 'hashColumn') ? $this->hashColumn() : 'hash';
    }

    /**
     * Return true/flase if the current model has a hash
     *
     * @return boolean
     */
    public function hasHash(): bool
    {
        return !! $this->{$this->getHashColumnName()};
    }

    /**
     *  Clean the hash from the object and return the instace
     */
    public function clearHash()
    {
        $this->{$this->getHashColumnName()} = null;

        return $this;
    }

    /**
     * Verify if the given hash exists on the db
     *
     * @param string $hash
     * @return boolean
     */
    public static function hashExists(string $hash): bool
    {
        $model = (new static);

        return $model->query()->where($model->getHashColumnName(), $hash)
            ->when($model->usesSoftDeletes(), function ($query) {
                return $query->withTrashed();
            })
            ->exists();
    }

    /**
     * Generates a new hash that doesn't exists on the db
     *
     * @return string
     */
    public static function newHash(): string
    {
        $length = 2;
        $characters = str_repeat('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789', $length); 
        do {
            $length++;
            $exists = false;
            $hash = substr(str_shuffle($characters), 0, $length);
            $exists = static::hashExists($hash);
        } while ($exists);

        return $hash;
    }

    /**
     * Return the name of the column to be used on the hash generation
     *
     * @return string
     */
    // abstract public function hashColumn(): string;
}