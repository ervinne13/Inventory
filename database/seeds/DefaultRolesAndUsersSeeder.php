<?php

use App\Models\Security\AccessControl;
use App\Models\Security\AccessControlList;
use App\Models\Security\Role;
use App\Models\Security\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;

class DefaultRolesAndUsersSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $this->insertRoles();
        $this->insertAC();
        $this->insertACL();
        $this->insertUsers();
        $this->insertUserRoles();
    }

    private function insertRoles() {
        $roles = [
            ["code" => "ADMIN", "name" => "Administrator"],
            ["code" => "RCVNG", "name" => "Receiving Staff"],
            ["code" => "PLDSTF", "name" => "PLD Staff"],
            ["code" => "PLDMAN", "name" => "PLD Manager"],
            ["code" => "PRODSTF", "name" => "Production Staff"],
            ["code" => "PRODMAN", "name" => "Production Manager"],
            ["code" => "AUDIT", "name" => "Auditor"],
            ["code" => "ACCT", "name" => "Accountant"],
        ];

        Role::insert($roles);
    }

    private function insertAC() {
        $accessControls = [
            ["code" => "VIEWER", "name" => "Viewer"],
            ["code" => "AUTHOR", "name" => "Author"],
            ["code" => "MANAGER", "name" => "Manager"]
        ];

        AccessControl::insert($accessControls);
    }

    private function insertACL() {
        //  Staff ACL
        $staffAccessControlLists = [
            ["role_code" => "RCVNG", "module_code" => "I", "access_control_code" => "VIEWER"],
            ["role_code" => "RCVNG", "module_code" => "IM", "access_control_code" => "AUTHOR"],
            //  PLD
            ["role_code" => "PLDSTF", "module_code" => "I", "access_control_code" => "VIEWER"],
            ["role_code" => "PLDSTF", "module_code" => "UOM", "access_control_code" => "AUTHOR"],
            ["role_code" => "PLDSTF", "module_code" => "IM", "access_control_code" => "AUTHOR"],
            ["role_code" => "PLDSTF", "module_code" => "IR", "access_control_code" => "AUTHOR"],
            ["role_code" => "PLDSTF", "module_code" => "TO", "access_control_code" => "AUTHOR"],
            //  Production
            ["role_code" => "PRODSTF", "module_code" => "I", "access_control_code" => "VIEWER"],
            ["role_code" => "PRODSTF", "module_code" => "IM", "access_control_code" => "VIEWER"],
            ["role_code" => "PRODSTF", "module_code" => "BOM", "access_control_code" => "AUTHOR"],
            ["role_code" => "PRODSTF", "module_code" => "PRO", "access_control_code" => "AUTHOR"],
            //  Accounting
            ["role_code" => "ACCT", "module_code" => "I", "access_control_code" => "VIEWER"],
            ["role_code" => "ACCT", "module_code" => "UOM", "access_control_code" => "VIEWER"],
            ["role_code" => "ACCT", "module_code" => "IM", "access_control_code" => "VIEWER"],
            ["role_code" => "ACCT", "module_code" => "IR", "access_control_code" => "VIEWER"],
            ["role_code" => "ACCT", "module_code" => "TO", "access_control_code" => "VIEWER"],
            ["role_code" => "ACCT", "module_code" => "PRO", "access_control_code" => "VIEWER"],
            ["role_code" => "ACCT", "module_code" => "ER", "access_control_code" => "MANAGER"],
            //  Auditor
            ["role_code" => "AUDIT", "module_code" => "I", "access_control_code" => "VIEWER"],
            ["role_code" => "AUDIT", "module_code" => "UOM", "access_control_code" => "VIEWER"],
            ["role_code" => "AUDIT", "module_code" => "IM", "access_control_code" => "VIEWER"],
            ["role_code" => "AUDIT", "module_code" => "IR", "access_control_code" => "VIEWER"],
            ["role_code" => "AUDIT", "module_code" => "TO", "access_control_code" => "VIEWER"],
            ["role_code" => "AUDIT", "module_code" => "PRO", "access_control_code" => "VIEWER"],
            ["role_code" => "AUDIT", "module_code" => "ER", "access_control_code" => "VIEWER"],
        ];

        AccessControlList::insert($staffAccessControlLists);

        //  Managers
        $managerAccessConrolLists = [
            //  PLD
            ["role_code" => "PLDMAN", "module_code" => "I", "access_control_code" => "AUTHOR"],
            ["role_code" => "PLDMAN", "module_code" => "UOM", "access_control_code" => "MANAGER"],
            ["role_code" => "PLDMAN", "module_code" => "IM", "access_control_code" => "MANAGER"],
            ["role_code" => "PLDMAN", "module_code" => "IR", "access_control_code" => "MANAGER"],
            ["role_code" => "PLDMAN", "module_code" => "TO", "access_control_code" => "MANAGER"],
            //  Production
            ["role_code" => "PRODMAN", "module_code" => "I", "access_control_code" => "AUTHOR"],
            ["role_code" => "PRODMAN", "module_code" => "IM", "access_control_code" => "VIEWER"],
            ["role_code" => "PRODMAN", "module_code" => "BOM", "access_control_code" => "MANAGER"],
            ["role_code" => "PRODMAN", "module_code" => "PRO", "access_control_code" => "MANAGER"],
        ];

        AccessControlList::insert($managerAccessConrolLists);
    }

    private function insertUsers() {
        $users = [
            ["username" => "admin", "display_name" => "Administrator", "location_full_access" => true],
            ["username" => "dtumulak", "display_name" => "Doris Tumulak", "location_full_access" => false],
            ["username" => "lbatarao", "display_name" => "Lizeth Batarao", "location_full_access" => false],
            ["username" => "evillalon", "display_name" => "Ehmar Villalon", "location_full_access" => false],
            ["username" => "gflores", "display_name" => "Gabrielle Flores", "location_full_access" => false],
            ["username" => "psampani", "display_name" => "Prosa Mae Sampani", "location_full_access" => false],
            ["username" => "ggarcia", "display_name" => "Gretchen Garcia", "location_full_access" => false],
        ];

        for ($i = 0; $i < count($users); $i ++) {
            $users[$i]["password"] = \Hash::make("password");
        }

        User::insert($users);
    }

    private function insertUserRoles() {
        $userRoles = [
            ["user_username" => "admin", "role_code" => "ADMIN"],
            ["user_username" => "dtumulak", "role_code" => "RCVNG"],
            ["user_username" => "lbatarao", "role_code" => "PLDMAN"],
            ["user_username" => "evillalon", "role_code" => "PRODMAN"],
            ["user_username" => "gflores", "role_code" => "AUDIT"],
            ["user_username" => "psampani", "role_code" => "ACCT"],
            //  1 user can also have multiple roles
            ["user_username" => "ggarcia", "role_code" => "PLDSTF"],
            ["user_username" => "ggarcia", "role_code" => "PRODSTF"]
        ];

        UserRole::insert($userRoles);
    }

}
