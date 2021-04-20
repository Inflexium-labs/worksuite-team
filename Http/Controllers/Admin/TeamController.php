<?php

namespace Modules\Team\Http\Controllers\Admin;

use App\User;
use App\Helper\Reply;
use Illuminate\Http\Request;
use Modules\Team\Entities\Group;
use Illuminate\Contracts\Support\Renderable;
use App\Http\Controllers\Admin\AdminBaseController;

class TeamController extends AdminBaseController
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->pageTitle = __('team::app.team');
        $this->teams = Group::all();

        return view('team::admin.team.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('team::admin.team.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'sometimes|boolean',
        ]);

        $team = Group::create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status ?? false
        ]);

        return Reply::success(__('team::app.messages.createSuccess'));
    }

    /**
     * Show the specified resource.
     * @param int Group $team
     * @return Renderable
     */
    public function show(Group $team)
    {
        $this->pageTitle = __('team::app.teamView');
        $this->team = $team;
        $this->employees = User::allEmployees()->whereNotIn('id', $team->members->pluck('id'));

        return view('team::admin.team.show', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $team
     * @return Renderable
     */
    public function edit(Group $team)
    {
        $this->team = $team;
        return view('team::admin.team.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $team
     * @return Renderable
     */
    public function update(Request $request, Group $team)
    {
        $request->validate([
            'name' => 'required|string|max:191',
            'description' => 'nullable|string'
        ]);

        $team->update($request->only('name', 'description'));

        return Reply::success(__('team::app.messages.updateSuccess'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $team
     * @return Renderable
     */
    public function destroy(Group $team)
    {
        $team->delete();
        $route = route('admin.team.index');

        return Reply::redirect($route, __('team::app.messages.deleteSuccess'));
    }

    public function statusUpdate(Group $team)
    {
        $team->update([
            'status' => request()->status == 'true' ? true : false
        ]);

        return Reply::success(__('team::app.messages.statusUpdateSuccess'));
    }

    public function addMembers(Group $team)
    {
        foreach (request()->members as $member) {
            $team->members()->attach($member);
        }

        return Reply::success(__('team::app.messages.memberAddSuccess'));
    }

    public function removeMember(Group $team)
    {
        $team->members()->detach(request()->member);
        return Reply::success(__('team::app.messages.memberRemoveSuccess'));
    }

    public function updateLeader(Group $team)
    {
        $team->update(['team_leader' => request()->leader]);
        return Reply::success(__('team::app.messages.leaderUpdateSuccess'));
    }
}
