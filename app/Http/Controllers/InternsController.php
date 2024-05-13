<?php

namespace App\Http\Controllers;

use App\Http\Requests\InternsRequest;
use App\Models\Group;
use App\Models\IndividualIntern;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class InternsController extends Controller
{
    public function getActiveInterns(InternsRequest $request)
    {
        try {

            $individualInterns = IndividualIntern::where('status', 'active')->count() ?? 0;
            $groups = Group::withCount(['groupIntern as group_member_count' => function (Builder $query) {
                $query->where('status', 'like', '%active%');
            }]) ?? 0;

            $groupInterns = 0;

            foreach ($groups as $group) {
                $groupInterns = $groupInterns + $group->group_member_count;
            }

            return response()->json([
                "activeInterns" => $individualInterns + $groupInterns
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => 'Internal Server Error',
                "error" => $th->getMessage(),
            ], 500);
        }
    }
}
