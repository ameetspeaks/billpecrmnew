<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CommonController;

use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

use DataTables;
use App\Models\Category;
use App\Models\TemplateCategory;
use App\Models\TemplateMarket;
use App\Models\Product;
use App\Models\TemplateOffer;
use App\Models\TemplateType;


class TemplateController extends Controller
{
    public function marketing()
    {
        $marketTemp = TemplateMarket::all();
        $cate = TemplateCategory::all();
        return view('admin.template.marketing.index', compact('cate','marketTemp'));
    }

    public function marketingAdd()
    {
        $categories = TemplateCategory::all();
        $types = TemplateType::all();
        return view('admin.template.marketing.add', compact('categories','types'));
    }

    public function marketingStore(Request $request)
    {
        DB::beginTransaction();
        
        $rules = [
            'category_id' => 'required',
            'name' => 'required',
            'productImage' => 'required',
        ];

        $requestData = $request->all();
        $validator = Validator::make($requestData, $rules);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        } else {

            foreach($request->productImage as $image)
            {
                #save image
                if ($image) {
                    $path  = config('image.profile_image_path_view');
                    $image = CommonController::saveImage($image, $path, 'marketTemplate');
                }else{
                    $image = null;
                }

                $tempMarket = TemplateMarket::create([
                    'category_id'  => $request->category_id,
                    'template_type_id'  => $request->type_id,
                    'template_name'  => $request->name,
                    'template_image'  => $image,
                ]);
            }
           
            DB::commit();
            return redirect()->route('admin.template.marketing')->with('message', 'Template Created successfully');
        }
    }

    public function fetchMarketGallery($id)
    {
        $marketTemp = TemplateMarket::where('category_id',$id)->get();
        if(count($marketTemp)==0){
            return ['status'=>0];
        }
        return ['status'=>1,'data'=>$marketTemp];
    }
  
    public function offer()
    {
        $offerTemp = TemplateOffer::all();
        $cate = TemplateCategory::all();
        return view('admin.template.offer.index', compact('cate','offerTemp'));
    }

    public function offerAdd()
    {
        $products = Product::all();
        $categories = TemplateCategory::all();
        return view('admin.template.offer.add', compact('categories','products'));
    }

    public function offerStore(Request $request)
    {
        DB::beginTransaction();
        
        $rules = [
            'category_id' => 'required',
            'name' => 'required',
            'productImage' => 'required',
        ];

        $requestData = $request->all();
        $validator = Validator::make($requestData, $rules);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        } else {
           
            foreach($request->productImage as $image)
            {
                #save image
                if ($image) {
                    $path  = config('image.profile_image_path_view');
                    $image = CommonController::saveImage($image, $path, 'offerTemplate');
                }else{
                    $image = null;
                }

                $offerMarket = TemplateOffer::create([
                    'category_id'  => $request->category_id,
                    'product_id'  => $request->product_id,
                    'name'  => $request->name,
                    'image'  => $image,
                ]);
            }
           
            DB::commit();
            return redirect()->route('admin.template.offer')->with('message', 'Offer Created successfully');
        }
    }

    public function fetchOfferGallery($id)
    {
        $offerTemp = TemplateOffer::where('category_id',$id)->get();
        if(count($offerTemp)==0){
            return ['status'=>0];
        }
        return ['status'=>1,'data'=>$offerTemp];
    }
}
