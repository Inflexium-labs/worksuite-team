<?php

namespace Modules\Team\Observers;

use Modules\Team\Entities\Group;

class GroupObserver
{
    public function created(Group $group)
    {
        activity()->performedOn($group)->log('created');
    }

    public function updated(Group $group)
    {
         activity()->properties($group)->performedOn($group)->log('updated');
    }

    public function deleted(Group $group)
    {
         activity()->performedOn($group)->log('deleted');
    }

}
