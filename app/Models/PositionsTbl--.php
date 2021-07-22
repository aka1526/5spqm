<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PositionsTbl extends Model
{
  use HasFactory;
  const CREATED_AT = 'create_time';
  const UPDATED_AT = 'edit_time';

  protected $primaryKey = "unid";
  protected $keyType = 'string';
  public $incrementing = false;
  public $timestamps = false;
  public $table = 'tbl_positions';
  protected $fillable = [
         'unid',
         'position_index',
         'positions_type',
         'position_name',
         'status',
         'create_by',
         'create_time',
         'edit_by',
         'edit_time',

     ];

}
