<?php

namespace App\Http\Controllers;

use App\Models\Cast;
use App\Models\Category;
use App\Models\Film;
use App\Models\Image;
use App\Models\LinkTrailer;
use App\Models\Nation;
use App\Models\Type;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    // search film
    function search_film()
    {
        $films = null;

        if (request()->query('search')) {
            $key = request()->query('search');
            $films = Film::where('original_name', 'like', '%' . $key . '%')
                ->orderBy('imdb', 'desc')
                ->orderBy('views', 'desc')
                ->simplePaginate(5);
        } else {
            $films = Film::simplePaginate(5);
        }
        return view('films.index')
            ->with('films', $films)
            ->with('types', Type::all())
            ->with('categories', Category::all());;
    }
    // search user
    function search_user()
    {
        $users = null;

        if (request()->query('search')) {
            $key = request()->query('search');
            $users = User::where('name', 'like', '%' . $key . '%')
                ->orWhere('email', 'like', '%' . $key . '%')
                ->orderBy('role', 'desc')
                ->simplePaginate(5);
        } else {
            $users = User::simplePaginate(5);
        }
        return view('users.index')
            ->with('users', $users);
    }
    // search type
    function search_types()
    {
        $types = null;

        if (request()->query('search')) {
            $key = request()->query('search');
            $types = Type::where('name', 'like', '%' . $key . '%')
                ->simplePaginate(5);
        } else {
            $types = Type::simplePaginate(5);
        }
        return view('types.index')
            ->with('types', $types)
            ->with('films', Film::all());
    }
    // search nation
    function search_nation()
    {
        $nations = null;

        if (request()->query('search')) {
            $key = request()->query('search');
            $nations = Nation::where('nations.name', 'like', '%' . $key . '%')
                ->select('nations.*')
                ->simplePaginate(5);
        } else {
            $nations = Nation::simplePaginate(5);
        }
        return view('nations.index')
            ->with('nations', $nations)
            ->with('films', Film::all());
    }
    // search user
    function search_link()
    {
        $links = null;

        if (request()->query('search')) {
            $key = request()->query('search');
            $links = LinkTrailer::join('films', 'link_trailers.film_id', '=', 'films.id')
                ->where('link_trailers.name', 'like', '%' . $key . '%')
                ->orWhere('original_name', 'like', '%' . $key . '%')
                ->select('link_trailers.*')
                ->simplePaginate(5);
        } else {
            $links = LinkTrailer::simplePaginate(5);
        }
        return view('links.index')
            ->with('links', $links)
            ->with('films', Film::all());
    }

    // search user
    function search_image()
    {
        $images = null;
        // '%' . $key . '%'
        if (request()->query('search')) {
            $key = request()->query('search');
            $images = Image::join('films', 'images.film_id', '=', 'films.id')
                ->where('films.original_name', 'like', '%' . $key . '%')
                ->select('images.*')
                ->simplePaginate(5);
        } else {
            $images = Image::simplePaginate(5);
        }
        return view('images.index')
            ->with('images', $images)
            ->with('films', Film::all());
    }

    // search user
    function search_categories()
    {
        $categories = null;

        if (request()->query('search')) {
            $key = request()->query('search');
            $categories = Category::join('films_categories', 'categories.id', '=', 'films_categories.category_id')
                ->join('films', 'films_categories.film_id', '=', 'films.id')
                ->where('categories.name', 'like', '%' . $key . '%')
                ->select('categories.*')
                ->orWhere('films.original_name', 'like', '%' . $key . '%')
                ->simplePaginate(5);
        } else {
            $categories = Category::simplePaginate(5);
        }
        return view('categories.index')
            ->with('categories', $categories)
            ->with('films', Film::all());
    }
    
    // search user
    function search_cast()
    {
        $casts = null;
        //cast_film
        if (request()->query('search')) {
            $key = request()->query('search');
            $casts = Cast::join('cast_film', 'casts.id', '=', 'cast_film.cast_id')
                ->join('films', 'cast_film.film_id', '=', 'films.id')
                ->where('casts.name', 'like', '%' . $key . '%')
                ->orWhere('films.original_name', 'like', '%' . $key . '%')
                ->select('casts.*')
                ->simplePaginate(5);
        } else {
            $casts = Cast::simplePaginate(5);
        }
        return view('casts.index')
            ->with('casts', $casts)
            ->with('films', Film::all());
    }
}
