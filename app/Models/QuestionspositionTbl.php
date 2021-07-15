<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionspositionTbl extends Model
{
  use HasFactory;
  const CREATED_AT = 'create_time';
  const UPDATED_AT = 'edit_time';

  protected $primaryKey = "unid";
  protected $keyType = 'string';
  public $incrementing = false;
  public $timestamps = false;
  public $table = 'tbl_questions_position';
  protected $fillable = [
    'unid'
    ,'ques_unid'
    ,'position_type'
    ,'create_by'
    ,'create_time'
    ,'edit_by'
    ,'edit_time'
    ,'status'

     ];

}
