<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\IndividualIntern;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\facades\Storage;
use App\Http\Resources\IndividualInternResource;
use App\Http\Resources\IndividualInternCollection;
use App\Http\Requests\StoreIndividualInternRequest;
use App\Http\Requests\UpdateIndividualInternRequest;

class IndividualInternController extends Controller
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
    
            $datas = IndividualIntern::where('status', 'active')
                ->orWhere('institution', 'like', '%' . $search . '%')
                ->orWhere('startperiode', 'like', '%' . $search . '%')
                ->orWhere('endperiode', 'like', '%' . $search . '%')
                ->whereHas('user', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                })
                ->paginate();
    
            if ($datas->count() == 0) {
                return response()->json([
                    'message' => 'Data Not Found'
                ], 404);
            }
    
            return new IndividualInternCollection($datas);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Internal Server Error',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreIndividualInternRequest $request)
    {
        try {
            $data = $request->validated();

            $data['status'] = 'pending';

            $file = $request->file('document');

            $user = User::find(Auth::user()->id);

            $filePath = Storage::putFileAs('public/docs', $file, $file->getClientOriginalName() . $user->id);

            $intern = $user->individualIntern()->create($data);

            $docs = $intern->document()->create([
                "registrationletter" => $filePath
            ]);

            return new IndividualInternResource($intern);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Something went wrong",
                "error" => $th->getMessage(),
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(IndividualIntern $individualIntern)
    {
        // return
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateIndividualInternRequest $request, IndividualIntern $individualIntern)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IndividualIntern $individualIntern)
    {
        //
    }
}
