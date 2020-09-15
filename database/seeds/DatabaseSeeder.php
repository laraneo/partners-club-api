<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        /* Master Tables */
        $this->call(RelationTypesSeeder::class);
        $this->call(PaymentMethodsSeeder::class);
        $this->call(CardTypesSeeder::class);
        $this->call(BanksTableSeeder::class);
        $this->call(CountryTableSeeder::class);
        $this->call(StatusPeopleTableSeeder::class);
        $this->call(MaritalStatusTableSeeder::class);
        $this->call(GenderTableSeeder::class);
        $this->call(ProfessionTableSeeder::class);
        $this->call(CurrenciesTableSeeder::class);
        $this->call(SportsTableSeeder::class);
        $this->call(ShareTypeSeeder::class);
        $this->call(LocationSeeder::class);
        $this->call(TransactionTypesSeeder::class);
        $this->call(PermissionsSeeder::class);
        $this->call(RolesSeeder::class);
        $this->call(LockersLocationSeeder::class);
        $this->call(RecordTypeSeeder::class);
        $this->call(DepartmentSeeder::class);
        /***/

        $this->call(PersonTableSeeder::class);
        $this->call(RolePermissionsSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(SharesSeeder::class);
        $this->call(LockerSeeder::class);
        $this->call(MenuTableSeeder::class);
    }
}
