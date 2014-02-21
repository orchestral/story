<?php

use Illuminate\Database\Migrations\Migration;

use Orchestra\Support\Facades\Acl;
use Orchestra\Support\Facades\App;
use Orchestra\Model\Role;

class OrchestraStorySeedNavAcl extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$admin  = Role::admin();
        $member = Role::member();
        $acl    = Acl::make('orchestra/story');

        $acl->roles()->attach(array($member->name, $admin->name));
        $acl->actions()->attach(array(
            'Create Navigation', 'Update Navigation', 'Delete Navigation', 'Manage Navigation',
        ));

        $acl->allow($member->name, array(
            'Create Navigation', 'Update Navigation', 'Delete Navigation',
        ));

        $acl->allow($admin->name, array(
            'Create Navigation', 'Update Navigation', 'Delete Navigation', 'Manage Navigation',
        ));
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		App::memory()->forget('acl_orchestra/story');
	}

}
