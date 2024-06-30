<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Models\Department;
use App\Models\Material;
use App\Models\Product;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with(["department", 'materials'])->paginate(6);
        $canDeleteProducts = [];
        $canUpdateProducts = [];

        foreach ($products as $p) {
            $canDeleteProducts[] = \Auth::user()->can('delete', $p);
            $canUpdateProducts[] = \Auth::user()->can('update', $p);
        }


        return Inertia::render('products/Products', [
            'products' => $products,
            'canCreateProducts' => \Auth::user()->can("create", Product::class),
            'canDeleteProducts' => $canDeleteProducts,
            'canUpdateProducts' => $canUpdateProducts,
            'departments' => Department::get(),
            'materials' => Material::get()
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request)
    {
        \Gate::authorize('create', Product::class);

        $data = $request->validated();

        $product = Product::create([
            "name" => $data['name'],
            "price" => $data['price'],
            "department_id" => $data['department_id'],
        ]);
        $product->materials()->syncWithoutDetaching($data['materials_id']);

        return back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @throws AuthorizationException
     */
    public function destroy(Product $product)
    {
        \Gate::authorize('delete', $product);
        Product::destroy($product->id);
        return back();
    }
}
