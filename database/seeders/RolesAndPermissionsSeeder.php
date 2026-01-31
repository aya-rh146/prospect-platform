<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Créer les permissions
        $permissions = [
            'manage prospects',
            'manage videos', 
            'manage settings',
            'view logs',
            'export prospects',
            'delete prospects',
            'edit prospects',
            'create prospects',
            'delete videos',
            'edit videos',
            'create videos',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Créer les rôles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $editorRole = Role::firstOrCreate(['name' => 'editor']);

        // Assigner toutes les permissions à l'admin
        $adminRole->givePermissionTo(Permission::all());

        // Assigner permissions limitées à l'editor
        $editorRole->givePermissionTo([
            'manage prospects',
            'export prospects',
            'edit prospects',
            'manage videos',
            'edit videos',
        ]);

        // Assigner le rôle admin au premier utilisateur (s'il existe)
        $adminUser = User::first();
        if ($adminUser) {
            $adminUser->assignRole('admin');
        }

        $this->command->info('Rôles et permissions créés avec succès!');
    }
}
