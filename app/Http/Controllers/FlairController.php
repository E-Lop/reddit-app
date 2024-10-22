<?php

namespace App\Http\Controllers;

use App\Http\Requests\FlairRequest;
use Illuminate\Http\Request;
use App\Models\Flair;

class FlairController extends Controller
{
    /**
     * List of all flairs
     */
    public function index()
    {
        return Flair::all();
    }

    /**
     * Stores a new flair
     */
    public function store(FlairRequest $request)
    {
        $data = $request->all();
        $flair = Flair::create($data);

        return response()->json([
            'status' => 'success',
            'flair' => $flair,
        ]);
    }

    /**
     * Shows a specific flair
     */
    public function show($id)
    {
        $flair = Flair::find($id);

        if ($flair === null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Flair not found',
            ]);
        }

        return response()->json([
            'status' => 'success',
            'flair' => $flair,
        ]);
    }

    /**
     * Updates a specific flair
     */
    public function update(FlairRequest $request, $id)
    {
        $data = $request->all();
        $selected_flair = Flair::find($id);

        if ($selected_flair === null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Flair not found',
            ]);
        }

        $selected_flair->update($data);

        return response()->json([
            'status' => 'success',
            'flair' => $selected_flair,
        ]);
    }

    /**
     * Deletes a specific flair
     */
    public function destroy($id)
    {
        $flair = Flair::find($id);

        if ($flair === null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Flair not found',
            ]);
        }

        $flair->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Flair deleted',
        ]);
    }
}
