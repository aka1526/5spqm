<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionsResultTbl extends Model
{
  use HasFactory;
  const CREATED_AT = 'create_time';
  const UPDATED_AT = 'edit_time';

  protected $primaryKey = "unid";
  protected $keyType = 'string';
  public $incrementing = false;
  public $timestamps = false;
  public $table = 'tbl_questions_result';
  protected $fillable = [

      'unid'
      ,'ques_unid'
      ,'ques_rev'
      ,'ques_header'
      ,'positions_type'
      ,'position_name'
      ,'area_unid'
      ,'area_name'
      ,'area_owner'
      ,'result_index'
      ,'result_toppic'
      ,'result_desc'
      ,'result_val'
      ,'status'
      ,'result_type'
      ,'auditor_unid'
      ,'auditor_name'
      ,'create_by'
      ,'create_time'
      ,'edit_by'
      ,'edit_time'

     ];

}
