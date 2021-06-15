<?php

use Modules\Team\Entities\User;
use Nwidart\Modules\Facades\Module;

function teamExists()
{
    return Module::has('Team');
}

if (!function_exists('myTeam')) {
    function myTeam()
    {
        if (teamExists()) {
            $teams = User::find(auth()->id())->myTeams()->with('members')->get();

            if ($teams->count() > 0)
                return $teams;

            return null;
        }
        return null;
    }
}

if (!function_exists('myTeamMembers')) {
    function myTeamMembers($id_requested = null)
    {
        if (myTeam()) {
            $teams = User::find(auth()->id())->myTeams()->with('members')->get();

            $members = [];
            $ids = [];
            if ($teams->count() > 0) {
                foreach ($teams as $team) {
                    foreach ($team->members as $member) {
                        $members[] = $member;
                        $ids[] = $member->id;
                    }
                }
            }

            if ($id_requested == 'id')
                return $ids;

            return $members;
        }
        return [];
    }
}
