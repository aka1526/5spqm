<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanPositionTbl extends Model
{
  use HasFactory;
  const CREATED_AT = 'create_time';
  const UPDATED_AT = 'edit_time';

  protected $primaryKey = "unid";
  protected $keyType = 'string';
  public $incrementing = false;
  public $timestamps = false;
  public $table = 'tbl_planposition';
  protected $fillable = [

      'unid'
    ,'plan_year'
    ,'plan_month'
    ,'plan_date'
    ,'plan_area_unid'
    ,'plan_area_index'
    ,'plan_area_name'
    ,'plan_area_owner'
    ,'position_type'
    ,'plan_groups'
    ,'plan_status'

    ,'auditor_unid'
    ,'auditor_name'
   

    ,'create_by'
    ,'create_time'
    ,'edit_by'
    ,'edit_time'

     ];

}
