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

    public function scopeSelfFilter(Builder $query, $value)
    {
        $query->where('morningstatus', $value)
            ->orWhere('afternoonstatus', $value);
    }

    public function scopeFilterByAttendanceable(Builder $query, $value)
    {
        $query->whereHasMorph(
            'attendanceable',
            [IndividualIntern::class, Group::class],
            function (Builder $query, string $type) use ($value) {
                $related = $type === IndividualIntern::class ? 'user' : 'groupIntern';

                $nestedRelationName = $related == 'groupIntern' ? 'group_interns' : 'user';

                $query->where('institution', 'like', '%' . $value . '%')
                    ->orWhereHas($related, function ($q) use ($nestedRelationName, $value) {
                        $q->where($nestedRelationName . '.name', 'like', '%' . $value . '%');
                    });
            }
        );
    }

    public function scopeFilterByDate(Builder $query, $value)
    {
        $query->whereHas('date', function ($query) use ($value) {
            $query->where('date', 'like', '%' . $value . '%')
                ->orwhere('day', 'like', '%' . $value . '%')
                ->orWhere('month', 'like', '%' . $value . '%')
                ->orWhere('year', 'like', '%' . $value . '%');
        });
    }
}
