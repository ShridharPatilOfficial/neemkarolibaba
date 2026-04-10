<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrgProfile extends Model
{
    protected $table = 'org_profiles';

    protected $fillable = ['sl_no', 'document_name', 'value', 'sort_order'];
}
