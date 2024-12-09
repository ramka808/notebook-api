<?php

namespace App\Http\Controllers;
use App\Models\Notebook;
use Illuminate\Http\Request;
use Js;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Notebook API Documentation",
 *     description="API документация для управления записной книжкой"
 * )
 */
class NotebookController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/notebook",
     *     summary="Получить список всех записей",
     *     tags={"Notebook"},
     *     @OA\Response(
     *         response=200,
     *         description="Успешный ответ",
     *         @OA\JsonContent(
     *             @OA\Property(property="current_page", type="integer", example=1),
     *             @OA\Property(property="per_page", type="integer", example=5),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="fio", type="string", example="John Doe"),
     *                     @OA\Property(property="company", type="string", example="Example Corp"),
     *                     @OA\Property(property="phone", type="string", example="123456789"),
     *                     @OA\Property(property="email", type="string", example="john@example.com"),
     *                     @OA\Property(property="date_of_birth", type="string", format="date", example="2000-01-01"),
     *                     @OA\Property(property="photo", type="string", nullable=true)
     *                 )
     *             ),
     *             @OA\Property(property="next_page_url", type="string", nullable=true),
     *             @OA\Property(property="prev_page_url", type="string", nullable=true),
     *             @OA\Property(property="total", type="integer", example=10),
     *             @OA\Property(property="total_pages", type="integer", example=2)
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Страница не найдена"
     *     )
     * )
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
     * @OA\Post(
     *     path="/api/notebook",
     *     summary="Создать новую запись",
     *     tags={"Notebook"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"fio","phone","email"},
     *             @OA\Property(property="fio", type="string", example="John Doe"),
     *             @OA\Property(property="company", type="string", example="Example Corp"),
     *             @OA\Property(property="phone", type="string", example="123456789"),
     *             @OA\Property(property="email", type="string", example="john@example.com"),
     *             @OA\Property(property="date_of_birth", type="string", format="date", example="2000-01-01"),
     *             @OA\Property(property="photo", type="string", nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Запись создана"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Ошибка валидации"
     *     )
     * )
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
     * @OA\Get(
     *     path="/api/notebook/{id}",
     *     summary="Получить запись по ID",
     *     tags={"Notebook"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID записи",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Успешный ответ"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Запись не найдена"
     *     )
     * )
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
     * @OA\Post(
     *     path="/api/notebook/{id}",
     *     summary="Обновить существующую запись",
     *     tags={"Notebook"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID записи",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"fio","phone","email"},
     *             @OA\Property(property="fio", type="string", example="John Doe"),
     *             @OA\Property(property="company", type="string", example="Example Corp"),
     *             @OA\Property(property="phone", type="string", example="123456789"),
     *             @OA\Property(property="email", type="string", example="john@example.com"),
     *             @OA\Property(property="date_of_birth", type="string", format="date", example="2000-01-01"),
     *             @OA\Property(property="photo", type="string", nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Запись обновлена"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Запись не найдена"
     *     )
     * )
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
     * @OA\Delete(
     *     path="/api/notebook/{id}",
     *     summary="Удалить запись",
     *     tags={"Notebook"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID записи",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Запись удалена"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Запись не найдена"
     *     )
     * )
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
