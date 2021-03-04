<?php

namespace Modules\Team\Entities;

use App\User;
use App\Scopes\CompanyScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Group extends Model
{
    protected $fillable = [
        'name',
        'description',
        'status',
        // 'fa_icon'
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
    }

    /**
     * The members that belong to the Group
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'group_users', 'group_id', 'user_id');
    }
}
