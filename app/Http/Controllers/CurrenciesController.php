<?php

namespace App\Http\Controllers;

use App\Currency;
use Mail;
use Illuminate\Http\Request;

class CurrenciesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currencies = Currency::paginate(10);
        $average = Currency::avg('rs');
        $min = Currency::min('rs');
        $max = Currency::max('rs');
        $res = Currency::all();
        $med = @$res->median()->rs;
        return view('home',compact('currencies','average','min','max','med'));
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
        $input = $request->all();
        $currency = new Currency;
        $currency->rs = $input['rupees'];
        $currency->doller = $input['dollars'];
        $currency->save();
        return $currency->id;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function show(Currency $currency)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function edit(Currency $currency)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Currency $currency)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function destroy(Currency $currency)
    {
        //
    }

    public function SendMail(Request $request)
    {
        $input = $request->all();
        Mail::send('email', $input, function ($message) {
            $message->from('info@labelblind.com', 'Test Mail');

            $message->to($input['email']);
        });
        // return view('email');
    }
}
