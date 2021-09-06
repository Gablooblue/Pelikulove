<?php 

namespace App\Http\Controllers\Vendor\RiariForums;

use Forum;
use Auth;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\LearnerCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Riari\Forum\Frontend\Events\UserViewingCategory;
use Riari\Forum\Frontend\Events\UserViewingIndex;

class CategoryControllerNew extends BaseControllerNew
{
    /**
     * GET: Return an index of categories view (the forum index).
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $categories = $this->api('category.index')
                    ->parameters(['where' => ['category_id' => 0], 'orderBy' => 'weight', 'orderDir' => 'asc'])
                    ->get();

        event(new UserViewingIndex);

        // $userRole = Role::find(RoleUser::where('user_id', Auth::user()->id)->first()->role_id);

        // if (Auth::check() && $userRole->level >= 1) {
        //     dd(true);
        // } else {
        //     dd(false);
        // }
        // dd($categories); 
        
        $categories = $categories->filter(function ($category) {
            if ($category->private == 1) {    
                if (LearnerCourse::ifEnrolled($category->course_id, Auth::user()->id)) {
                    return $category;
                } 
            } else {     
                return $category;
            }
        }); 

        return view('forum::category.index', compact('categories'));
    }

    /**
     * GET: Return a category view.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $category = $this->api('category.fetch', $request->route('category'))->get();

        event(new UserViewingCategory($category));

        $categories = [];
        if (Gate::allows('moveCategories')) {
            $categories = $this->api('category.index')->parameters(['where' => ['category_id' => 0]])->get();
        }

        $threads = $category->threadsPaginated;

        // dd($category, $categories);
        
        if ($category->private == 1) {
            if (!LearnerCourse::ifEnrolled($category->course_id, Auth::user()->id)) {
                return redirect('/forum')
                ->with(['message' => 'Category is private', 
                'status' => 'danger']);	
            }
        }

        return view('forum::category.show', compact('categories', 'category', 'threads'));
    }

    /**
     * POST: Store a new category.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $category = $this->api('category.store')->parameters($request->all())->post();

        Forum::alert('success', 'categories.created');

        return redirect(Forum::route('category.show', $category));
    }

    /**
     * PATCH: Update a category.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $action = $request->input('action');

        $category = $this->api("category.{$action}", $request->route('category'))->parameters($request->all())->patch();

        Forum::alert('success', 'categories.updated', 1);

        return redirect(Forum::route('category.show', $category));
    }

    /**
     * DELETE: Delete a category.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $this->api('category.delete', $request->route('category'))->parameters($request->all())->delete();

        Forum::alert('success', 'categories.deleted', 1);

        return redirect(config('forum.routing.prefix'));
    }
}
