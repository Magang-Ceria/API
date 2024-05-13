<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAttendanceRequest;
use App\Http\Resources\AttendanceCollection;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $search = $request->query('search') ?? null;
            $attendances = Attendance::with(['attendanceable', 'date'])
                ->selfFilter($search)->orWhere
                ->filterByAttendanceable($search)
                ->orWhere->filterByDate($search)
                ->latest()->paginate();
            
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
