<?php

namespace App\Models\Modules;

use App\Models\BelongsToAnItem;
use App\Models\HasAuditLogs;
use App\Models\MasterFiles\Inventory\ItemType;
use App\Models\MasterFiles\Inventory\UOM;
use Illuminate\Database\Eloquent\Model;

class BillOfMaterials extends Model {

    const MODULE_CODE = "BOM";

    use HasAuditLogs;
    use BelongsToAnItem;

    public $incrementing     = false;
    protected $table         = "bill_of_materials";
    protected $primaryKey    = "code";
    protected $fillable      = ["code", "produced_item_type", "produced_item_code", "produced_item_name", "produced_item_uom_code", "product_qty"];
    //
    //  BelongsToAnItem
    protected $itemTypeField = "produced_item_type";
    protected $itemCodeField = "produced_item_code";
    protected $UOMField      = "produced_item_uom_code";

    //
    /**     * ****************************************************************** */
    // <editor-fold defaultstate="collapsed" desc="Functions">

    public function getRequiredInventoriableMaterials() {
        $details = $this->details()->whereHas('itemType', function ($query) {
                    return $query->where("inventoriable", true);
                })->get();
        return $details;
    }

    // </editor-fold>

    /**     * ****************************************************************** */
    // <editor-fold defaultstate="collapsed" desc="Relationships">

    public function details() {
        return $this->hasMany(RawMaterial::class, "bom_code");
    }

    public function itemType() {
        return $this->belongsTo(ItemType::class, "produced_item_type");
    }

    public function item() {
        return $this->belongsTo(Item::class, "produced_item_code");
    }

    public function itemUOM() {
        return $this->belongsTo(UOM::class, "produced_item_uom_code");
    }

    // </editor-fold>
}
