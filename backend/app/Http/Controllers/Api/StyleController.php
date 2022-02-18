<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Style;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StyleController extends Controller
{
    public function index()
    {
        $this->authorize('sadmin');
        $styles = Style::with('buyer')->latest()->paginate(20);
        return response()->json(compact('styles'));
    }

    public function listStyle($id)
    {
        $this->authorize('sadmin');
        $styles = Style::where('buyer_id', $id)->orderBy('name')->select('id', 'name')->get();
        return response()->json(compact('styles'));
    }

    public function createStyle(Request $request)
    {
        $this->authorize('sadmin');
        $request->validate([
            'buyer_id' => 'required|numeric',
            'name' => 'required',
        ]);

        $style = new Style();
        $style->buyer_id = $request->buyer_id;
        $style->name = $request->name;
        $style->slug = Str::slug($request->name) . Str::random(1);
        $style->save();
        return response()->json('Style successfully created');
    }

    public function editStyle($id)
    {
        $this->authorize('sadmin');
        $style = Style::where('id', $id)->first();
        if (isset($style)) {
            return response()->json(compact('style'));
        } else {
            return response()->json(['message' => 'Style not found'], 422);
        }
    }

    public function updateStyle(Request $request, $id)
    {
        $this->authorize('sadmin');
        $request->validate([
            'buyer_id' => 'required|numeric',
            'name' => 'required',
            'status' => 'required|boolean',
        ]);

        $style = Style::where('id', $id)->first();
        $style->buyer_id = $request->buyer_id;
        $style->name = $request->name;
        $style->slug = Str::slug($request->name) . Str::random(1);
        $style->save();
        return response()->json('Style successfully updated');
    }

    public function deleteStyle(Request $request)
    {
        $this->authorize('sadmin');
        $request->validate(
            [
                "idList" => "required|array|min:1"
            ],
            [
                'idList.required' => 'Please select an item',
            ]
        );
        foreach ($request->idList as $id) {
            $style = Style::where('id', $id)->first();
            if (isset($style)) {
                $style->delete();
            } else {
                return response()->json(['message' => 'Style not found'], 422);
            }
        }
        return response()->json('Style successfully deleted');
    }

    public function searchStyle(Request $request)
    {
        $this->authorize('sadmin');
        $request->validate([
            "collum" => "required"
        ]);
        $styles = Style::where($request->collum, 'LIKE', '%' . $request->keyword . '%')->with('buyer')->latest()->paginate(20);
        return response()->json(compact('styles'));
    }
}
