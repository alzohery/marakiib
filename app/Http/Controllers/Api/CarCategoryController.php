<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Middlewares\PermissionMiddleware;

class CarCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum', PermissionMiddleware::class . ':manage-cars']);
    }

    public function attach(Request $request, Car $car)
    {
        $this->authorize('update', $car);
        $request->validate(['category_id' => 'required|exists:categories,id']);
        $categoryId = $request->input('category_id');

        if (DB::table('car_category')->where('car_id', $car->id)->where('category_id', $categoryId)->exists()) {
            return response()->json(['message' => 'Category already attached to this car'], 400);
        }

        DB::table('car_category')->insert([
            'car_id' => $car->id,
            'category_id' => $categoryId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['message' => 'Category attached successfully'], 201);
    }

    public function detach(Request $request, Car $car)
    {
        $this->authorize('update', $car);
        $request->validate(['category_id' => 'required|exists:categories,id']);
        $categoryId = $request->input('category_id');

        $deleted = DB::table('car_category')->where('car_id', $car->id)->where('category_id', $categoryId)->delete();

        if (!$deleted) {
            return response()->json(['message' => 'Category not found for this car'], 404);
        }

        return response()->json(['message' => 'Category detached successfully'], 200);
    }

    public function index(Car $car)
    {
        $categories = Category::whereIn('id', function ($query) use ($car) {
            $query->select('category_id')->from('car_category')->where('car_id', $car->id);
        })->withTranslations()->get();

        return response()->json(['data' => $categories], 200);
    }
}
