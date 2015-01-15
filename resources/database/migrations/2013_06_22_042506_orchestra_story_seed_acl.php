<?php

use Orchestra\Model\Role;
use Orchestra\Support\Facades\ACL;
use Orchestra\Support\Facades\Foundation;
use Illuminate\Database\Migrations\Migration;

class OrchestraStorySeedAcl extends Migration
{
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

        $acl->roles()->attach([$member->name, $admin->name]);
        $acl->actions()->attach([
            'Create Post', 'Update Post', 'Delete Post', 'Manage Post',
            'Create Page', 'Update Page', 'Delete Page', 'Manage Page',
        ]);

        $acl->allow($member->name, [
            'Create Post', 'Update Post', 'Delete Post',
            'Create Page', 'Update Page', 'Delete Page',
        ]);

        $acl->allow($admin->name, [
            'Create Post', 'Update Post', 'Delete Post', 'Manage Post',
            'Create Page', 'Update Page', 'Delete Page', 'Manage Page',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Foundation::memory()->forget('acl_orchestra/story');
    }
}
