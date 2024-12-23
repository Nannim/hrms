<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Allowance extends Model
{
    protected $table = 'allowance';
    protected $primaryKey = 'allowance_id';

    protected $fillable = [
        'allowance_id', 'allowance_name','allowance_type','percentage_of_basic','limit_per_month'
    ];
}
