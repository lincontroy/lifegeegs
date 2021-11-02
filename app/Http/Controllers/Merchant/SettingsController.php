<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\Usermeta;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */
    public function index()
    {
        $id = Auth::user()->id;
        $user = Usermeta::where('user_id', $id)->first();
        $data = json_decode($user->value ??null) ;
        return view('merchant.settings.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $id = Auth::user()->id;
        $user = Usermeta::where('user_id', $id)->where('key', 'user_info')->first();

        if (($user == null)) {
            $user = new Usermeta();
        }
        // Validate
        $request->validate([
            'company_name' => 'required',
            'company_email' => 'required',
            'company_phone' => 'required',
        ]);
        $user->user_id = $id;
        $user->key = 'user_info';
        $data = [
            'company_name' => $request->company_name,
            'company_address' => $request->company_address,
            'company_city' => $request->company_city,
            'company_email' => $request->company_email,
            'company_phone' => $request->company_phone,
            'callback' => $request->callback,
            'invoice_description' => $request->invoice_description,
        ];

        $user->callback = $request->callback;

        $user->ho = substr($request->company_name, 0, 5);
        $user->value = json_encode($data);
        $user->save();
        return response()->json('Settings Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
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
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
