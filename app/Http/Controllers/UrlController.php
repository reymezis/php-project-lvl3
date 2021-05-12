<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UrlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $urls = DB::table('urls')->get();
        return view('url.index', ['urls' => $urls]);
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
        $url = parse_url($request->input('url.name'));
        $scheme   = isset($url['scheme']) ? mb_strtolower($url['scheme']) . '://' : '';
        $host     = isset($url['host']) ? mb_strtolower($url['host']) : '';
        $path     = isset($url['path']) ? $url['path'] : '';
        $requestData = $request->all();
        $requestData['url']['name'] = $scheme || $host ? "$scheme$host" : "$path";
        $request->replace($requestData);

        $messages = [
            'required' => 'Поле не должно быть пустым.',
            'url' => 'Введён некорректный адрес сайта.',
            'unique' => 'Данный адрес уже добавлен.'
        ];
        $this->validate($request, [
            'url.name' => 'required|url|unique:urls,name',
        ], $messages);

        session()->flash('status', 'Сайт добавлен!');
        $url = DB::table('urls')->insert(
            [
                'name' => "$scheme$host",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        return redirect()->route('urls.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $url = DB::table('urls')->find($id);
        if (!$url) {
            abort(404);
        }
        return view('url.show', ['url' => $url]);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
