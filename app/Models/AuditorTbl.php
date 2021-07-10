<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditorTbl extends Model
{
  use HasFactory;
  const CREATED_AT = 'create_time';
  const UPDATED_AT = 'edit_time';

  protected $primaryKey = "unid";
  protected $keyType = 'string';
  public $incrementing = false;
  public $timestamps = false;
  public $table = 'tbl_auditor';
  protected $fillable = [
         'unid',
         'audit_position_unid',
         'audit_position',
         'auditor_group',
         'auditor_item',
         'auditor_name',
         'auditor_area',
         'area_name',
         'create_by',
         'create_time',
         'edit_by',
         'edit_time',
         'status',
     ];
}
