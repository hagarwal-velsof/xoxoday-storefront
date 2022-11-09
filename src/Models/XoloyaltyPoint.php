<?php

namespace Xoxoday\Storefront\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class XoloyaltyPoint extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['user_id','reference_id','redemption_id','points','reason','date_added'];
}
