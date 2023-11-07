<?php

namespace App\Http\Controllers;

use App\Models\NewsFeedItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsFeedController extends Controller
{
    //

    public function index() {
        $items = NewsFeedItem::orderBy('created_at','desc')->paginate(15);
        return view('pages.news', compact('items'));
    }
    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'content' => 'required|string|max:1000',
            'image' => 'required|image|max:4096',
        ]);

        $image = $request->file('image');
        $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('news_feed_images'), $imageName); // Store image in the "public/news_feed_images" directory

        $newsFeedItem = new NewsFeedItem();
        $newsFeedItem->title = $validatedData['title'];
        $newsFeedItem->content = $validatedData['content'];
        $newsFeedItem->image = 'news_feed_images/' . $imageName; // Update the image path
        if($request->link) {
            $newsFeedItem->link = $request->link;
        }
        $newsFeedItem->save();

        return back()->with('success', 'News feed item created');
    }

    public function delete($id)
    {
        $newsFeedItem = NewsFeedItem::find($id);

        if ($newsFeedItem) {
            $newsFeedItem->delete();
            return back()->with('success','News feed item deleted');
        } else {
            return back()->with('error','News feed item not found');
        }
    }

    public function update(Request $request)
    {
        $newsFeedItem = NewsFeedItem::find($request->id);
        $validatedData = $request->validate([
            'title' => 'required|string',
            'content' => 'required|string|max:1000'
        ]);

        if($request->image) {
            $image = $request->file('image');
            $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('news_feed_images'), $imageName); // Store image in the "public/news_feed_images" directory
            $newsFeedItem->image = 'news_feed_images/' . $imageName; // Update the image path
        }

        $newsFeedItem->title = $validatedData['title'];
        $newsFeedItem->content = $validatedData['content'];
        if($request->link) {
            $newsFeedItem->link = $request->link;
        }
        $newsFeedItem->save();

        return back()->with('success', 'News feed item edited.');

    }
}
