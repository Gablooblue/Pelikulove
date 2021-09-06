<?php

namespace App\Http\Controllers;

use Auth;
use Validator;
use View;
use App\Models\Vod;
use App\Models\VodPurchase;
use App\Models\VodCategory;
use App\Models\VodSlideshow;
use App\Models\Service;
use App\Models\Order;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class VodAdminManagementController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vodCategories = VodCategory::orderBy('corder', 'asc')
        ->get();

        $vodSlideshows = VodSlideshow::all();

        // dd(sizeOf($vodSlideshows));
        
        // dd(Vod::getAllVodsByCategory($vodCategories[0]->id));

    	return view('vodsmanagement.index', compact('vodCategories', 'vodSlideshows')); 
    }

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// SLIDESHOW START
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function showSlideshow()
    {  
        $vodSlideshows = VodSlideshow::all();
        
        return view('vodsmanagement.show-slideshow', compact('vodSlideshows')); 
    }

    public function createSlideshow()
    {
        
    }

    public function storeupdateSlideshow(Request $request)
    {
        
    }

    public function editSlideshow($slide_id)
    {
        
    }

    public function updateSlideshow(Request $request, $slide_id)
    {
        
    }

    public function removeSlide($slide_id)
    {
        $slide = VodSlideshow::find($vod_id);

        if (!isset($slide)) {
            return redirect()->route('blackbox-admin')->with([
                'message' => "Slide does not exist", 'status', 'danger'
           ]);;
        }        

        $slide->delete();

        $vodSlideshows = VodSlideshow::orderBy('vorder', 'asc')
        ->get();

        $categoryVods = Vod::where('category_id', $category_id)
        ->orderBy('vorder', 'asc')
        ->get();
        
        for ($index = 0; $index < sizeOf($categoryVods); $index++) {
            $categoryVods[$index]->vorder = $request->input('vorder_' . $index);
            $categoryVods[$index]->save();    
        } 	
        
        \Session::flash(
            'success', 
            'Vod ' . $vod->title . ' has been successfully removed.');
            
        return redirect()->route('vodsmanagement.showCategory', $category_id);
    }
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////    
// SLIDESHOW END
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// VIDEO CATEGORY START
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function createCategory()
    {
        $vodCategories = VodCategory::orderBy('corder', 'asc')
        ->get();

        return View('vodsmanagement.create-category', compact('vodCategories'));
    }

    public function storeCategory(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'name'                          => 'required',
                // 'description'                   => 'required',
                'categoryOrder'                 => 'required',
            ],
            [
                'name.required'                 => "Vod Category name is required.",
                // 'description.required'          => "Description of the Vod Category is required.",
                'categoryOrder.required'        => "Category Order is required.",
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $newCorder = $request->input('categoryOrder');

        $exist = VodCategory::where('corder', $newCorder)
        ->orderBy('corder', 'asc')
        ->first();

        if (isset($exist)) {
            $vodCategories = VodCategory::orderBy('corder', 'asc')
            ->get();

            foreach ($vodCategories as $vodCategory) {
                if ($vodCategory->corder >= $newCorder) {
                    $vodCategory->corder = $vodCategory->corder+1;
                    $vodCategory->save();    
                }
            }
        }

        if ($request->input('hidden') == 'on') {
            $hidden = 1;
        } else {
            $hidden = 0;
        }

        $vodCategory = VodCategory::create([
            'name'              => $request->input('name'),
            'description'       => $request->input('description'),
            'hidden'       => $hidden,
            'corder'            => $newCorder,
        ]);

        $vodCategory->save();        	
        
        \Session::flash(
            'success', 
            'Category ' . $request->input('name') . ' has been successfully created.');
            
        return redirect('blackbox-admin')->with('info', 'Category: ' . $vodCategory->name . ' has been successfully added.');
    }

    public function rearrangeCategory()
    {
        $vodCategories = VodCategory::orderBy('corder', 'asc')
        ->get();

        return View('vodsmanagement.rearrange-category', compact('vodCategories'));
    }

    public function storeRearrangedCategory(Request $request)
    {
        $vodCategories = VodCategory::orderBy('corder', 'asc')
        ->get();
        
        for ($index = 0; $index < sizeOf($vodCategories); $index++) {
            $vodCategories[$index]->corder = $request->input('corder_' . $index);
            $vodCategories[$index]->save();    
        }  	
        
        \Session::flash(
            'success', 
            'Categories has been successfully rearranged.');
            
        return View('vodsmanagement.rearrange-category', compact('vodCategories'));
    }

    public function editCategory ($id)
    {           
        $vodCategory = VodCategory::find($id);
                  
        if (!isset($vodCategory)) : 
            return back()->with('danger', 'Vod Category does not exist.');
        endif; 

        $vodCategories = VodCategory::orderBy('corder', 'asc')
        ->get();
        
        return View('vodsmanagement.edit-category', compact('vodCategory', 'vodCategories'));
    }
    
    public function updateCategory (Request $request, $id)
    {
        $vodCategory = VodCategory::find($id);

        $validator = Validator::make($request->all(),
            [
                'name'                          => 'required',
                // 'description'                   => 'required',
                'categoryOrder'                 => 'required',
            ],
            [
                'name.required'                 => "Vod Category name is required.",
                // 'description.required'          => "Description of the Vod Category is required.",
                'categoryOrder.required'        => "Category Order is required.",
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } 

        $newCorder = $request->input('categoryOrder');
        $currentCorder = $vodCategory->corder;

        $exist = VodCategory::where('corder', $newCorder)
        ->orderBy('corder', 'asc')
        ->first();

        if (isset($exist)) {
            $vodCategories = VodCategory::orderBy('corder', 'asc')
            ->get();

            foreach ($vodCategories as $category) {
                $iterationCorder = $category->corder;

                // Check if change is low number to high number or vice versa                
                if ($currentCorder < $newCorder) {
                    // If low to high
                    if ($iterationCorder >= $currentCorder && $iterationCorder <= $newCorder) {
                        if ($iterationCorder == $currentCorder) {
                            // if iteration is = to current corder, swap values
                            $category->corder = $newCorder;
                            $category->save(); 
                        } else if ($iterationCorder <= $newCorder) {
                            // if iteration is <= to new corder, subtract
                            $category->corder = $category->corder-1;
                            $category->save();    
                        } else {
                        }
                    } else {
                    }

                } else if ($currentCorder > $newCorder) { 
                    // If high to low
                    if ($iterationCorder <= $currentCorder && $iterationCorder >= $newCorder) {
                        if ($iterationCorder == $currentCorder) {
                            // if iteration is = to current corder, swap values
                            $category->corder = $newCorder;
                            $category->save();    
                        } else if ($iterationCorder >= $newCorder) {
                            // if iteration is >= to new corder, add
                            $category->corder = $category->corder+1;
                            $category->save(); 
                        } else {
                        }
                    } else {
                    }
                }
            }

        }          
        
        $vodCategory->name = $request->input('name');
        $vodCategory->description = $request->input('description');
        $vodCategory->corder = $request->input('categoryOrder');
        if ($request->input('hidden') == 'on') {
            $vodCategory->hidden = 1;
        } else {
            $vodCategory->hidden = 0;
        }

        $vodCategory->save();
        
        return back()->with('success', 'Successfully Updated Vod Category!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function showCategory($category_id)
    {
        $vodCategory = VodCategory::find($category_id);
        $categoryVods = Vod::where('category_id', $category_id)
        ->orderBy('vorder', 'asc')
        ->get();

        // if (!isset($vodCategory) || count($categoryVods) <= 0) {            
        //     return redirect('blackbox-admin');
        // }

        return view('vodsmanagement.show-category', compact('vodCategory', 'categoryVods')); 
    }
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// VIDEO CATEGORY END
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// VIDEOS START
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function rearrangeCategoryVods($category_id)
    {
        $category = VodCategory::find($category_id);

        if (!isset($category_id)) {
            return redirect()->route('blackbox-admin');
        }

        $categoryVods = Vod::where('category_id', $category_id)
        ->orderBy('vorder', 'asc')
        ->get();

        return View('vodsmanagement.rearrange-vods', compact('categoryVods', 'category'));
    }

    public function storeRearrangedCategoryVods(Request $request, $category_id)
    {
        $category = VodCategory::find($category_id);

        if (!isset($category_id)) {
            return redirect()->route('blackbox-admin');
        }

        $categoryVods = Vod::where('category_id', $category_id)
        ->orderBy('vorder', 'asc')
        ->get();
        
        for ($index = 0; $index < sizeOf($categoryVods); $index++) {
            $categoryVods[$index]->vorder = $request->input('vorder_' . $index);
            $categoryVods[$index]->save();    
        }
        
        \Session::flash (
            'success', 
            'Vods of ' . $category->name . ' has been successfully rearranged.');

        return View('vodsmanagement.rearrange-vods', compact('categoryVods', 'category'));
    }

    public function createVod($category_id)
    {
        $category = VodCategory::find($category_id);
        $vodCategories = VodCategory::orderBy('corder', 'asc')
        ->get();
        $vods = Vod::orderBy('category_id', 'asc')
        ->orderBy('vorder', 'asc')
        ->get();

        return View('vodsmanagement.create-vod', compact('vodCategories', 'category', 'vods'));
    }

    public function storeVod(Request $request, $category_id)
    {
        $validator = Validator::make($request->all(),
            [
                'title'                         => 'required',
                'short_title'                   => 'required',
                'category_id'                   => 'required',
                'vorder'                        => 'required',
                'duration'                      => 'required',
                'thumbnail'                      => 'required',
                'paid'                          => 'required',
            ],
            [
                'title'                         => 'Vod Title is required',
                'short_title'                   => 'Vod Short Title is required',
                'category_id'                   => 'Category is required',
                'vorder'                        => 'Vod Order is required',
                'duration'                      => 'Vod Duration is required',
                'thumbnail'                      => 'Vod Thumbnail is required',
                'paid'                          => 'Vod Payment is required',
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $newVorder = $request->input('vorder');

        $exist = Vod::where('vorder', $newVorder)
        ->where('category_id', $category_id)
        ->orderBy('vorder', 'asc')
        ->first();

        if (isset($exist)) {
            $categoryVods = Vod::where('category_id', $category_id)
            ->orderBy('vorder', 'asc')
            ->get();

            foreach ($categoryVods as $categoryVod) {
                if ($categoryVod->vorder >= $newVorder) {
                    $categoryVod->vorder = $categoryVod->vorder+1;
                    $categoryVod->save();    
                }
            }
        }

        if ($request->input('hidden') == 'on') {
            $hidden = 1;
        } else {
            $hidden = 0;
        }

        if ($request->input('private') == 'on') {
            $private = 1;
        } else {
            $private = 0;
        }

        if ($request->input('donate_btn') == 'on') {
            $donate_btn = 1;
        } else {
            $donate_btn = 0;
        }

        $vod = Vod::create([
            'title'                         => $request->input('title'),
            'short_title'                   => $request->input('short_title'),
            'category_id'                   => $request->input('category_id'),
            'vorder'                        => $request->input('vorder'),
            'description'                   => $request->input('description'),
            'description_2'                 => $request->input('description_2'),
            'year_released'                 => $request->input('year_released'),
            'duration'                      => $request->input('duration'),
            'hidden'                        => $hidden,
            'private'                       => $private,
            'donate_btn'                    => $donate_btn,
            'thumbnail'                     => $request->input('thumbnail'),
            'video'                         => $request->input('video'),
            'transcript'                    => $request->input('transcript'),
            'paid'                          => $request->input('paid'),
            'created_by'                    => Auth::user()->id,
            'updated_by'                    => NULL,
            'published_at'                  => Carbon::now()->format('Y-m-d'),
        ]);

        $vod->save();           

        if ($request->input('paid') == 1) {
            $service = Service::create([
                'name'                      => $request->input('s_name'),
                'vod_id'                    => $vod->id,
                'description'               => $request->input('s_description'),
                'duration'                  => $request->input('s_duration'),
                'amount'                    => $request->input('amount'),
            ]);

            $service->save();      
        }  	
        
        \Session::flash(
            'success', 
            'Video ' . $request->input('name') . ' has been successfully added.');
            
        return redirect()->route('vodsmanagement.showCategory', $category_id);
    }

    public function editVod ($category_id, $vod_id)
    {           
        $vod = Vod::find($vod_id);
                  
        if (!isset($vod)) : 
            return back()->with(['message' => "Video does not exist.", 'status' => 'danger']);
        endif; 

        $category = VodCategory::find($category_id);
        $vodCategories = VodCategory::orderBy('corder', 'asc')->get();
        $vods = Vod::orderBy('category_id', 'asc')
        ->orderBy('vorder', 'asc')
        ->get();
        $services = Service::where('vod_id', $vod->vod_id)->first();
                  
        if (!isset($category)) : 
            $category = collect();
        endif; 
                  
        if ($vod->paid == 1) : 
            $services = Service::where('vod_id', $vod_id)
            ->get();
        else : 
            $services = NULL;
        endif; 
        
        return View('vodsmanagement.edit-vod', compact('vod', 'category', 'services', 'vodCategories', 'vods'));
    }
    
    public function updateVod (Request $request, $category_id, $vod_id)
    {     
        $vod = Vod::find($vod_id);        
        $vodCategory = VodCategory::find($category_id);

        if (!isset($vod)) {
            return back()->with(['message' => "Video does not exist.", 'status' => 'danger']);
        }
        if (!isset($vod)) {
            return back()->with(['message' => "Video Category does not exist.", 'status' => 'danger']);
        }

        $validator = Validator::make($request->all(),
            [
                'title'                         => 'required',
                'short_title'                   => 'required',
                'category_id'                   => 'required',
                'vorder'                        => 'required',
                'duration'                      => 'required',
                'thumbnail'                     => 'required',
                'paid'                          => 'required',
            ],
            [
                'title'                         => 'Vod Title is required',
                'short_title'                   => 'Vod Short Title is required',
                'category_id'                   => 'Category is required',
                'vorder'                        => 'Vod Order is required',
                'duration'                      => 'Vod Duration is required',
                'thumbnail'                     => 'Vod Thumbnail is required',
                'paid'                          => 'Vod Payment is required',
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $newVorder = $request->input('vorder');
        $currentVorder = $vod->vorder;

        $exist = Vod::where('vorder', $newVorder)
        ->where('category_id', $category_id)
        ->orderBy('vorder', 'asc')
        ->first();

        if (isset($exist)) {
            $categoryVods = Vod::where('category_id', $category_id)
            ->orderBy('vorder', 'asc')
            ->get();

            foreach ($categoryVods as $categoryVod) {
                $iterationVorder = $categoryVod->vorder;

                // Check if change is low number to high number or vice versa                
                if ($currentVorder < $newVorder) {
                    // If low to high
                    if ($iterationVorder >= $currentVorder && $iterationVorder <= $newVorder) {
                        if ($iterationVorder == $currentVorder) {
                            // if iteration is = to current vorder, swap values
                            $categoryVod->vorder = $newVorder;
                            $categoryVod->save(); 
                        } else if ($iterationVorder <= $newVorder) {
                            // if iteration is <= to new vorder, subtract
                            $categoryVod->vorder = $categoryVod->vorder-1;
                            $categoryVod->save();    
                        } else {
                        }
                    } else {
                    }

                } else if ($currentVorder > $newVorder) { 
                    // If high to low
                    if ($iterationVorder <= $currentVorder && $iterationVorder >= $newVorder) {
                        if ($iterationVorder == $currentVorder) {
                            // if iteration is = to current vorder, swap values
                            $categoryVod->vorder = $newVorder;
                            $categoryVod->save();    
                        } else if ($iterationVorder >= $newVorder) {
                            // if iteration is >= to new vorder, add
                            $categoryVod->vorder = $categoryVod->vorder+1;
                            $categoryVod->save(); 
                        } else {
                        }
                    } else {
                    }
                }
            }
        }   

        if ($request->input('hidden') == 'on') {
            $hidden = 1;
        } else {
            $hidden = 0;
        }

        if ($request->input('private') == 'on') {
            $private = 1;
        } else {
            $private = 0;
        }

        if ($request->input('donate_btn') == 'on') {
            $donate_btn = 1;
        } else {
            $donate_btn = 0;
        } 
        
        $vod->title = $request->input('title');
        $vod->short_title = $request->input('short_title');
        $vod->category_id = $request->input('category_id');
        $vod->vorder = $request->input('vorder');
        $vod->description = $request->input('description');
        $vod->description_2 = $request->input('description_2');
        $vod->year_released = $request->input('year_released');
        $vod->duration = $request->input('duration');
        $vod->hidden = $hidden;
        $vod->private = $private;
        $vod->donate_btn = $donate_btn;
        $vod->thumbnail = $request->input('thumbnail');
        $vod->video = $request->input('video');
        $vod->transcript = $request->input('transcript');
        $vod->paid = $request->input('paid');
        $vod->updated_by = Auth::user()->id;
        $vod->published_at = Carbon::now()->format('Y-m-d');

        // dd($request, $vod);

        $vod->save();           

        if ($request->input('paid') == 1) {
            $service = Service::create([
                'name'                      => $request->input('s_name'),
                'vod_id'                    => $vod->id,
                'description'               => $request->input('s_description'),
                'duration'                  => $request->input('s_duration'),
                'amount'                    => $request->input('amount'),
            ]);

            $service->save();      
        }  	
        
        return back()->with('success', 'Successfully Updated Video!');
    }

    public function removeVod($category_id, $vod_id)
    {
        if (!isset($category_id)) {
            return redirect()->route('blackbox-admin')->with([
                'message' => "Vod Category does not exist", 'status', 'danger'
           ]);;
        }        

        if (!isset($vod_id)) {
            return redirect()->route('blackbox-admin')->with([
                'message' => "Vod does not exist", 'status', 'danger'
           ]);;
        }

        $vod = Vod::find($vod_id);        
        $currentVorder = $vod->vorder;
        $categoryVods = Vod::where('category_id', $category_id)
        ->orderBy('vorder', 'asc')
        ->get();

        foreach ($categoryVods as $categoryVod) {
            $iterationVorder = $categoryVod->vorder;

            // Check if change is low number to high number or vice versa   
            if ($iterationVorder > $currentVorder) {
                // if iteration is <= to new vorder, subtract
                $categoryVod->vorder = $categoryVod->vorder-1;
                $categoryVod->save();    
            }
        }	

        $vod->delete();
        
        \Session::flash(
            'success', 
            'Vod ' . $vod->title . ' has been successfully removed.');
            
        return redirect()->route('vodsmanagement.showCategory', $category_id);
    }
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// VIDEOS START
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// VIDEO SERVICES START
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function showServices($category_id, $vod_id)
    {
        $services = Service::join('vods', 'services.vod_id', '=', 'vods.id')
        ->where('vods.id', $vod_id)
        ->select('services.*', 'vods.title', 'vods.short_title', 'vods.category_id')
        ->get();

        // dd($services);

        return view('vodsmanagement.show-services', compact('services')); 
    }

    public function createService($category_id, $vod_id)
    {
        $vod = Vod::find($vod_id);        
        $vodCategory = VodCategory::find($category_id);

        if (!isset($vod)) {
            return back()->with(['message' => "Video does not exist.", 'status' => 'danger']);
        }
        if (!isset($vod)) {
            return back()->with(['message' => "Video Category does not exist.", 'status' => 'danger']);
        }

        $vod = Vod::find($vod_id);

        return View('vodsmanagement.create-service', compact('vod'));
    }

    public function storeVodService(Request $request, $category_id, $vod_id)
    {
        $vod = Vod::find($vod_id);        
        $vodCategory = VodCategory::find($category_id);

        if (!isset($vod)) {
            return back()->with(['message' => "Video does not exist.", 'status' => 'danger']);
        }
        if (!isset($vod)) {
            return back()->with(['message' => "Video Category does not exist.", 'status' => 'danger']);
        }

        $validator = Validator::make($request->all(),
            [
                'serviceName'                   => 'required|max:255',
                // 'description'                   => 'required',
                'amount'                        => "required|numeric|between:0.00,999999.99",
                'duration'                      => "required|numeric|between:0.01,999999.99",
            ],
            [
                'serviceName.required'          => "Service name is required.",
                // 'description.required'          => "Description of the service is required.",
                'amount.required'               => "The price of the service is required.",
                'duration.required'             => "Duration of the service is required.",
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if ($request->input('available') == 'on') {
            $available = 1;
        } else {
            $available = 0;
        }

        $service = Service::create([
            'name'              => $request->input('serviceName'),
            'vod_id'            => $vod->id,
            'description'       => $request->input('description'),
            'amount'            => $request->input('amount'),
            'available'         => $available,
            'duration'          => $request->input('duration'),
        ]);

        $service->save();        	
        
        \Session::flash(
            'success', 
            'Service ' . $request->input('serviceName') . ' has been successfully created.');
            
        $services = Service::join('vods', 'services.vod_id', '=', 'vods.id')
        ->select('services.*', 'vods.title', 'vods.short_title', 'vods.category_id')
        ->get();

        return redirect()->route('vodsmanagement.showServices', [$category_id, $vod_id]);
    }

    public function editVodService ($category_id, $vod_id, $service_id)
    {     
        $vod = Vod::find($vod_id);        
        $vodCategory = VodCategory::find($category_id);
        $service = Service::find($service_id);   

        if (!isset($vod)) {
            return back()->with(['message' => "Video does not exist.", 'status' => 'danger']);
        }
        if (!isset($vod)) {
            return back()->with(['message' => "Video Category does not exist.", 'status' => 'danger']);
        }             

        if (!isset($service)) {
            return back()->with(['message' => "Service does not exist.", 'status' => 'danger']);
        }

        $service = Service::find($service_id);
        $vod = Vod::find($vod_id);
        
        return View('vodsmanagement.edit-service', compact('service', 'vod'));
    }
    
    public function updateVodService (Request $request, $category_id, $vod_id, $service_id)
    {      
        $vod = Vod::find($vod_id);        
        $vodCategory = VodCategory::find($category_id);
        $service = Service::find($service_id);   

        if (!isset($vod)) {
            return back()->with(['message' => "Video does not exist.", 'status' => 'danger']);
        }
        if (!isset($vod)) {
            return back()->with(['message' => "Video Category does not exist.", 'status' => 'danger']);
        }             

        if (!isset($service)) {
            return back()->with(['message' => "Service does not exist.", 'status' => 'danger']);
        }

        $validator = Validator::make($request->all(),
            [
                'serviceName'                   => 'required|max:255',
                // 'description'                   => 'required',
                'amount'                        => "required|numeric|between:0.00,999999.99",
                'duration'                      => "required|numeric|between:0.01,999999.99",
            ],
            [
                'serviceName.required'          => "Service name is required.",
                // 'description.required'          => "Description of the service is requried.",
                'amount.required'               => "The price of the service is required.",
                'duration.required'             => "Duration of the service is required.",
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }   

        if ($request->input('available') == 'on') {
            $available = 1;
        } else {
            $available = 0;
        }           
        
        $service->name = $request->input('serviceName');
        $service->description = $request->input('description');
        $service->amount = $request->input('amount');
        $service->available = $available;
        $service->duration = $request->input('duration');  
        // dd($service);
        $service->save();       
        
        \Session::flash(
            'success', 
            'Successfully updated Service!');
        
        return back()->with('success', 'Successfully Updated Service!');
    }
    
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// VIDEO SERVICES END
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

}
