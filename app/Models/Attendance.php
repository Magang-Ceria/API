<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Attendance extends Model
{
    use HasFactory;

    protected $table = 'attendance';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function attendanceable(): MorphTo
    {
        return $this->morphTo();
    }

    public function date()
    {
        return $this->belongsTo(Date::class);
    }

    // public function scopeIncludeRelation

    public function scopeSelfFilter(Builder $query, $search)
    {
        $query->where('morningstatus', $search)
            ->orWhere('afternoonstatus', $search);
    }

    public function scopeFilterByAttendanceable(Builder $query, $search)
    {
        $query->whereHasMorph(
            'attendanceable',
            [IndividualIntern::class, Group::class],
            function (Builder $q1, string $type) use ($search) {
                $related = $type === IndividualIntern::class ? 'user' : 'groupIntern';

                $nestedRelationName = $related == 'groupIntern' ? 'group_interns' : 'user';

                $q1->where('institution', 'like', '%' . $search . '%')
                    ->orWhereHas($related, function ($q2) use ($nestedRelationName, $search) {
                        $q2->where($nestedRelationName . '.name', 'like', '%' . $search . '%');
                    });
            }
        );
    }

    public function scopeFilterByDate(Builder $q1, $search)
    {
        $q1
            ->whereHas('date', function ($q2) use ($search) {
                $q2->where('date', 'like', '%' . $search . '%')
                    ->orWhere('day', 'like', '%' . $search . '%')
                    ->orWhere('month', 'like', '%' . $search . '%')
                    ->orWhere('year', 'like', '%' . $search . '%');
            });
    }
}
