<?php

namespace Xoxoday\Storefront\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Xoredemption extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['user_id', 'product', 'status', 'request_date','address','address2','city','state','pincode','landmark'];

}
