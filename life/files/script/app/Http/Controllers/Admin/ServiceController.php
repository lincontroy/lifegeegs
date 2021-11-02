<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Term;
use App\Models\Termmeta;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Str;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(!Auth()->user()->can('service.index'), 401);
        $data = Term::with('termMeta')->where('type', 'service')->latest()->paginate(20);
        return view('admin.service.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(!Auth()->user()->can('service.create'), 401);
        return view('admin.service.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'     => 'required',
            'description'       => 'required',
            'short_description' => 'required',
            'status'    => 'required',
            'image'     => 'image|required|max:500',
        ]);

        $obj = new Term();
        $obj->type = 'service';
        $obj->title = $request->title;
        $obj->status = $request->status;
        $obj->slug = Str::slug($request->title);
        $obj->save();

        //Termmeta table data save
        $meta = new Termmeta();
        $meta->term_id = $obj->id;
        $meta->key = 'service_meta';
        $image = null;
        if ($request->hasFile('image')) {
            $logo = $request->file('image');
            $logo_name = hexdec(uniqid()) . '.' . $logo->getClientOriginalExtension();
            $logo_path = 'uploads/service/' . date('y/m/');
            $logo->move($logo_path, $logo_name);
            $image = $logo_path . $logo_name;
        }

        $data = [
            'des'       => $request->description,
            'short_des' => $request->short_description,
            'image'     => $image,
        ];

        $meta->value = json_encode($data);
        $meta->save();
          
        if ($obj && $meta) {
            return response()->json('Successfully Service Created..!!');
        } else {
            return response()->json('error !');

        }

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
        abort_if(!Auth()->user()->can('service.edit'), 401);
        $data = Term::with('termMeta')->where('type', 'service')->findOrFail($id);
        return view('admin.service.edit', compact('data'));

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
        

        $request->validate([
            'title'     => 'required',
            'description'       => 'required',
            'short_description' => 'required',
            'status'    => 'required',
            'image'     => 'image|max:500',
        ]);

        $obj = Term::with('termMeta')->findOrFail($id);
        $obj->title = $request->title;
        $obj->status = $request->status;
        $obj->slug = Str::slug($request->title);
        $obj->save();

        //Termmeta table data save
        $meta = Termmeta::where('term_id', $obj->id)->where('key', 'service_meta')->first();
        $info = json_decode($meta->value ?? null);
        $image = $info->image ?? null;

        if ($request->hasFile('image')) {
            if (!empty($image) && file_exists($image)) {
                unlink($image);
            }
            $logo = $request->file('image');
            $logo_name = hexdec(uniqid()) . '.' . $logo->getClientOriginalExtension();
            $logo_path = 'uploads/service/' . date('y/m/');
            $logo->move($logo_path, $logo_name);
            $image = $logo_path . $logo_name;
        }else{
            $image = $info->image ?? null;
        }


        $data = [
            'des'       => $request->description,
            'short_des' => $request->short_description,
            'image'     => $image,
        ];
        $meta->value = json_encode($data);
        $meta->save();
       
        if ($obj && $meta) {
            return response()->json('Service Successfully Updated..!!');
        } else {
            return response()->json('error !');

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(!Auth()->user()->can('service.delete'), 401);
        $termMeta = Termmeta::where('term_id', $id)->where('key', 'service_meta')->first();
        $info = json_decode($termMeta->value);
        if (!empty($info->image) && file_exists($info->image)) {
            unlink($info->image);
        }
        $termMeta->delete();
        $term = Term::where('type', 'service')->findOrFail($id)->delete();
        if ($termMeta && $term) {
            return redirect()->back()->with('Successfully deleted ');
        } else {
            return redirect()->back()->with('Error');
        }

    }
}
