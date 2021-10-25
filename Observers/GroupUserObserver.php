<?php

namespace Modules\Team\Observers;

use Modules\Team\Entities\GroupUser;

class GroupUserObserver
{
    public function created(GroupUser $groupUser)
    {
        activity()->properties($groupUser)->performedOn($groupUser)->log('user modify in a group');
    }

    public function deleted(GroupUser $groupUser)
    {
         activity()->performedOn($groupUser)->log('user delete in a group');
    }

}
