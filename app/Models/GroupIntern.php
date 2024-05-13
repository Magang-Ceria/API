<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class GroupIntern extends Model
{
    use HasFactory;

    protected $table = 'group_interns';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
