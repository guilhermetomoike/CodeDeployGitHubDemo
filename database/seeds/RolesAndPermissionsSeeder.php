<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        $editar_empresa = Permission::create(['guard_name' => 'api_usuarios', 'name' => 'editar empresa']);
        $ver_empresa = Permission::create(['guard_name' => 'api_usuarios', 'name' => 'ver empresa']);
        $gerenciar_prolabore_empresa = Permission::create(['guard_name' => 'api_usuarios', 'name' => 'gerenciar prolabore empresa']);
        $anexar_guia = Permission::create(['guard_name' => 'api_usuarios', 'name' => 'anexar guia']);

        $excluirCarteira = Permission::create(['guard_name' => 'api_usuarios', 'name' => 'excluir carteira']);
        $verCarteira = Permission::create(['guard_name' => 'api_usuarios', 'name' => 'ver carteira']);
        $alterarCarteira = Permission::create(['guard_name' => 'api_usuarios', 'name' => 'alterar carteira']);
        $criarCarteira = Permission::create(['guard_name' => 'api_usuarios', 'name' => 'criar carteira']);

        $excluirUsuario = Permission::create(['guard_name' => 'api_usuarios', 'name' => 'excluir usuario']);
        $editarUsuario = Permission::create(['guard_name' => 'api_usuarios', 'name' => 'editar usuario']);
        $criarUsuario = Permission::create(['guard_name' => 'api_usuarios', 'name' => 'criar usuario']);

        Role::create(['guard_name' => 'api_usuarios', 'name' => 'Gerenciar usuários'])
            ->givePermissionTo($excluirUsuario, $editarUsuario, $criarUsuario);

        Role::create(['guard_name' => 'api_usuarios', 'name' => 'Contador'])
            ->givePermissionTo($editar_empresa, $ver_empresa, $gerenciar_prolabore_empresa, $anexar_guia);

        Role::create(['guard_name' => 'api_usuarios', 'name' => 'Gerenciar carteiras'])
            ->givePermissionTo($excluirCarteira, $verCarteira, $alterarCarteira, $criarCarteira);

        // or may be done by chaining
        Role::create(['guard_name' => 'api_usuarios', 'name' => 'Recursos Humanos'])
            ->givePermissionTo($anexar_guia, $ver_empresa);

        $role = Role::create(['guard_name' => 'api_usuarios', 'name' => 'super-admin']);
        $role->givePermissionTo(Permission::all());
        $user = \App\Models\Usuario::find(99);
        $user->assignRole('super-admin');
    }
}
