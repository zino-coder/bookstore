<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Tag::query();

            if ($request->q) {
                $query->where('name', 'like', "%$request->q%");
            }

            $tags = $query->paginate(10, '*', 'page', $request->page);

            $tagsMap = $tags->map(function ($tag) {
                return [
                    'id' => $tag->id,
                    'text' => $tag->name,
                ];
            });
            $data = [
                'lastPage' => $tags->lastPage(),
                'data' => $tagsMap,
            ];

            return response()->json($data);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
