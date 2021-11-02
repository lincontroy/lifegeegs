<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\CurrencyRequest;
use
    App\Models\Currency;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */
    public function index()
    {
        abort_if(!Auth()->user()->can('currency.index'), 401);
        $data = Currency::paginate(10);
        return view('admin.currency.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View|Response
     */
    public function create()
    {
        abort_if(!Auth()->user()->can('currency.create'), 401);
        return view('admin.currency.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CurrencyRequest $request
     * @return JsonResponse
     */
    public function store(CurrencyRequest $request): JsonResponse
    {
        $data = $request->all();
        $currency = new Currency();
        $success = $currency->fill($data)->save();
        if($success){
            return response()->json('Currency Add Successfully');
        }else{
            return response()->json('System Error');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param Currency $currency
     * @return Response
     */
    public function show(Currency $currency): Response
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return Application|Factory|View|Response
     */
    public function edit($id)
    {
        abort_if(!Auth()->user()->can('currency.edit'), 401);
        $data = Currency::findOrFail($id);
        return view('admin.currency.edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CurrencyRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(CurrencyRequest $request, $id): JsonResponse
    {
        $data = $request->all();
        $currency = Currency::findOrFail($id);
        $success = $currency->fill($data)->save();
        if($success){
            return response()->json('Currency Update Successfully');
        }else{
            return response()->json('System Error');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        abort_if(!Auth()->user()->can('currency.delete'), 401);
        $data = Currency::findOrFail($id);
        $data->delete();
        return  redirect()->back()->with('success','Currency Deleted Successfully');
    }
}
