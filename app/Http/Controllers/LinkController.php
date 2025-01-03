<?php

namespace App\Http\Controllers;

// use App\Http\Controllers\ApiController;
use App\Http\Resources\LinkResource;
use App\Models\Link;
use App\Models\Setting;
use App\Models\UserSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LinkController extends ApiController
{
    public function getByType($type)
    {
        $links = [
            'latest' => Link::query()->orderBy('id', 'desc')->take(5)->where('is_private', false),
            'random' => Link::query()->inRandomOrder()->take(5)->where('is_private', false),
            'popular' => Link::query()
                ->where('is_private', false)
                ->orderBy('views_count', 'desc')
                ->where('views_count', '>', 0)
                ->take(5),
        ];

        if (!isset($links[$type])) {
            $av = implode(', ', array_keys($links));

            return $this->fail('Type not found, available : ' . $av, code: 404);
        }

        return LinkResource::collection($links[$type]->get());
    }

    public function getLink(string $uniqueCode)
    {
        $alphaId = alphaID($uniqueCode, true);

        $link = Link::where('alpha_id_number', $alphaId)->first();

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
        $user = $request->user();
        $userIsPro = $user && $user->is_pro;

        $request->validate([
            'title' => 'required',
            'link' => 'required|active_url|url',

        ]);

        $link = new Link();
        if ($request->filled('code')) {
            $link = Link::where('unique_code', $request->code)->firstOrFail();
            $request->validate([
                'custom' => 'nullable|min:3|unique:links,unique_code,' . $link->id,
            ]);
        }

        if ($userIsPro && !$request->filled('code')) {
            $request->validate([
                'custom' => 'nullable|min:3|unique:links,unique_code',
            ]);
        }

        if ($user) {
            $link->user_id = $user->id;
        }

        if ($request->filled('private')) {
            if ($userIsPro) {
                $link->is_private = $request->boolean('private');
            } else {
                return $this->fail($user ? 'Your account is not pro' : 'Please login :(');
            }
        }

        $link->title = $request->title;
        $link->original_link = $request->link;
        $link->expire_at = now()->addDays($userIsPro ? 365 : 7)->endOfDay(); // 1 week

        generateId:
        if ($userIsPro && $request->filled('custom')) {
            $uniqueCode = $request->custom;
        } else {
            $uniqueCode = alphaID(rand(1e9, 1e10));
            if (Link::where('unique_code', $uniqueCode)->exists()) {
                goto generateId;
            }
        }

        $link->unique_code = $uniqueCode;
        $link->alpha_id_number = alphaID($uniqueCode, true);
        $link->save();

        return $this->success('Link created!', new LinkResource($link), true);
    }

    public function myLinks(Request $request)
    {
        $user = $request->user();
        $settings = UserSetting::select('user_settings.*', 'settings.key as key')
            ->where('user_id', $user->id)
            ->join('settings', 'user_settings.setting_id', '=', 'settings.id')
            ->get();

        $hidePrivate = $settings->where('key', 'hide_private_link')->first();
        $hide = $hidePrivate && boolval($hidePrivate->value) === true;

        $links = Link::where('user_id', $user->id)
            ->when($hide, function ($q) {
                $q->where('is_private', false);
            })
            ->when($request->filled('search'), function ($q) use ($request) {
                $q->where(function ($qq) use ($request) {
                    $qq->where('title', 'like', "%$request->search%")
                        ->orWhere('unique_code', 'like', "%$request->search%");
                });
            })
            ->orderBy('id', 'desc');

        if ($request->filled('page')) {
            $links = $links->simplePaginate(15);
        } else {
            $links = $links->get();
        }

        return LinkResource::collection($links);
    }

    public function search($q)
    {
        if (!is_null($q) && $q != '' && strlen($q) >= 3) {
            $d = Link::query()
                ->where('title', 'like', "%$q%")
                ->where('is_private', false)
                ->orderBy('id', 'desc')
                ->get();

            return LinkResource::collection($d);
        }

        if (strlen($q) < 3) {
            return $this->fail('The search query must have at least 3 characters!');
        }

        return $this->fail();
    }

    public function destroy(Link $link)
    {
        $link->delete();

        return $this->success();
    }
}
