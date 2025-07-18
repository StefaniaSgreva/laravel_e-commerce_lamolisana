<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class BlogController extends Controller
{
    public function index()
    {
        // Recupera i post pubblicati, ordinati per data di pubblicazione (dal più recente)
        $posts = Post::with('categoria')
            ->pubblicati()
            ->orderBy('data_pubblicazione', 'desc')
            ->paginate(6); // 9 post per pagina

        return view('pages.blog', compact('posts'));
    }

    public function show($slug)
    {
        $post = Post::with('categoria')
            ->where('slug', $slug)
            ->pubblicati()
            ->firstOrFail();

        // Incrementa le visualizzazioni
        $post->incrementaVisualizzazioni();

        // Post precedente e successivo
        $previousPost = Post::pubblicati()
            ->where('data_pubblicazione', '<', $post->data_pubblicazione)
            ->orderBy('data_pubblicazione', 'desc')
            ->first();

        $nextPost = Post::pubblicati()
            ->where('data_pubblicazione', '>', $post->data_pubblicazione)
            ->orderBy('data_pubblicazione', 'asc')
            ->first();

        // Articoli correlati (stessa categoria)
        $relatedPosts = Post::with('categoria')
            ->where('categoria_id', $post->categoria_id)
            ->where('id', '!=', $post->id)
            ->pubblicati()
            ->orderBy('data_pubblicazione', 'desc')
            ->limit(3)
            ->get();

        return view('pages.show_post', compact('post', 'previousPost', 'nextPost', 'relatedPosts'));
    }
}
