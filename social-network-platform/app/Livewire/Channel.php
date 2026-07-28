<?php

namespace App\Livewire;

use App\Models\Comment;
use App\Models\Notification;
use Livewire\Component;
use App\Models\Page;
use App\Models\PageLike;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use App\Models\Like;
use App\Models\Share;

class Channel extends Component
{
    public function render()
    {
        return view('livewire.channel')->extends('layouts.app');
    }

    public function followChannel($id)
    {
        $page = Page::findOrFail($id);
        DB::beginTransaction();
        try {
            PageLike::create([
                'page_id' => $id,
                'user_id' => auth()->id()
            ]);
            $page->update([
                'members' => $page->members + 1
            ]);
            Notification::create([
                "type" => "Follow Channel",
                "user_id" => $page->user_id,
                "message" => auth()->user()->username . " followed your channel",
                "url" => "/channel/" . $page->uuid
            ]);
            DB::commit();
            session()->flash('success', 'You have successfully followed the channel');
        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', 'Something went wrong');
            throw $th;
        }
        return redirect()->back();
    }

    public function unfollowChannel($id)
    {
        $page = Page::findOrFail($id);
        DB::beginTransaction();
        try {
            PageLike::where('page_id', $id)->where('user_id', auth()->id())->delete();
            $page->update([
                'members' => $page->members - 1
            ]);
            DB::commit();
            session()->flash('success', 'You have successfully unfollowed the channel');
        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', 'Something went wrong');
            throw $th;
        }
        return redirect()->back();
    }

    public function deleteChannel($id)
    {

        $page = Page::findOrFail($id);
        $posts = Post::where('page_id', $id)->get();
        $followers = PageLike::where('page_id', $id)->get();
        DB::beginTransaction();
        try {
            foreach ($posts as $post) {
                $comments = Comment::where('post_id', $post->id)->get();
                $upvotes = Like::where('post_id', $post->id)->get();
                $share = Share::where('post_id', $post->id)->get();
                foreach ($comments as $comment) {
                    $comment->delete();
                }
                foreach ($upvotes as $upvote) {
                    $upvote->delete();
                }
                foreach ($share as $sh) {
                    $sh->delete();
                }
                $post->delete();
            }
            foreach ($followers as $follower) {
                $follower->delete();
            }
            $page->delete();
            DB::commit();
            session()->flash('success', 'You have successfully deleted the channel');
        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', 'Something went wrong');
            throw $th;
        }
        return redirect()->to('/my-channels');
    }
}
