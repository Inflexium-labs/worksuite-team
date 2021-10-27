<?php

namespace Modules\Team\Entities;

use App\User;
use Illuminate\Database\Eloquent\Relations\MorphPivot;
use Modules\Team\Observers\GroupUserObserver;

class GroupUser extends MorphPivot
{
    protected $fillable = [
        'group_id',
        'user_id'
    ];

    protected static function boot()
    {
        parent::boot();
        static::observe(GroupUserObserver::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
