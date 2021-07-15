<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionsTbl extends Model
{
  use HasFactory;
  const CREATED_AT = 'create_time';
  const UPDATED_AT = 'edit_time';

  protected $primaryKey = "unid";
  protected $keyType = 'string';
  public $incrementing = false;
  public $timestamps = false;
  public $table = 'tbl_questions';
  protected $fillable = [

    'unid'
    ,'ques_index'
    ,'ques_rev'
    ,'ques_header'
    ,'create_by'
    ,'create_time'
    ,'edit_by'
    ,'edit_time'
    ,'status'

     ];

}
