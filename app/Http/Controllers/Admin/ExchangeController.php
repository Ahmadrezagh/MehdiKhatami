<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exchange;
use App\Models\Flag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExchangeController extends Controller
{
    public function __construct()
    {

        $this->middleware(function ($request, $next) {
            if ((Auth::user()->isAdmin() && Auth::user()->can('Exchange')) || Auth::user()->isSuperAdmin())
            {
                return $next($request);
            }else{
                abort(404);
            }
        });

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $exchanges = Exchange::all();
        $flags = Flag::all();
        return view('admin.exchanges.index',compact('exchanges','flags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'left' => 'required',
            'right' => 'required',
        ]);
        if($request->left > 0 && $request->right > 0)
        {
            Exchange::create([
                'left' => $request->left,
                'right' => $request->right
            ]);
            alert()->success('Exchange created successfully');
        }else{
            alert()->warning('Please change both currencies');
        }
        return back();
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
        //
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
        $exchange = Exchange::findOrFail($id);
        $request->validate([
            'left' => 'required',
            'right' => 'required',
        ]);
        if($request->left > 0 && $request->right > 0)
        {
            $exchange->update([
                'left' => $request->left,
                'right' => $request->right
            ]);
            alert()->success('Exchange updated successfully');
        }else{
            alert()->warning('Please change both currencies');
        }
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $exchange = Exchange::findOrFail($id);
        $exchange->delete();
        alert()->success('Exchange Deleted Successfully');
        return back();
    }
}
