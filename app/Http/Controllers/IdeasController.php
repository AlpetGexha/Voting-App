<?php

namespace App\Http\Controllers;

use App\Models\Ideas;
use App\Models\Status;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Support\Facades\Redis;
use RateLimiter;

class IdeasController extends Controller
{
    public function index()
    {
        $this->indexSEO();

        return view('ideas.ideas');
    }

    public function show(string $slug)
    {
        $idea = Ideas::where('slug', $slug)
            ->with(['user:id,name,profile_photo_path,is_verified', 'category:id,name', 'votes'])
            // ->with(['user.likes'])
            ->withCount('spams', 'report')
            ->firstOrFail();
        $backUrl =
            url()->previous() !== url()->full() && url()->previous()
            ? url()->previous()
            : route('ideas.ideas');

        if (RateLimiter::remaining('idea.'.$idea->id.request()->ip(), 1)) {
            RateLimiter::hit('idea.'.$idea->id.request()->ip());
            Redis::incr('idea.visits.'.$idea->id);
        }

        // dd(Redis::get('idea.visits.' . $idea->id));

        // get simular idea
        // $simularIdeas = Ideas::query()
        //     ->toBase()
        //     ->where('status_id', Status::OPEN)
        //     ->where('id', '<>', $idea->id)
        //     ->where('category_id', $idea->category_id)
        //     ->orWhere('body', 'like', ''.$idea->body.'%')
        //     ->orWhere('title', 'like', ''.$idea->title.'%')
        //     ->limit(4)
        //     ->inRandomOrder()
        //     ->get();

        // dd($simularIdeas);

        // SEO
        $this->seoShow($idea);

        return view('ideas.show', compact('idea', 'backUrl'));
    }

    public function indexSEO()
    {
        SEOTools::setTitle('Home');
        SEOTools::setDescription('Laravel Vote App');
    }

    public function seoShow(Ideas $idea)
    {
        SEOTools::setTitle($idea->title);
        SEOTools::setDescription($idea->description);
        SEOTools::opengraph()->addProperty('type', 'articles');
        SEOTools::opengraph()->setUrl(route('ideas.show', ['slug' => $idea->slug]));
        SEOTools::opengraph()->addProperty('locale', 'en_US');
        SEOTools::opengraph()->addProperty('locale:alternate', ['en_US', 'en_GB']);
        SEOTools::opengraph()->addProperty('site_name', 'Laravel Vote App');
        SEOTools::opengraph()->addImage($idea->image);
    }
}
