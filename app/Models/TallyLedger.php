<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TallyVoucherHead;

class TallyLedger extends Model
{
    use HasFactory;

    protected $guarded = [];

    // TallyLedger model
    public function tallyVoucherHead()
    {
        return $this->belongsTo(TallyVoucherHead::class, 'ledger_guid', 'guid'); // 'guid' in TallyLedger and 'ledger_guid' in TallyVoucherHead
    }

}
