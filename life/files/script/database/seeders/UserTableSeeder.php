<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $super = User::create([
            'role_id'  => 1,
            'name'     => 'Admin',
            'email'    => 'admin@admin.com',
            'password' => Hash::make('rootadmin'),
        ]);

        $roleSuperAdmin = Role::create(['name' => 'superadmin']);
        //create permission
        $permissions = [
            [
                'group_name'  => 'dashboard',
                'permissions' => [
                    'dashboard.index',
                ],
            ],

            [
                'group_name'  => 'admin',
                'permissions' => [
                    'admin.create',
                    'admin.edit',
                    'admin.update',
                    'admin.delete',
                    'admin.list',
                ],
            ],
            [
                'group_name'  => 'role',
                'permissions' => [
                    'role.create',
                    'role.edit',
                    'role.update',
                    'role.delete',
                    'role.list',

                ],
            ],
            [
                'group_name'  => 'page',
                'permissions' => [
                    'page.create',
                    'page.edit',
                    'page.delete',
                    'page.index',

                ],
            ],
            [
                'group_name'  => 'Blog',
                'permissions' => [
                    'blog.create',
                    'blog.edit',
                    'blog.delete',
                    'blog.index',
                ],
            ],

            [
                'group_name'  => 'plan',
                'permissions' => [
                    'plan.create',
                    'plan.edit',
                    'plan.index',
                    'plan.delete',
                ],
            ],
            [
                'group_name'  => 'currency',
                'permissions' => [
                    'currency.create',
                    'currency.edit',
                    'currency.index',
                    'currency.delete',
                ],
            ],
            [
                'group_name'  => 'payment-gateway',
                'permissions' => [
                    'payment-gateway.edit',
                    'payment-gateway.index',
                    'payment-gateway.delete',
                    'payment-gateway.create'
                ],
            ],
            [
                'group_name'  => 'support',
                'permissions' => [
                    'support',
                ],
            ],
            [
                'group_name'  => 'gateway-section',
                'permissions' => [
                    'gateway-section',
                ],
            ],
            [
                'group_name'  => 'hero-section',
                'permissions' => [
                    'hero-section',
                ],
            ],

            [
                'group_name'  => 'Settings',
                'permissions' => [
                    'system.settings',
                    'seo.settings',
                    'menu',
                ],
            ],

            [
                'group_name'  => 'users',
                'permissions' => [
                    'user.create',
                    'user.index',
                    'user.delete',
                    'user.edit',
                    'user.verified',
                    'user.show',
                    'user.banned',
                    'user.unverified',
                    'user.mail',
                    'user.invoice',
                ],
            ],

            [
                'group_name'  => 'language',
                'permissions' => [
                    'service.index',
                    'service.edit',
                    'service.create',
                    'service.delete',
                ],
            ],
            [
                'group_name'  => 'quick-start',
                'permissions' => [
                    'quick-start.index',
                ],
            ],
            [
                'group_name'  => 'Service',
                'permissions' => [
                    'language.index',
                    'language.edit',
                    'language.create',
                    'language.delete',
                ],
            ],
            [
                'group_name'  => 'info',
                'permissions' => [
                    'info.index',
                ],
            ],

            [
                'group_name'  => 'merchant',
                'permissions' => [
                    'merchant.index',
                    'merchant.edit',
                    'merchant.create',
                    'merchant.delete',
                    'merchant.mail',
                ],
            ],

            [
                'group_name'  => 'order',
                'permissions' => [
                    'order.index',
                    'order.edit',
                    'order.create',
                    'order.delete',
                ],
            ],

            [
                'group_name'  => 'report',
                'permissions' => [
                    'report',
                    'user-plan-report',
                    'payment-report',
                ],
            ],

            [
                'group_name'  => 'transaction',
                'permissions' => [
                    'transaction',
                ],
            ],
            [
                'group_name'  => 'profile',
                'permissions' => [
                    'profile.index',
                    'profile.create',
                ],
            ],

            [
                'group_name'  => 'option',
                'permissions' => [
                    'option',
                ],
            ],
        ];

        //assign permission

        foreach ($permissions as $key => $row) {
            foreach ($row['permissions'] as $per) {
                $permission = Permission::create(['name' => $per, 'group_name' => $row['group_name']]);
                $roleSuperAdmin->givePermissionTo($permission);
                $permission->assignRole($roleSuperAdmin);
                $super->assignRole($roleSuperAdmin);
            }
        }

    }
}
