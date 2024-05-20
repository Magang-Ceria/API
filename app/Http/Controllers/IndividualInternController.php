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
use App\Http\Resources\DocumentResource;
use App\Models\Document;

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

            unset($data['document']);

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
        return new IndividualInternResource($individualIntern->load(
            'user:id,name,email,phonenumber',
            'attendance:morningtime,morningstatus,afternoontime,afternoonstatus,attendanceable_id',
            'document:registrationletter,acceptanceletter,documentable_id'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateIndividualInternRequest $request, IndividualIntern $individualIntern)
    {
        // admin: update status and document
        // user: update information

        ## check 

        // is admin token?
        // true
        //  can update just status and individualIntern->document->acceptanse letter
        // false 
        //  can update all data except:
        //      status and IndividualIntern->document->acceptanceletter

        $file = $request->file('document');
        $updateData = $request->validated();

        unset($updateData['document']);

        if ($request->user()->tokenCan('*')) {
            $document = new Document(['acceptancenletter' => $file]);
            $acceptIntern = $individualIntern->document()->save($document);

            return new DocumentResource($acceptIntern);
        }

        $updateRegistrationLetter = new Document(['registrationletter' => $file]);

        $updateIntern = $individualIntern->update($updateData);

        $updateInternDocument = $individualIntern->document()->save($updateRegistrationLetter);

        return new IndividualInternResource($individualIntern);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IndividualIntern $individualIntern)
    {
        //
    }
}
