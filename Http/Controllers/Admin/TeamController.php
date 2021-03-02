<?php

namespace Modules\Team\Http\Controllers\Admin;

use App\Helper\Reply;
use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use App\Http\Controllers\Admin\AdminBaseController;
use Modules\Team\Entities\Group;

class TeamController extends AdminBaseController
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->pageTitle = 'Team';
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
            // 'fa_icon' => 'required|string|max:20',
            'description' => 'nullable|string',
            'status' => 'sometimes|boolean',
        ]);

        $team = Group::create([
            'name' => $request->name,
            // 'fa_icon' => $request->fa_icon,
            'description' => $request->description,
            'status' => $request->status ?? false
        ]);

        return Reply::success('Team created successfully');
    }

    /**
     * Show the specified resource.
     * @param int Group $team
     * @return Renderable
     */
    public function show(Group $team)
    {
        $this->pageTitle = 'Team View';
        $this->team = $team;

        return view('team::admin.team.show', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('team::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
