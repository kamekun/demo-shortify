<?php

namespace App\Http\Controllers\Shortify;

use App\Url;
use App\Rules\Blacklist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Urls extends Controller
{
    /**
     * Display a top listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function top(Request $request)
    {
        return Url::select('counter','hash')->orderBy('counter','DESC')->take(100)->paginate();
    }

    /**
     * Transfer or Redirect the shortify to the new location.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function transfer(Request $request, $hash)
    {
        $shortify = $this->validHash($hash);
       
        if(!$shortify)
            abort('404');
        
        Url::whereHash($hash)->increment('counter');
        $shortify->increment('counter');

        return redirect()->away($shortify->url, 301);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'url' => ['required', 'url', 'string' , new Blacklist],
            'title' => 'sometimes|nullable|string', 
            'description' => 'sometimes|nullable|string', 
        ]);

        /**
         *  @todo: set the title and desription from the meta of 
         *  the VALID URL Response.
         */ 
        return Url::create(
            $this->validated()
        );
    }

    /**
     * Display the specified resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $hash
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $hash)
    {
        $this->validate($request, [
            'code' => 'required|string',
        ]);

        \Cache::forget("shortify.$hash");

        $url = $this->validHash($hash);

        abort_unless($url->canManage($this->validatedKey('code')), 403);

        return $url;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Illuminate\Http\Request  $request
     * @param string $hash
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, string $hash)
    {
        $this->validate($request, [
            'code' => 'required|string',
        ]);

        $url = $this->validHash($hash);

        abort_unless($url->canManage($this->validatedKey('code')), 403);

        $url->delete();

        \Cache::forget("shortify.$hash");

        if (request()->wantsJson()) {
            return response([], 204);
        }
    }
    /**
     * validHash function
     *
     * @param string $hash
     * @return void
     */
    private function validHash(string $hash)
    {
        /**
         *  @todo: Add expiration time to the cache, 
         *  Just for this case will leave it as Forever.
         *  But could be a week or a month or even a year...
         */
        $url = \Cache::rememberForever("shortify.$hash", function () use ($hash) {
            return Url::whereHash($hash)->first();
        });

        if(!$url)
            abort(404);

        return $url;
    }
}