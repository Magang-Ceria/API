<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Models\IndividualIntern;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\AttendanceCollection;
use App\Http\Requests\StoreAttendanceRequest;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $user = $request->user();

            if (!$user->tokenCan('*')) {
                return response()->json([
                    "message" => "This action is not allowed",
                ], 403);
            }

            $search = $request->query('search') ?? null;
            $attendances = Attendance::with([
                'attendanceable' => function (MorphTo $morphTo) {
                    $morphTo->morphWith([
                        IndividualIntern::class => ['user:id,name'],
                        Group::class => ['groupIntern:id,name,group_id']
                    ]);
                }, 'date'
            ])->selfFilter($search)->orWhere
                ->filterByAttendanceable($search)
                ->orWhere->filterByDate($search)
                ->latest()
                ->paginate();

            if ($attendances->count() == 0) {
                return response()->json([
                    'message' => 'Data Not Found',
                ], 404);
            }

            return new AttendanceCollection($attendances);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Internal Server Error',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAttendanceRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreAttendanceRequest $request, Attendance $attendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendance $attendance)
    {
        //
    }
}
