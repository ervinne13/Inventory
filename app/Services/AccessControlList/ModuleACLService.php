<?php

namespace App\Services\AccessControlList;

use Illuminate\Support\Facades\Auth;

/**
 * Description of ModuleACLService
 *
 * @author ervinne
 */
class ModuleACLService {

    /**
     * TODO: put this in a configuration file
     * @var array
     */
    protected $moduleOrder = [
            [
            "icon"    => "fa-industry",
            "name"    => "Production",
            "modules" => [
                    ["code" => "BOM", "name" => "Bill of Materials", "icon" => "fa-file-o", "url" => "production/bom"],
                    ["code" => "PRO", "name" => "Production Order", "icon" => "fa-refresh", "url" => "production/production-orders"],
            ]
        ],
            [
            "icon"    => "fa-file-o",
            "name"    => "Inventory",
            "modules" => [
                    ["code" => "IM", "name" => "Item Movement", "icon" => "fa-send", "url" => "inventory/item-movements"],
//                ["code" => "IR", "name" => "Item Reclass", "icon" => "fa-dropbox", "url" => "inventory/item-reclass"],
//                ["code" => "TO", "name" => "Transfer Order", "icon" => "fa-plane", "url" => "inventory/transfer-orders"]
            ]
        ],
            [
            "icon"    => "fa-file",
            "name"    => "Master Files",
            "modules" => [
                    ["code" => "NS", "name" => "Number Series", "icon" => "fa-file-o", "url" => "master-files/number-series"],
                    ["code" => "I", "name" => "Item", "icon" => "fa-file-o", "url" => "master-files/items"],
                    ["code" => "S", "name" => "Supplier", "icon" => "fa-users", "url" => "master-files/suppliers"],
                    ["code" => "UOM", "name" => "Unit Of Measurement", "icon" => "fa-file-o", "url" => "master-files/uom"],
//                ["code" => "COM", "name" => "Company", "icon" => "fa-home", "url" => "master-files/companies"],
                ["code" => "LOC", "name" => "Location", "icon" => "fa-map-marker", "url" => "master-files/locations"],
            ]
        ],
            [
            "icon"    => "fa-lock",
            "name"    => "Security",
            "modules" => [
                    ["code" => "U", "name" => "User", "icon" => "fa-user", "url" => "master-files/users"],
                    ["code" => "R", "name" => "Role", "icon" => "fa-lock", "url" => "security/roles"],
                    ["code" => "ACL", "name" => "ACL", "icon" => "fa-users", "url" => "security/acl"]
            ]
        ],
            [
            "icon"    => "fa-gears",
            "name"    => "Maintenance",
            "modules" => [
                    ["code" => "BKR", "name" => "Backup & Restoration", "icon" => "fa-hdd-o", "url" => "maintenance/backup-restore"],
            ]
        ],
    ];

    public function getAccessibleModules() {

        //  if the current user has admin role
        if (in_array("ADMIN", array_column(Auth::user()->roles->toArray(), "code"))) {
            //  it will have all module access
            return $this->moduleOrder;
        }

        $accessibleModuleCodes = Auth::user()->getAccessibleModuleList();
        $accessibleModuleOrder = [];

        //  loop through all the module groups (or headers: Production, Inventory Mangement, Master Files, etc.)
        foreach ($this->moduleOrder AS $moduleGroup) {

            $accessibleModuleGroup = [
                "icon"    => $moduleGroup["icon"],
                "name"    => $moduleGroup["name"],
                "modules" => []
            ];

            //  each module groups contains modules, check if the user has access
            //  to them, if yes, add the module to the accessible module group
            foreach ($moduleGroup["modules"] AS $module) {
                if (in_array($module["code"], $accessibleModuleCodes)) {
                    array_push($accessibleModuleGroup["modules"], $module);
                }
            }

            //  if the current user has 1 or more modules accessible under this group
            if (count($accessibleModuleGroup["modules"]) > 0) {
                //  add the group to the accessible module order
                array_push($accessibleModuleOrder, $accessibleModuleGroup);
            }
        }

        return $accessibleModuleOrder;
    }

}
