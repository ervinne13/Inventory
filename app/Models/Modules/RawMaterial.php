<?php

namespace App\Models\Modules;

use App\Models\BelongsToAnItem;
use App\Models\CompositeKeyModel;
use Illuminate\Database\Eloquent\Model;

class RawMaterial extends Model {

    use BelongsToAnItem;
    use CompositeKeyModel;

    public $incrementing  = false;
    protected $table      = "raw_material";
    protected $primaryKey = ["bom_code", "item_code"];
    protected $fillable   = ["bom_code", "item_code", "item_type_code", "item_uom_code", "item_name", "qty"];

}
