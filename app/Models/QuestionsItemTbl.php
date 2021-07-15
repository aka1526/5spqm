<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionsItemTbl extends Model
{
  use HasFactory;
  const CREATED_AT = 'create_time';
  const UPDATED_AT = 'edit_time';

  protected $primaryKey = "unid";
  protected $keyType = 'string';
  public $incrementing = false;
  public $timestamps = false;
  public $table = 'tbl_questionsitem';
  protected $fillable = [
      'unid'
      ,'item_refunid'
      ,'item_index'
      ,'item_toppic'
      ,'item_desc'
      ,'status'
      ,'create_time'
      ,'edit_by'
      ,'edit_time'

     ];

}
