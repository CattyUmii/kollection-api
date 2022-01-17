<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\Article;
use App\Models\User;
use http\Env\Request;
use http\Env\Response;
use Illuminate\Http\JsonResponse;

class UserController extends Controller {

    public function index(): JsonResponse {

        //eager loading with article relationship ~ whenLoaded in JsonResource or Collection
        //if want to query only that articles is not zero, simply mean we want to
        // query only some users having articles.
        $users = User::with(["address", "articles", "roles"])->get();
        //$users = User::with("articles")->has('articles')->get();

        //If want to filter more condition on articles relation: for example:
        //user must have at least an article or a ...

//        $users = User::with('articles')->whereHas('articles', function ($query) {
//            $query->whereNotNull('created_at');
//        })->get();

        return response()->json(new UserCollection($users));
    }

    public function show($userId): JsonResponse {

        //$user = User::with('articles')->firstWhere('id', $userId);
        //$user = User::with('articles')->findOrFail($userId);

        //check user relation with article, have or not ?
        //dd($user->articles()->exists());
        //dd($user->articles()->count());

        //$user = User::with(['address', 'articles'])->findOrFail($userId);

        $user = User::with(["address.postal", "articles", "roles"])->findOrFail($userId);

        return response()->json(new UserResource($user));
        //return response()->json($user);
    }

    public function assignRole($userId, $roleId): JsonResponse {

        //find a user via id
        $user = User::with("roles")->findOrFail($userId);
        //attach and detach accepted array for multiple value
        //$user->roles()->attach($roleId);
        //$user->roles()->attach([1, 2]); //adding multiple roles to a user.

        //to remove multiple roles from a user
        //$user->roles()->detach([1, 2]);

        //using sync
        $user->roles()->sync($roleId);

        //if dont want to remove existing Id in immediate table that are missing from given array, use
        //$user->roles()->syncWithoutDetaching([1,2 ,3]);

        $user->refresh(); //refresh a user model after add newly value
        return response()->json($user);
    }

    public function update() {
        //update profile user here
    }

}

