<?php

namespace Xoxoday\Storefront\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Xostate extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'name',
        'status'
    ];
}
