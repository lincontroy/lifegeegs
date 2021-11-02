<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;

use App\Http\Requests\MerchantProfileRequest;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */
    public function index()
    {
        return view('merchant.profile.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View|Response
     */
    public function create()
    {
        return view('merchant.profile.edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param MerchantProfileRequest $request
     * @return JsonResponse
     */
    public function store(MerchantProfileRequest $request): JsonResponse
    {
        $id = Auth()->user()->id;
        $request->validate([
            'email' => 'required|unique:users,email,'.$id,
            'image' => 'image|max:500',
           
        ]);
        
        

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
        if (isset($request->password)) {
           $obj->password = Hash::make($request->password);
        }
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
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
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
