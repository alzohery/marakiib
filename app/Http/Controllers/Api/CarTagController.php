<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Middlewares\PermissionMiddleware;

class CarTagController extends Controller
{
    public function __construct()
    {
        // $this->middleware(['auth:sanctum', PermissionMiddleware::class . ':manage-cars']);
    }

    public function attach(Request $request, Car $car)
    {
        $this->authorize('update', $car);
        $request->validate(['tag_id' => 'required|exists:tags,id']);
        $tagId = $request->input('tag_id');

        if (DB::table('car_tag')->where('car_id', $car->id)->where('tag_id', $tagId)->exists()) {
            return response()->json(['message' => 'Tag already attached to this car'], 400);
        }

        DB::table('car_tag')->insert([
            'car_id' => $car->id,
            'tag_id' => $tagId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['message' => 'Tag attached successfully'], 201);
    }

    public function detach(Request $request, Car $car)
    {
        $this->authorize('update', $car);
        $request->validate(['tag_id' => 'required|exists:tags,id']);
        $tagId = $request->input('tag_id');

        $deleted = DB::table('car_tag')->where('car_id', $car->id)->where('tag_id', $tagId)->delete();

        if (!$deleted) {
            return response()->json(['message' => 'Tag not found for this car'], 404);
        }

        return response()->json(['message' => 'Tag detached successfully'], 200);
    }

    public function index(Car $car)
    {
        $tags = Tag::whereIn('id', function ($query) use ($car) {
            $query->select('tag_id')->from('car_tag')->where('car_id', $car->id);
        })->with('translations')->get();

        return response()->json(['data' => $tags], 200);
    }
}
