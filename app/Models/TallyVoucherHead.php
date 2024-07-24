<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TallyVoucher;

class TallyVoucherHead extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function voucherHead()
    {
        return $this->belongsTo(TallyVoucher::class, 'tally_voucher_id');
    }



}
