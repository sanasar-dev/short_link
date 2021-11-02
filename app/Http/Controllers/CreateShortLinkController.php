<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidateUrlRequest;
use App\Models\ShortLink;

class CreateShortLinkController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('welcome');
    }

    /**
     * @param ValidateUrlRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function generateShortLink(ValidateUrlRequest $request)
    {
        $input = $request->validated();
        $shorUrl = request()->getHttpHost() . '/' . str_random(5);

        $existingUrl = ShortLink::where('link', $input['url'])->first();

        if ($existingUrl) {
            $shorUrl = $existingUrl->short_link;
        } else {
            ShortLink::create([
                'link' => $input['url'],
                'short_link' => $shorUrl
            ]);
        }

        return response()->json(['short_url' => $shorUrl]);
    }

    /**
     * @param $path
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function redirectToUrl($path)
    {
        if ($path) {
            $shorUrl = request()->getHttpHost() . '/' .$path;
            $shortUrl = ShortLink::where('short_link', $shorUrl)->first(['link']);

            if ($shortUrl) {
                return redirect()->to($shortUrl->link);
            }
        }
    }
}
