<?php

namespace Modules\Team\Entities;

use App\User as BaseUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Froiden\RestAPI\ExtendedRelations\BelongsToMany;

class User extends BaseUser
{
    /**
     * The groups that belong to the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_users', 'user_id', 'group_id')->active();
    }
    
    /**
     * Get the myTeam associated with the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function myTeams(): HasMany
    {
        return $this->hasMany(Group::class, 'team_leader', 'id')->active();
    }
}
