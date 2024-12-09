<?php

namespace App\Http\Controllers;
use App\Models\Notebook;
use Illuminate\Http\Request;
use Js;
use Symfony\Component\HttpFoundation\JsonResponse;

class NotebookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $notebooks = Notebook::paginate(5);
            if ($notebooks->isEmpty() && $notebooks->currentPage() > 1) {
                throw new \Exception('Page not found', 404);
            }
            return response()->json([
                'current_page' => $notebooks->currentPage(),
                'per_page' => $notebooks->perPage(),
                'data' => $notebooks->items(),
                'next_page_url' => $notebooks->nextPageUrl(),
                'prev_page_url' => $notebooks->previousPageUrl(),
                'total' => $notebooks->total(),
                "total_pages" => $notebooks->lastPage()
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'fio' => 'required|max:255',
                'company' => 'nullable|max:255',
                'phone' => 'required|max:20',
                'email' => 'required|email|max:255',
                'date_of_birth' => 'nullable|date',
                'photo' => 'nullable|max:2048',
            ]);

            $notebook = Notebook::create(
                $validated
            );
            return response()->json($notebook, 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json($e->errors(), 422);
        }


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $notebook = Notebook::find($id);
        if(!$notebook){
            return response()->json(['message' => 'Notebook not found'], 404);
        }
        return response()->json($notebook, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $validated = $request->validate([
            'fio' => 'required|max:255',
            'company' => 'nullable|max:255',
            'phone' => 'required|max:20',
            'email' => 'required|email|max:255',
            'date_of_birth' => 'nullable|date',
            'photo' => 'nullable|max:2048',
        ]);
    
        $notebook = Notebook::find($id);
    
        if (!$notebook) {
            return response()->json(['message' => 'Notebook not found'], 404);
        }
    
        $notebook->update($validated);
    
        return response()->json($notebook, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $notebook = Notebook::find($id);
        if ($notebook) {
            $notebook->delete();
            return response()->json(['message' => 'Element deleted'], 204);
        }
        return response()->json(['message' => 'Element not found'], 404); 
    }
}
