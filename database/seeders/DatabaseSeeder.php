<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use Faker\Factory as Faker;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 50) as $index) {
        Product::create([
            'name' => $faker->word,
            'description' => $faker->paragraph,
            'price' => $faker->randomFloat(2, 1, 100),
            'quantity' => $faker->numberBetween(1, 100)
        ]);
         }

            Role::create(['name' => 'admin']);
            Role::create(['name' => 'user']);

            Permission::create(['name' => 'view products']);
            Permission::create(['name' => 'edit products']);
            Permission::create(['name' => 'delete products']);
            Permission::create(['name' => 'create products']);

            $admin = Role::findByName('admin');
            $admin->givePermissionTo(['view products', 'edit products', 'delete products', 'create products']);

            $adminUser = User::create([
            'name' => 'Daversitie',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin123'),
            ]);
            $adminUser->assignRole('admin');

            $limitedUser = User::create([
                'name' => 'Limited',
                'email' => 'limited@limited.com',
                'password' => Hash::make('limited123'),
                ]);
            $limitedUser->assignRole('admin');
    }
}
