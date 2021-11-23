<?php

namespace Modules\Team\Entities;

use App\User;
use App\Scopes\CompanyScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Team\Observers\GroupObserver;

class Group extends Model
{
    protected $fillable = [
        'name',
        'description',
        'status',
        'team_leader'
    ];

    public $dates = [
        'created_at',
        'updated_at'
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new CompanyScope);

        self::creating(function ($model) {
            if (company()) {
                $model->company_id = company()->id;
            }
        });

        static::observe(GroupObserver::class);


        // static::addGlobalScope('active', function (Builder $builder) {
        //     $builder->where('groups.status', 1);
        // });
    }

    public function scopeActive(Builder $builder)
    {
        return $builder->where('groups.status', 1);
    }

    /**
     * The members that belong to the Group
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'group_users', 'group_id', 'user_id')
            ->using(GroupUser::class)
            ->withPivot('id');
    }

    /**
     * Get the leader that owns the Group
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function leader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'team_leader', 'id');
    }

    /**
     * The leaders that belong to the Group
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function leaders(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'group_leaders');
    }
}
