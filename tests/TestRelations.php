<?php

namespace DynamicAclTest;

use DynamicAcl\ACL;
use DynamicAcl\Models\Role;
use DynamicAcl\Route;
use DynamicAclTest\Dependencies\User;

class TestRelations extends TestCase
{
	public function test_user_roles_relation()
	{
		$role = Role::create([
			'name' => 'super_admin',
			'permissions' => ['fullAccess' => 1]
		]);

		$this->admin->roles()->sync($role->id);

		$this->assertInstanceOf(Role::class, $this->admin->roles()->first());
	}

	public function test_role_users_relation()
	{
		
		$role = Role::create([
			'name' => 'super_admin',
			'permissions' => ['fullAccess' => 1]
		]);

		$this->admin->roles()->sync($role->id);
		
		$this->assertInstanceOf(User::class, $role->users()->first());
	}
}
