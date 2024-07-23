<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TallyVoucher;

class TallyVoucherEntry extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function voucherEntry()
    {
        return $this->belongsTo(TallyVoucher::class, 'tally_voucher_id');
    }



}
