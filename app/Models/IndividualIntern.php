<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class IndividualIntern extends Model
{
    use HasFactory;

    protected $table = "individual_interns";
    protected $primaryKey = "id";
    protected $guarded = ["id"];

    public function document(): MorphOne
    {
        return $this->morphOne(Document::class, 'documentable');
    }

    public function attendance(): MorphMany
    {
        return $this->morphMany(Attendance::class, 'attendanceable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
