<?php

namespace App\Models\Modules;

use App\Models\BelongsToAnItem;
use Illuminate\Database\Eloquent\Model;

class TransferOrderDetail extends Model {

    use BelongsToAnItem;

    protected $table      = "transfer_order_detail";
    protected $primaryKey = "line_no";

}
