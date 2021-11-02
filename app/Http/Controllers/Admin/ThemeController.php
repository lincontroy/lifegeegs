<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Option;
use App\Models\Term;
use App\Models\Termmeta;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Str;

class ThemeController extends Controller
{
    public function heroSection()
    {
        abort_if(!Auth()->user()->can('hero-section'), 401);
        $option = Option::where('key', 'hero_section')->first();
        $data = json_decode($option->value ?? null);
        return view('admin.hero-section.index', compact('data'));
    }

    public function heroSectionStore(Request $request)
    {
        $request->validate([
            'title'        => 'required',
            'des'          => 'required',
            'start_text'   => 'required',
            'start_url'    => 'required',
            'contact_text' => 'required',
            'contact_url'  => 'required',
            'image'        => 'mimes:png,jpg,jpeg',
        ]);
        $obj = Option::where('key', 'hero_section')->first();

        if (($obj == null)) {
            $obj = new Option();
        }

        $info = json_decode($obj->value ?? null);
        $image = $info->image ?? null;

        $obj->key = 'hero_section';
        if ($request->hasFile('image')) {
            if (!empty($image) && file_exists($image)) {
                unlink($image);
            }
            $logo = $request->file('image');
            $logo_name = hexdec(uniqid()) . '.' . $logo->getClientOriginalExtension();
            $logo_path = 'uploads/hero_section/' . date('y/m/');
            $logo->move($logo_path, $logo_name);
            $image = $logo_path . $logo_name;
        }
        $data = [
            'title'        => $request->title,
            'des'          => $request->des,
            'start_text'   => $request->start_text,
            'start_url'    => $request->start_url,
            'contact_text' => $request->contact_text,
            'contact_url'  => $request->contact_url,
            'image'        => $image,
        ];
        $obj->value = json_encode($data);
        $obj->save();
        return response()->json('Information Added Successfully');
    }

    public function QuickStartSection()
    {
        abort_if(!Auth()->user()->can('quick-start.index'), 401);
        $data = Term::with('quickStart')->where('type', 'quick_start')->first();
        return view('admin.quick-start.edit', compact('data'));
    }

    public function QuickStartSectionStore(Request $request)
    {
        $request->validate([
            'title'       => 'required',
            'des'         => 'required',
            'list'        => 'required',
            'button_name' => 'required',
            'button_link' => 'required',
            'status'      => 'required',
            'image'       => 'mimes:png,jpg,jpeg',
        ]);
        
        $obj = Term::where('type', 'quick_start')->first();
        $obj->title = $request->title;
        $obj->status = $request->status;
        $obj->slug = Str::slug($request->title);
        $obj->save();

        //Termmeta table data save
        $meta = Termmeta::where('term_id', $obj->id)->where('key', 'quick_start_meta')->first();
        $info = json_decode($meta->value ?? null);
        $image = $info->image ?? null;

        if ($request->hasFile('image')) {
            if (!empty($image) && file_exists($image)) {
                unlink($image);
            }
            $logo = $request->file('image');
            $logo_name = hexdec(uniqid()) . '.' . $logo->getClientOriginalExtension();
            $logo_path = 'uploads/quick_starts/' . date('y/m/');
            $logo->move($logo_path, $logo_name);
            $image = $logo_path . $logo_name;
        }
        $data = [
            'des'         => $request->des,
            'button_name' => $request->button_name,
            'button_link' => $request->button_link,
            'list'        => $request->list,
            'image'       => $image,
        ];
        $meta->value = json_encode($data);
        $meta->save();
        
        if ($obj && $meta) {
            return response()->json('Successfully Data Updated !');
        } else {
            return response()->json('error !');

        }
    }

    public function gatewaySection()
    {
        abort_if(!Auth()->user()->can('gateway-section'), 401);
        $option = Option::where('key', 'gateway_section')->first();
        $data = json_decode($option->value ?? null);
        return view('admin.gateway-section.index', compact('data'));
    }

    public function gatewaySectionStore(Request $request)
    {
        $request->validate([
            'first_title'  => 'required',
            'first_des'    => 'required',
            'second_title' => 'required',
            'second_des'   => 'required',
            'image'        => 'mimes:png,jpg,jpeg',
        ]);

        $obj = Option::where('key', 'gateway_section')->first();
        if (($obj == null)) {
            $obj = new Option();
        }

        $info = json_decode($obj->value ?? null);
        $image = $info->image ?? null;

        $obj->key = 'gateway_section';
        if ($request->hasFile('image')) {
            if (!empty($image) && file_exists($image)) {
                unlink($image);
            }
            $logo = $request->file('image');
            $logo_name = hexdec(uniqid()) . '.' . $logo->getClientOriginalExtension();
            $logo_path = 'uploads/gateway_section/' . date('y/m/');
            $logo->move($logo_path, $logo_name);
            $image = $logo_path . $logo_name;
        }
        $data = [
            'first_title'  => $request->first_title,
            'first_des'    => $request->first_des,
            'second_title' => $request->second_title,
            'second_des'   => $request->second_des,
            'image'        => $image,
        ];
        $obj->value = json_encode($data);
        $obj->save();
        return response()->json('Gateway Section Added Successfully');

    }
}
