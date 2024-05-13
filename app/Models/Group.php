<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Group extends Model
{
    use HasFactory;

    protected $table = "groups";
    protected $primaryKey = "id";
    protected $guarded = ["id"];
    protected $with = ['groupIntern'];

    public function document(): MorphOne
    {
        return $this->morphOne(Document::class, 'documentable');
    }
    
    public function attendance(): MorphMany
    {   
        return $this->morphMany(Attendance::class, 'attendanceable');
    }

    public function leader()
    {
        return $this->belongsTo(User::class, "leader_id", "id");
    }

    public function groupIntern()
    {
        return $this->hasMany(GroupIntern::class);
    }
}
