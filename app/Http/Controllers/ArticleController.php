<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArticleCollection;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ArticleController extends Controller {

    public function index(): JsonResponse {
        $articles = new ArticleCollection(Article::with('user')->get());
        return response()->json($articles);
    }

    public function show($id): JsonResponse {
        $articles = new ArticleResource(Article::with('user')->findOrFail($id));
        return response()->json($articles);
    }

    public function getArticleByEachUser($userId): JsonResponse {
        #get all the articles ths '$userId' has
        //single query but do not involve in relation.
        //$articles = Article::with('user')->where('user_id', $userId)->get();; //or better use whereBelongsTo

        $user = User::findOrFail($userId); //or better use like this, but not a single query, not a better one
        //$articles = $user->articles; //the same as //whereBelongsTo, but not a single query
        $articles = Article::whereBelongsTo($user, 'user')->get();

        return response()->json($articles);
    }

    public function assignArticle($userId, $articleId): JsonResponse {
        //seems like update an article to each user.
        $article = Article::with("user")->findOrFail($articleId);
        $article->user()->associate(User::findOrFail($userId));

        $article->save();
        $article->refresh();

        //to remove user_id from articles use:
        //$article->user()->dissociate();
        //$article->save();

        return response()->json($article);
    }

    public function store(Request $request, $userId): JsonResponse {
        //create new article
        $request->validate([
            "description" => "required"
        ]);

        $article = new Article($request->all());
        $user = User::with("articles")->findOrFail($userId);

        $user->articles()->save($article);
        $user->refresh();

        return response()->json($user);

    }

}

