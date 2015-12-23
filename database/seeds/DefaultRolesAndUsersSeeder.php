<?php

use Illuminate\Database\Seeder;

class DefaultRolesAndUsersSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        
        $roles = [
            "code" => "ADMIN", "name" => "Administrator",
            "code" => "RECEIVING", "name" => "Receiving Officer",
            "code" => "ADMIN", "name" => "Administrator",
        ];
        
    }

}
