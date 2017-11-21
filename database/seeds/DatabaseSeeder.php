<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
          $this->call(moduleTableSeeder::class);
          $this->call(syncsTableSeeder::class);
          $this->call(StatusTableSeeder::class);
          $this->call(RoleTableSeeder::class);
          $this->call(UsersTableSeeder::class);
          $this->call(PermissionTableSeeder::class);
          $this->call(ConfigTableSeeder::class);
          $this->call(CoreSettingsTableSeeder::class);
          $this->call(CardTableSeeder::class);
          $this->call(OrderTypeTableSeeder::class);
          $this->call(ContinentTableSeeder::class);
          $this->call(ApiKeyTableSeeder::class);
    }
}
