<?php

namespace App\Http\Controllers;

//
//use function abort;
use App\Channel;
use App\Inspections\Spam;
use App\Thread;
use App\Filters\ThreadFilters;
use App\Trending;
//use App\User;
use function auth;
//use function cache;
//use Carbon\Carbon;
use function compact;
use Illuminate\Http\Request;
//use function json_decode;
//use function json_encode;
use function redirect;
use function response;
use function str_slug;

class ThreadsController extends Controller
{
    /**
     * ThreadsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index','show']);
    }


    /**
     * Display a listing of the resource.
     *
     * @param Channel $channel
     * @param ThreadFilters $filters
     * @param Trending $trending
     * @return \Illuminate\Http\Response
     */
    public function index(Channel $channel, ThreadFilters $filters, Trending $trending)
    {
        $threads = $this->getThreads($channel, $filters);

        if(request()->wantsJson()) {
            return $threads;
        }

        return view('threads.index', [
            'threads' => $threads,
            'trending' => $trending->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('threads.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Spam $spam
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'channel_id' => 'required|exists:channels,id',
            'title' => 'required|spamfree',
            'body' => 'required|spamfree'
        ]);

        $thread = Thread::create([
            'user_id' => auth()->id(),
            'channel_id' => request('channel_id'),
            'title' => request('title'),
            'body' => request('body'),
            'slug' => str_slug(request('title'))
        ]);

        return redirect($thread->path())
            ->with('flash', 'Your thread has been published!');
    }

    /**
     * Display the specified resource.
     * @param $channelId
     * @param  \App\Thread $thread
     * @param Trending $trending
     * @return \Illuminate\Http\Response
     */
    public function show($channelId, Thread $thread, Trending $trending)
    {
        if(auth()->check()) {
            auth()->user()->read($thread);
        }

        $trending->push($thread);

        $thread->increment('visits');

        return view('threads.show', compact('thread'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Thread $thread
     * @return void
     */
    public function edit(Thread $thread)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Thread $thread
     * @return void
     */
    public function update(Request $request, Thread $thread)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Thread $thread
     * @param Channel $channel
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function destroy(Channel $channel, Thread $thread)
    {
        $this->authorize('update', $thread);

        $thread->delete();

        if(request()->wantsJson()) {
            return response([], 204);
        }

        return redirect('/threads');

    }

    /**
     * @param Channel $channel
     * @param ThreadFilters $filters
     * @return mixed
     */
    protected function getThreads(Channel $channel, ThreadFilters $filters)
    {
        $threads = Thread::latest()->filter($filters);

        if ($channel->exists) {
            $threads->where('channel_id', $channel->id);
        }

        return $threads->paginate(25);
    }

}
