<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\PropertyValue;
use App\Models\Product;
use App\Models\Catalog;

class AdminProductsController extends Controller
{
    public function __construct ()
    {
        $this->middleware('admin');
    }

    public function list ()
    {
        //todo app settings
        $products = Product::paginate(15);
        $categories = Catalog::all('id', 'name');
        $counts = Product::count();
        return view('admin.products', ['products' => $products, 'categories' => $categories, 'counts'=>$counts]);
    }

    public function categoryFilter (Request $request, $category_id)
    {
        $products = $category_id ?
            Product::where('catalog_id', $category_id)->paginate(10) :
            Product::paginate(10);

        if ($request->ajax()) {
            return view('admin.products-load', compact('products'))->render();
        }

        $categories = Catalog::all('id', 'name');
        return view('admin.products', ['products' => $products, 'categories' => $categories]);
    }

    public function delete (Request $request)
    {

        if (!$request->id) return back()->withErrors('Server Error... Please try again.');

        $product = Product::find($request->id);

        if (!$product) return back()->withErrors('Server Error... Product not found');

        $product->delete();
        return 'success';
    }

    //Remove property from product
    public function deleteProperty (Request $request, $product_id)
    {
        if (!$request->value_id) return back()->withErrors('Server Error... Please try again.');

        $product = Product::find($product_id);

        if (!$product) return back()->withErrors('Server Error... Product not found');

        $product->properties()->detach($request->value_id);

        return $request->value_id;
    }

    public function showEditForm ($id = null)
    {
        $categories = Catalog::all('id', 'name');
        $product = null;
        if ($id) {
            $product = Product::find($id);
        }
        if ($id && !$product) {
            return back()->withErrors('Server Error... Product not found');
        }
        if (isset($product->properties)) {
            foreach ($product->properties as $property) {
                if ($property->properties->type === 'selector') {
                    $property->properties->selectProperties = PropertyValue::where('property_id', $property->properties->id)->pluck( 'value', 'id');
                }
            }
        }
        return view('admin.edit-product', ['product' => $product, 'categories' => $categories]);
    }

    public function update (Request $request)
    {
        $this->validate($request, [
            'name' => 'required | min:3 | max:150',
            'price' => 'required | min:1 | max:10',
            'image' => 'image  | max:2048',
            'category' => 'required'
        ]);
        if ($request->id) {
            $product = Product::find($request->id);
            $message = 'Product ' . $request->name . ' was changed!';
        } else {
            $product = new Product;
            $message = 'Product ' . $request->name . ' was added!';
        }

        //update properties
        $propertyValueIds = [];
        if (isset($request->propertyIds)) {
            foreach ($request->propertyIds as $key => $propertyId) {
                //validate if type of property is "number"
                if ($request->propertyTypes[$key] === 'number') {
                    $this->validate($request, [
                        'propertyValues.'.$key => 'numeric'
                    ],
                    [
                        'propertyValues.'.$key.'.numeric' => 'The property '.Property::find($propertyId)->name.' must be a number',
                    ]);
                }

                $propertyValues = PropertyValue::firstOrCreate(
                    ['value' => $request->propertyValues[$key], 'property_id' => $propertyId]
                );
                $propertyValueIds[] = $propertyValues->id;
            }
        }

        $product->properties()->sync($propertyValueIds);

        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->catalog_id = $request->category;
        $product->availability = $request->availability;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = 'prod_' . time() . '.' . $image->getClientOriginalExtension();
            $imageDestinationPath = public_path('images/products/');
            $image->move($imageDestinationPath, $imageName);
            $product->image = 'products/' . $imageName;
        }
        //todo image resize

        $product->save();

        return 'success';
    }

    public function getProperties (Request $request, $product_id)
    {
        $product = Product::find($product_id);

        if (!$product) return back()->withErrors('Server Error... Product not found');

        if ($request->ajax()) {
            return view('admin.product-properties', compact('product'))->render();
        }
    }

    // Ajax fetch
    public function fetch_product_details(Request $request)
    {

     if($request->id)
     {
         $id = $request->id;
        //  $row = Catalog::select('catalogs.id AS id', 'catalogs.name AS name', 'catalogs.parent AS parent, '')->where('id',$id)->first();
         $row = Product::where('products.id',$id)->select('products.*','cat.id
         as cat_id', 'cat.name as cat_name', 'products.image as prod_image', 'products.id as prod_id')->Join('catalogs as cat', 'cat.id', '=', 'products.catalog_id')->first();
         $response = json_encode($row);
         return $response;
     }
    }
}
