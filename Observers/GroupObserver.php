<?php

namespace Modules\Team\Observers;

use Modules\Team\Entities\Group;

class GroupObserver
{
    public function created(Group $group)
    {
        activity()->eventName('created')->performedOn($group)->log('created');
    }

    public function updated(Group $group)
    {
         activity()->eventName('updated')->properties($group)->performedOn($group)->log('updated');
    }

    public function deleted(Group $group)
    {
         activity()->eventName('deleted')->performedOn($group)->log('deleted');
    }

}
