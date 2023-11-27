<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $organizador= Role::create(['name'=>'Organizador']);
        $fotografo= Role::create(['name'=>'Fotografo']);
        $invitado= Role::create(['name'=>'Cliente']);

        Permission::create(['name'=>'Organizador'])->syncRoles($organizador);
        Permission::create(['name'=>'Fotografo'])->syncRoles($fotografo);
        Permission::create(['name'=>'Cliente'])->syncRoles($invitado,$organizador,$fotografo);
    }
}
