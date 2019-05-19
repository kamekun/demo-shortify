<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Foundation\Database\Eloquent\Model;
use App\Foundation\Database\Eloquent\Concerns\GeneratesCode;
use App\Foundation\Database\Eloquent\Concerns\GeneratesHash;

class Url extends Model
{
    use SoftDeletes, GeneratesCode, GeneratesHash;

    protected $guarded = [];

    protected $appends = array('shortify');

    protected $hidden   = array('id','created_at', 'updated_at', 'deleted_at');


    /**
     * Shortify attribute function
     *
     * @return string
     */
    public function getShortifyAttribute(): string
    {
        return config('app.url') . '/' . $this->hash;
    }

    /**
     * Requester can manage the model
     *
     * @param string $code
     * @return boolean
     */
    public function canManage(string $code): bool
    {
        return ($this->code == $code);
    }

    /**
     * Requester can view the model
     *
     * @param string $code
     * @return boolean
     */
    public function canView(array $code): bool
    {
        return true;
    }    
}