<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Validator;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {

        date_default_timezone_set('Asia/Manila');
        $categories = Category::latest()->get();

        return view('admin.categories', compact('categories'));

        return abort('403');
    }

    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        $validated =  Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
        ]);

        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()]);
        }

        Category::create([
            'name' => $request->input('name'),
        ]);
        Activity::create([
            'activity' => 'Created category',
            'user_id' => Auth::user()->id
        ]);

        return response()->json(['success' => 'Added Successfully.']);
    }

    public function edit(Category $category)
    {
        if (request()->ajax()) {
            return response()->json(
                ['result' =>  $category]
            );
        }
    }


    public function update(Request $request, Category $category)
    {
        date_default_timezone_set('Asia/Manila');
        $validated =  Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
        ]);

        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()]);
        }

        Category::find($category->id)->update([
            'name' => $request->input('name'),
        ]);
        Activity::create([
            'activity' => 'Updated category',
            'user_id' => Auth::user()->id
        ]);

        return response()->json(['success' => 'Updated Successfully.']);
    }


    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json(['success' =>  'Removed Successfully.']);
    }
}
