<?php

namespace App\Http\Controllers;

use App\Models\Animals;
use Error;
use Exception;
use Illuminate\Http\Request;

class AnimalsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Animals::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            try {
                $request->validate([
                    "name" => "bail|required|max:255"
                ]);
            } catch (Exception | Error $e) {
                return response()->json(["error" => "name must be a maximum 255 characters long text"], 400);
            }
            $animal = Animals::create($request->only(["name"]));
            $animal->save();
            return response()->json($animal, 200);
        } catch (Exception $e) {
            return response()->json(["error" => "Animal not found!"], 404);
        } catch (Exception $e) {
            return response()->json($e, 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $animal = Animals::findOrFail($id);
            return response()->json($animal);
        } catch (Exception | Error $e) {
            return response()->json(["error" => "Animal not found!"], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $animal = Animals::findOrFail($id);
            try {
                $request->validate([
                    "name" => "bail|required|max:255"
                ]);
            } catch (Exception | Error $e) {
                return response()->json(["error" => "name must be a maximum 255 characters long text"], 400);
            }
            $animal->fill($request->only(["name"]));
            $animal->save();
            return response()->json($animal, 200);
        } catch (Exception $e) {
            return response()->json(["error" => "Animal not found!"], 404);
        } catch (Exception $e) {
            return response()->json($e, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $animal = Animals::findOrFail($id);
            $animal->destroy();
            return response(204);
        } catch (Exception | Error $e) {
            return response()->json(["error" => "Animal not found or deleted!"], 404);
        }
    }
}
