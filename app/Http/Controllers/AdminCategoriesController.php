<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Catalog;
use Validator;
use Carbon\Carbon;

class AdminCategoriesController extends Controller
{
    public function __construct ()
    {
        $this->middleware('admin');
    }

    public function list($id=null)
    {
        $categories = Catalog::leftJoin('catalogs as cat_parent', 'cat_parent.id' , '=', 'catalogs.parent_id')
            ->get(['catalogs.*', 'cat_parent.name as parent_name']);

            $parentCategories = Catalog::all('id', 'name');
            $category = null;
            if($id)
            {
                $category = Catalog::find($id);
            }
            $counts = Catalog::count();
        return view('admin.categories', ['categories' => $categories , 'category'=>$category, 'parent_categories_names' => $parentCategories, 'counts'=>$counts]);
    }


    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required | min:3 | max:30',
            'priority' => 'max:99',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }


        if ($request->id) {
            $category = Catalog::find($request->id);
            $message = 'Category '. $request->name .' was changed!';
        } else {
            $category = new Catalog;
            $message = 'Category '. $request->name .' was added!';
        }

        $category->name = $request->name;
        $category->priority = $request->priority;
        $category->description = $request->description;
        if ($request->parent)
        {
            $category->parent_id = $request->parent;
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = 'cat_'.time().'.'.$image->getClientOriginalExtension();
            $imageDestinationPath = public_path('images/categories/');
            $image->move($imageDestinationPath, $imageName);
            $category->image = 'images/categories/'.$imageName;
        }
        //todo image resize

        $category->save();
        return 'success';
        // return redirect(url('admin/categories'))->with('message', $message);
    }

    public function delete( Request $request)
    {


        $category = Catalog::find($request->id);

        if (!$category) return back()->withErrors('Server Error... Category not found');

        if($category->products()->first())
        {
            return back()->withErrors('Canceled. Category '.$category->name.' has a children Products!');
        }

        $children = Catalog::where('parent_id', $category->id)->first();
        if ($children){
            return "failed";
        }

        $category->delete();
        return 'success';

    }



    // Ajax fetch
    public function fetch_category_details(Request $request)
    {

     if($request->id)
     {
         $id = $request->id;
        //  $row = Catalog::select('catalogs.id AS id', 'catalogs.name AS name', 'catalogs.parent AS parent, '')->where('id',$id)->first();
         $row = Catalog::select('*')->where('id',$id)->first();
         $response = json_encode($row);
         return $response;
     }
    }


}
