<?php

namespace App\Http\Controllers;

use App\Models\Metadata;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class MainController extends Controller
{
    public function showPath(Request $request) {
        $path = null;
        if($request->has("path")) {
            $path = $request->get("path");
        }

        $parent = null;
        if($path) {
            $directory = basename($path);
            $parent = Metadata::where('name', $directory)->firstOrFail()->id;
        }

        $parentQuery = $parent ? "parent_id = $parent" : "parent_id is null";

        $items = Metadata::whereRaw($parentQuery)->get();

        $prettyPath = $path ? $path : "";

        return view("index")->with([
            'files' => $items,
            'path' => $prettyPath
        ]);
    }

    public function remove(Request $request, $id) {
        $metadata = Metadata::findOrFail($id);
        $metadata->delete();

        return redirect()->back();
    }

    public function search(Request $request) {
        $request->validate([
            'term' => 'required|string'
        ]);
        $term = $request->get('term');

        $items = Metadata::where('name', 'like', "%$term%")->get();
        return view("index")->with([
            'files' => $items,
            'path' => '',
            'term' => $term
        ]);
    }

    public function createFolder(Request $request) {
        $request->validate([
            'name' => 'required|string'
        ]);
        $name = $request->get('name');
        $path = null;
        if($request->has("path")) {
            $path = $request->get("path");
        }

        $parent = null;
        if($path) {
            $directory = basename($path);
            $parent = Metadata::where('name', $directory)->firstOrFail()->id;
        }

        Metadata::create([
            'name' => $name,
            'parent_id' => $parent,
            'uploaded_by' => $request->ip(),
            'is_file' => 0
        ]);

        return redirect()->route('show-path', ['name' => $path]);
    }

    public function uploadFile(Request $request) {
        $request->validate([
            'file' => 'required|file',
        ]);

        $file = $request->file('file');
        $path = $request->has('path') ? $request->get('path') : null;
        $name = $file->getClientOriginalName();

        if($this->checkIfFileExists($name)) {
            return response()->json([
                'message' => "File already exists"
            ], 400);
        }
        $storagePath = $path ? "root/$path" : "root";
        $parentId = $this->getParentId($path);
        $path = $file->storeAs($storagePath, $name);


        Metadata::create([
            'name' => $name,
            'is_file' => 1,
            'parent_id' => $parentId,
            'uploaded_by' => $request->ip()
        ]);

        return response()->json([
            'path' => $path,
            'name' => 'name'
        ]);
    }

    private function checkIfFileExists($name) {
        $count = Metadata::where('name', $name)->count();

        return $count > 0;
    }

    private function getParentId($path) {
        if(!$path)
            return null;
        $directory = basename($path);
        $obj = Metadata::where('name', $directory)->get()->first();

        if($obj) {
            return $obj->id;
        }
    }
}
