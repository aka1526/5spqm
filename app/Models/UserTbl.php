<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTbl extends Model
{
  use HasFactory;
  const CREATED_AT = 'create_time';
  const UPDATED_AT = 'edit_time';

  protected $primaryKey = "user_login";
  protected $keyType = 'string';
  public $incrementing = false;
  public $timestamps = false;
  public $table = 'tbl_user';
  protected $fillable = [
         'unid',
         'user_login',
         'user_name',
         'user_password',
         'status',
         'create_by',
         'create_time',
         'edit_by',
         'edit_time',

     ];

}
