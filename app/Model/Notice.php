<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    protected $table = 'notice';
    protected $primaryKey = 'notice_id';

    protected $fillable = [
        'notice_id', 'title','description','status','created_by','updated_by','publish_date','attach_file'
    ];

    public function createdBy(){
        return $this->belongsTo(Employee::class,'created_by')->withDefault([
            'id' => 0,
            'first_name' => 'N/A',
            'last_name' => '',
        ]);
    }
}
