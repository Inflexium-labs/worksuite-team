<?php

namespace Modules\Team\Observers;

use Modules\Team\Entities\GroupUser;

class GroupUserObserver
{
    public function created(GroupUser $groupUser)
    {
        activity()->eventName('created')->properties($groupUser)->performedOn($groupUser)->log('user created in a group');
    }

    public function deleted(GroupUser $groupUser)
    {
         activity()->eventName('deleted')->performedOn($groupUser)->log('user delete in a group');
    }

}
