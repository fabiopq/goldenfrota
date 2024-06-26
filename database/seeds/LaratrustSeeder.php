<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LaratrustSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return  void
     */
    public function run()
    {
        $this->command->info('Truncating User, Role and Permission tables');
        $this->truncateLaratrustTables();

        $config = config('laratrust_seeder.role_structure');
        $userPermission = config('laratrust_seeder.permission_structure');
        $mapPermission = collect(config('laratrust_seeder.permissions_map'));

        foreach ($config as $key => $modules) {

            // Create a new role
            $role = \App\Role::updateOrCreate(
                [
                    'name' => $key
                ],
                [
                    'display_name' => ucwords(str_replace('_', ' ', $key)),
                    'description' => ucwords(str_replace('_', ' ', $key))
                ]
            );
            $permissions = [];

            $this->command->info('Creating Role '. strtoupper($key));

            // Reading role permission modules
            foreach ($modules as $module => $value) {

                foreach (explode(',', $value) as $p => $perm) {

                    $permissionValue = $mapPermission->get($perm);

                    $permissions[] = \App\Permission::firstOrCreate([
                        'name' => $permissionValue . '-' . str_replace('_', '-', $module),
                        'display_name' => ucfirst($permissionValue) . ' ' . ucfirst(str_replace('_', ' ', $module)),
                        'description' => ucfirst($permissionValue) . ' ' . ucfirst(str_replace('_', ' ', $module)),
                    ])->id;

                    $this->command->info('Creating Permission to '.$permissionValue.' for '. str_replace('_', ' ', $module));
                }
            }

            // Attach all permissions to the role
            $role->permissions()->sync($permissions);

            $this->command->info("Creating '{$key}' user");

            // Create default user for each role
            $user = \App\User::updateOrCreate(
                [
                    'username' => $key
                ],
                [
                    'name' => ucwords(str_replace('_', ' ', $key)),
                    'email' => $key.'@app.com',
                    'password' => bcrypt($key)
                ]
            );

            $user->attachRole($role);
        }

        // Creating user with permissions
        if (!empty($userPermission)) {

            foreach ($userPermission as $key => $modules) {

                foreach ($modules as $module => $value) {

                    // Create default user for each permission set
                    $user = \App\User::updateOrCreate(
                        [
                            'username' => $key
                        ],
                        [
                            'name' => ucwords(str_replace('_', ' ', $key)),
                            'email' => $key.'@app.com',
                            'password' => bcrypt($key),
                            'remember_token' => str_random(10)
                        ]
                    );
                    
                    $permissions = [];

                    foreach (explode(',', $value) as $p => $perm) {

                        $permissionValue = $mapPermission->get($perm);

                        $permissions[] = \App\Permission::firstOrCreate([
                            'name' => $permissionValue . '-' . str_replace('_', '-', $module),
                            'display_name' => ucfirst($permissionValue) . ' ' . ucfirst(str_replace('_', ' ', $module)),
                            'description' => ucfirst($permissionValue) . ' ' . ucfirst(str_replace('_', ' ', $module)),
                        ])->id;

                        $this->command->info('Creating Permission to '.$permissionValue.' for '. str_replace('_', ' ', $module));
                    }
                }

                // Attach all permissions to the user
                $user->permissions()->sync($permissions);
            }
        }
    }

    /**
     * Truncates all the laratrust tables and the users table
     *
     * 
     * @return    void
     */
    public function truncateLaratrustTables()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('permission_role')->truncate();
        DB::table('permission_user')->truncate();
        DB::table('role_user')->truncate();
        //\App\User::truncate();
        //\App\Role::truncate();
        \App\Permission::truncate();
        Schema::enableForeignKeyConstraints();
    }
}
