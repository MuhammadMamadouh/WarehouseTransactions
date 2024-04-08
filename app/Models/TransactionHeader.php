<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionHeader extends Model
{
    use HasFactory;

    const NORMAL_B2B_SALES = 1;
    const RETURN_B2B_SALES = 2;
    const NORMAL_B2C_SALES = 3;
    const RETURN_B2C_SALES = 4;




    // ===================== scopes =====================
    public function scopeNormal_b2b($query)
    {
        return $query->where('type', self::NORMAL_B2B_SALES);
    }

    public function scopeReturn_b2b($query)
    {
        return $query->where('type', self::RETURN_B2B_SALES);
    }

    public function scopeNormal_b2c($query)
    {
        return $query->where('type', self::NORMAL_B2C_SALES);
    }

    public function scopeReturn_b2c($query)
    {
        return $query->where('type', self::RETURN_B2C_SALES);
    }




}
