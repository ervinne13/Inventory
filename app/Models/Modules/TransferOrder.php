<?php

namespace App\Models\Modules;

use App\Models\HasAuditLogs;
use App\Models\HasDocDate;
use App\Models\Inventory\LocationItemStockSummary;
use Illuminate\Database\Eloquent\Model;

class TransferOrder extends Model {

    const MODULE_CODE = "TO";

    use HasAuditLogs;
    use HasDocDate;

    public $incrementing  = false;
    protected $table      = "transfer_order";
    protected $primaryKey = "doc_no";
    protected $fillable   = ["doc_no", "doc_date", "origin_company_code", "origin_location_code", "destination_company_code", "destination_location_code", "status", "remarks"];

    public function details() {
        return $this->hasMany(TransferOrderDetail::class, "doc_no");
    }

    public function originLocation() {
        return $this->belongsTo(LocationItemStockSummary::class, "origin_location_code");
    }

    public function destinationLocation() {
        return $this->belongsTo(LocationItemStockSummary::class, "destination_location_code");
    }

}
