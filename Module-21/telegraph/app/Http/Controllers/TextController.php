<?php

namespace App\Http\Controllers;

use App\Models\TelegraphText;
use Illuminate\Http\Request;

class TextController extends Controller
{

    public function showPosts()
    {
        $posts = TelegraphText::all();
        $view = view('text', ['posts' => $posts]);
        return response($view);
    }


    public function addPost(Request $request)
    {
        $title = $request->get('title');
        $text = $request->get('text');
        $author = $request->get('author');

        $telegraphText = new TelegraphText();
        $telegraphText->title = $title;
        $telegraphText->text = $text;
        $telegraphText->author = $author;

        $telegraphText->save();

        return redirect()->route('showPosts');
    }

    public function editPost(Request $request)
    {
        $id = $request->get('id');
        $title = $request->get('title');
        $text = $request->get('text');
        $author = $request->get('author');

        TelegraphText::find($id)->update([
            'title' => $title,
            'text' => $text,
            'author' => $author,
        ]);

        return redirect()->route('showPosts');
    }

    public function deletePost(Request $request)
    {
        $id = $request->get('id');
        TelegraphText::where('id', '=', $id)->delete();

        return redirect()->route('showPosts');
    }
}
