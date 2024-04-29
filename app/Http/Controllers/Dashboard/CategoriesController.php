<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $request = request();
        //select a.*,b.name as parent_names
        //from categories as a
        //left join categories as b on b.id = a.parent_id

        $categories = Category::with('parent')
            // ->select('categories.*')
            //->selectRaw('(SELECT COUNT(*) FROM products WHERE category_id = categories.id) as prodects_count')
            // ->addSelect(DB::raw('(SELECT COUNT(*) FROM products WHERE category_id = categories.id) as prodects_count'))
            // leftJoin('categories as parents', 'parents.id', '=', 'categories.parent_id')
            //     ->select([
            //         'categories.*',
            //         'parents.name as parent_name'
            //     ])
            ->withCount([
                'products as products_number' => function ($query) {
                    $query->where('status', '=', 'active');
                }
            ])
            ->filter($request->query())->orderBy('categories.name')->paginate();
        //scopeFilter
        return view('dashboard.categorise.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parents = Category::all();
        $category = new Category();
        return view('dashboard.categorise.create', compact('parents', 'category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        // add to slug in inpout but the take name and make small change


        $request->merge([
            'slug' => Str::slug($request->post('name'))
        ]);


        $data = $request->except('image');

        $data['image'] = $this->uploadImage($request);


        $category = Category::create($data);
        return redirect()->route('dashboard.categories.index')->with('success', "category created $category->name");
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return view("dashboard.categorise.show", [
            'category' => $category
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $category = Category::findOrFail($id);
        } catch (Exception $e) {
            return redirect()->route('dashboard.categories.index')->with('info', 'Recourd not found');
        }

        $parents = Category::where('id', '<>', $id)
            ->where(function (Builder $query) use ($id) {
                $query->whereNull('parent_id')
                    ->orWhere('parent_id', '<>', $id);
            })->get();
        return view('dashboard.categorise.edit', compact('category', 'parents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id)
    {


        $category = Category::findOrFail($id);

        $old_image = $category['image'];
        $data = $request->except('image');
        $newImage = $this->uploadImage($request);
        if ($newImage) {
            $data['image'] = $newImage;
        }
        $category->update($data);

        if ($old_image && $newImage) {
            Storage::disk('public')->delete($old_image);
        }
        return redirect()->route('dashboard.categories.index')->with('success', "category updated $category->name ");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();


        return redirect()->route('dashboard.categories.index')->with('success', 'category delete');
    }

    public function uploadImage(Request $request)
    {
        if (!$request->hasFile('image')) {
            return;
        }
        $file = $request->file('image');
        $path = $file->store('uploads', ['disk' => 'public']);
        return $path;
    }

    public function trash()
    {
        $category = Category::onlyTrashed()->filter(request()->query())->paginate();
        return view('dashboard.categorise.trash', ['categories' => $category]);
    }
    public function restore(Request $request, $id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();
        return redirect()->route('dashboard.categories.trash')->with('success', 'category Restored');
    }
    public function forceDelete($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->forceDelete();
        if ($category['image']) {
            Storage::disk('public')->delete($category->image);
        }
        return redirect()->route('dashboard.categories.trash')->with('success', 'category delete forever');
    }
}
