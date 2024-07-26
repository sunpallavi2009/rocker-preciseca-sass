<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TallyVoucher extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function voucherHead()
    {
        return $this->belongsTo(TallyVoucherHead::class, 'party_ledger_name', 'ledger_name');
    }
}
