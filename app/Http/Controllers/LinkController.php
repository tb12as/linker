<?php

namespace App\Http\Controllers;

// use App\Http\Controllers\ApiController;
use App\Http\Resources\LinkResource;
use Illuminate\Http\Request;
use App\Models\Link;

class LinkController extends ApiController
{
    public function getByType($type)
    {
        switch ($type) {
            case 'latest':
                $links = Link::orderByDesc('id')->take(5)->get();

                break;

            case 'random':
                $links = Link::inRandomOrder()->take(5)->get();

                break;

            case 'popular':
                $links = Link::orderByDesc('views_count')
                    ->where('views_count', '>', 0)
                    ->take(5)
                    ->get();

                break;

            default:
                abort(404);

                break;
        }

        return LinkResource::collection($links);
    }

    public function getLink($uniqueCode)
    {
        $link = Link::where('unique_code', $uniqueCode)->first();

        if (!$link) {
            return $this->notFound('Link not found');
        }

        // for every view add 30 minutes to expire date
        $link->expire_at = $link->expire_at->addMinutes(30);
        $link->views_count += 1;
        $link->save();

        return new LinkResource($link);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'link' => 'required|active_url|url',
        ]);

        $link = new Link();
        $link->title = $request->title;
        $link->original_link = $request->link;
        $link->expire_at = now()->addDays(14)->endOfDay(); // 2 weeks

        generateId:
        $uniqueCode = alphaID(rand(1e9, 1e14));
        if (Link::where('unique_code', $uniqueCode)->exists()) {
            goto generateId;
        }

        $link->unique_code = $uniqueCode;
        $link->save();

        return $this->success('Link created!', new LinkResource($link));
    }

    public function search($q)
    {
        if (!is_null($q) && $q != '' && strlen($q) >= 3) {
            $d = Link::query()
                ->where('title', 'like', "%$q%")
                ->orderByDesc('id')
                ->get();

            return LinkResource::collection($d);
        }

        if (strlen($q) < 3) {
            return $this->fail('The search query must have at least 3 characters!');
        }

        return $this->fail();
    }
}
