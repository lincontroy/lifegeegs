<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\ProfileRequest;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Auth;
class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */
    public function index()
    {
        abort_if(!Auth()->user()->can('profile.index'), 401);
        return view('admin.profile.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View|Response
     */
    public function create()
    {
        abort_if(!Auth()->user()->can('profile.create'), 401);
        return view('admin.profile.edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProfileRequest $request
     * @return JsonResponse
     */
    public function store(ProfileRequest $request): JsonResponse
    {
         $validatedData = $request->validate([
             'name' => 'required|max:255',
             'email'  =>  'required|email|unique:users,email,'.Auth::id(),
             'phone'  =>  'required|numeric|unique:users,phone,'.Auth::id(),
             'image'=>'image|max:500'
         ]);
        $id = Auth()->user()->id;
        $obj = User::findOrFail($id);
        if ($request->hasFile('image')) {
            if(!empty($obj->image) && file_exists($obj->image)){
                unlink($obj->image);
            }
            $logo      = $request->file('image');
            $logo_name = hexdec(uniqid()) . '.' . $logo->getClientOriginalExtension();
            $logo_path = 'uploads/user/' . date('y/m/');
            $logo->move($logo_path, $logo_name);
            $obj->image = $logo_path . $logo_name;
        }

        $obj->password = isset($request->password) ? Hash::make($request->password) : $obj->password;
        $obj->name = isset($request->name) ? $request->name :$obj->name;
        $obj->email = isset($request->email) ? $request->email :$obj->email;
        $obj->phone = isset($request->phone) ? $request->phone :$obj->phone;
        $success = $obj->save();
        if($success){
            return response()->json('Profile Updated Successfully');
        }else{
            return response()->json('System Error');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show(int $id): Response
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Application|Factory|View|Response
     */
    public function edit($id)
    {
//        return view('admin.profile.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
