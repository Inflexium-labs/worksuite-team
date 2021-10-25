<?php

use App\Module;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTeamModuleToTheSystem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $module = Module::create(['module_name' => 'team', 'description' => 'Team is a module to manage an organization with hierarchical way.']);
        $module->permissions()->create(['name' => 'create_team', 'display_name' => 'Create Team']);
        $module->permissions()->create(['name' => 'view_team', 'display_name' => 'View Team']);
        $module->permissions()->create(['name' => 'edit_team', 'display_name' => 'Edit Team']);
        $module->permissions()->create(['name' => 'delete_team', 'display_name' => 'Delete Team']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Module::where('module_name', 'team')->first()->delete();
    }
}
