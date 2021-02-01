<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Group;
use App\Models\Inventory;
use App\Models\Level;
use App\Models\Price;
use App\Models\Product;
use App\Models\Unit;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return view('admin.products.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $units = Unit::all();
        $groups = Group::all();
        $levels = Level::all();
        return view('admin.products.create',compact('categories','units','groups','levels'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        return $request;
            $validatedData = validator::make($request->all(), [
                'name'=> 'required|string',
                'category_id' => 'required|numeric',
                'sku'=> 'required|string',
                'shelving_location'=> 'required|string',
                'short_description'=> 'required|string',
                'description' => 'required|string',
                'meta_tags' => 'nullable|string',
                'meta_keywords' => 'nullable|string',
                'price_per' => 'required|numeric',
                'unit_id' => 'required|numeric',
                'weight' => 'required|numeric',
                'weight_unit_id'=> 'required|numeric',
                'available_quantity' => 'required|numeric',
                'low_quantity' => 'required|numeric',
                'min_order' => 'required|numeric',
                'quantity_cycle' => 'required|numeric',
                'price' => 'required|numeric',
                'sales_price' => 'nullable|numeric',
                'cost_price' => 'required|numeric',
                'images' => 'required'
            ]);
            if ($validatedData->fails()) {
//                return $validatedData->failed();
                alert()->warning('Something went wrong...');
                return back()->withErrors($validatedData)->withInput();
            }

//        return $request;
        $images = upload_files($request->images , '/products',true);
        $product = product::create  ([
                    'name'=> $request->name,
                    'slug' => $request->slug ?? make_slug($request->name),
                    'category_id' => $request->category_id,
                    'sku'=> $request->sku,
                    'shelving_location'=> $request->shelving_location,
                    'images' => json_encode($images),
                    'short_description'=> $request->short_description,
                    'description' => $request->description,
                    'meta_tags' => $request->meta_tags,
                    'meta_keywords' => $request->meta_keywords,
                    'price_per' => $request->price_per,
                    'unit_id' => $request->unit_id,
                    'weight' => $request->weight,
                    'weight_unit_id'=> $request->weight_unit_id,
                    'available_quantity' => $request->available_quantity,
                    'low_quantity' => $request->low_quantity,
                    'min_order' => $request->min_order,
                    'quantity_cycle' => $request->quantity_cycle,
                    'price' => $request->price ,
                    'sales_price' => $request->sales_price,
                    'cost_price' => $request->cost_price
                ]);
                $data = [
                    'product_id' => $product->id,
                    'count' => $request->available_quantity,
                    'cost_price' => $request->cost_price
                ];
                DB_create('inventories',$data);
                if($request->prices){
                    for($i = 0; $i < count($request->prices); $i++)
                    {
                        $price_list = [
                            'product_id' => $product->id,
                            'group_id' => $request->groups[$i],
                            'level_id' => $request->levels[$i],
                            'price' => $request->prices[$i]
                        ];
                        DB_create('prices',$price_list);
                    }
                }
                alert()->success('Product created successfully');
                return redirect(route('products.index'));


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $categories = Category::all();
        $units = Unit::all();
        $groups = Group::all();
        $levels = Level::all();
        $product = Product::findOrFail($id);
        $preloaded = [];
        if($product->images != 'null' && $product->images != '')
        {
            foreach (json_decode($product->images) as $img)
            {
                $object = ([
                    'id' => $img,
                    'src' => $img
                ]);
                array_push($preloaded,$object);
            }
        }
        $preloaded = json_encode($preloaded);
//        return $preloaded;
        return view('admin.products.edit',compact('categories','units','groups','levels','product','preloaded'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $validatedData = validator::make($request->all(), [
            'name'=> 'required|string',
            'category_id' => 'required|numeric',
            'sku'=> 'required|string',
            'shelving_location'=> 'required|string',
            'short_description'=> 'required|string',
            'description' => 'required|string',
            'meta_tags' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'price_per' => 'required|numeric',
            'unit_id' => 'required|numeric',
            'weight' => 'required|numeric',
            'weight_unit_id'=> 'required|numeric',
            'available_quantity' => 'required|numeric',
            'low_quantity' => 'required|numeric',
            'min_order' => 'required|numeric',
            'quantity_cycle' => 'required|numeric',
            'price' => 'required|numeric',
            'sales_price' => 'nullable|numeric',
            'cost_price' => 'required|numeric'
        ]);
        if ($validatedData->fails()) {
            return $validatedData->failed();
            alert()->warning('Something went wrong...');
            return back()->withErrors($validatedData)->withInput();
        }
        foreach(array_diff(json_decode($product->images) , $request->old) as $dif)
        {
            if(file_exists(public_path($dif)))
            {
                unlink(public_path($dif));
            }
        }
        if($request->photos){

            $images = upload_files($request->photos , '/products',true);
        }else{
            $images = [];
        }
        foreach($request->old as $img)
        {
            array_push($images,$img);
        }
        $product->update([
            'name'=> $request->name,
            'slug' => $request->slug ?? make_slug($request->name),
            'category_id' => $request->category_id,
            'sku'=> $request->sku,
            'shelving_location'=> $request->shelving_location,
            'images' => json_encode($images),
            'short_description'=> $request->short_description,
            'description' => $request->description,
            'meta_tags' => $request->meta_tags,
            'meta_keywords' => $request->meta_keywords,
            'price_per' => $request->price_per,
            'unit_id' => $request->unit_id,
            'weight' => $request->weight,
            'weight_unit_id'=> $request->weight_unit_id,
            'available_quantity' => $request->available_quantity,
            'low_quantity' => $request->low_quantity,
            'min_order' => $request->min_order,
            'quantity_cycle' => $request->quantity_cycle,
            'price' => $request->price ,
            'sales_price' => $request->sales_price,
            'cost_price' => $request->cost_price
        ]);
        Inventory::where('product_id','=',$product->id)->update([
            'count' => $request->available_quantity,
            'cost_price' => $request->cost_price
        ]);
        Price::where('product_id','=',$product->id)->delete();
        if($request->prices){
            for($i = 0; $i < count($request->prices); $i++)
            {
                $price_list = [
                    'product_id' => $product->id,
                    'group_id' => $request->groups[$i],
                    'level_id' => $request->levels[$i],
                    'price' => $request->prices[$i]
                ];
                DB_create('prices',$price_list);
            }
        }
        alert()->success('Product updated');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB_delete('products',$id);
        DB_delete('inventories',$id,'product_id');
        DB_delete('prices',$id,'product_id');
        alert()->success('Product deleted successfully');
        return redirect(route('products.index'));
    }
}
