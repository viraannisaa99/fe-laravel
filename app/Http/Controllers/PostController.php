<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cookie;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $token;

    public function __construct()
    {
        $this->token = Cookie::get('token');
        $this->baseAPI = env('API_BACKEND');
    }

    public function index()
    {
        $res = Http::withHeaders(['Accept' => 'application/json'])
            ->withToken($this->token)
            ->get($this->baseAPI . '/api/posts');

        if (!$res->successful()) {
            abort($res->status());
        }

        $data = $res->json();
        return view('admin.data_post', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tambah_post');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $res = Http::withHeaders(['Accept' => 'application/json'])
            ->withToken($this->token)
            ->post($this->baseAPI . '/api/posts', [
                'title'     => request('title'),
                'content'   => request('content'),
                'author'    => request('author'),
                'post_date' => request('post_date'),
                'image'     => request('image'),
            ]);

        if (!$res->successful()) {
            abort($res->status());
        }

        return redirect()->route(('posts.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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
        $res = Http::withHeaders(['Accept' => 'application/json'])
            ->withToken($this->token)
            ->get($this->baseAPI . '/api/posts/' . $id);

        if (!$res->successful()) {
            abort($res->status());
        }

        $post['post'] = $res->json()['data'];
        return view('admin.edit_post', $post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        $res = Http::withHeaders(['Accept' => 'application/json'])
            ->withToken($this->token)
            ->put($this->baseAPI . '/api/posts/' . request('id'), [
                'id'        => request('id'),
                'title'     => request('title'),
                'content'   => request('content'),
                'author'    => request('author'),
                'post_date' => request('post_date'),
                'image'     => request('image'),
            ]);

        if (!$res->successful()) {
            abort($res->status());
        }

        return redirect()->route(('posts.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res = Http::withHeaders(['Accept' => 'application/json'])
            ->withToken($this->token)
            ->delete($this->baseAPI . '/api/posts', [
                'id' => request('id')
            ]);

        if (!$res->successful()) {
            abort($res->status());
        }

        return redirect()->route(('posts.index'));
    }
}
