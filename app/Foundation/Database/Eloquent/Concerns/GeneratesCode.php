<?php

namespace App\Foundation\Database\Eloquent\Concerns;

trait GeneratesCode
{
    /**
     * Register trait events
     */
    protected static function bootGeneratesCode()
    {
        static::creating(function ($model) {

            if ($model->hasCode()) {
                return true;
            }

            $model->setAttribute(
                $model->getCodeColumnName(),
                static::newCode()
            );
        });
    }

    /**
     * Get the code column name or it's default
     *
     * @return string
     */
    public function getCodeColumnName(): string
    {
        return method_exists($this, 'codeColumn') ? $this->codeColumn() : 'code';
    }

    /**
     * Return true/flase if the current model has a code
     *
     * @return boolean
     */
    public function hasCode(): bool
    {
        return !! $this->{$this->getCodeColumnName()};
    }

    /**
     *  Clean the code from the object and return the instace
     */
    public function clearCode()
    {
        $this->{$this->getCodeColumnName()} = null;

        return $this;
    }

    /**
     * Verify if the given code exists on the db
     *
     * @param string $code
     * @return boolean
     */
    public static function codeExists(string $code): bool
    {
        $model = (new static);

        return $model->query()->where($model->getCodeColumnName(), $code)
            ->when($model->usesSoftDeletes(), function ($query) {
                return $query->withTrashed();
            })
            ->exists();
    }

    /**
     * Generates a new code that doesn't exists on the db
     *
     * @return string
     */
    public static function newCode(): string
    {
        do {
            $exists = false;
            $code = code(); // helper function
            $exists = static::codeExists($code);
        } while ($exists);

        return $code;
    }

    /**
     * Return the name of the column to be used on the code generation
     *
     * @return string
     */
    // abstract public function codeColumn(): string;
}