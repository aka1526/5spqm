<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SummaryResultTbl extends Model
{
  use HasFactory;
  const CREATED_AT = 'create_time';
  const UPDATED_AT = 'edit_time';

  protected $primaryKey = "unid";
  protected $keyType = 'string';
  public $incrementing = false;
  public $timestamps = false;
  public $table = 'tbl_result_summary';
  protected $fillable = [
    'unid'
    ,'plan_unid'
   ,'plan_date'
   ,'plan_month'
   ,'plan_year'
   ,'doc_status'
   ,'questions_unid'
   ,'questions_rev'
   ,'questions_header'
   ,'total_item'
   ,'total_score'
   ,'area_score'
   ,'area_unid'
   ,'area_name'
   ,'area_owner'
   ,'auditor_unid'
   ,'auditor_name'
   ,'auditor_position'
  , 'create_by'
   ,'create_time'
   ,'edit_by'
   ,'edit_time'
   ,'ans_unid'
     ];

}
