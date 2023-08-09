<?php

namespace App\Http\Controllers;

use App\Models\TelegraphText;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TextController extends Controller
{

    /**
     * @return Response
     */
    public function showPosts(): Response
    {
        $posts = TelegraphText::all();
        $view = view('text', ['posts' => $posts]);
        return response($view);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function addPost(Request $request): RedirectResponse
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

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function editPost(Request $request): RedirectResponse
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

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function deletePost(Request $request): RedirectResponse
    {
        $id = $request->get('id');
        TelegraphText::where('id', '=', $id)->delete();

        return redirect()->route('showPosts');
    }
}
