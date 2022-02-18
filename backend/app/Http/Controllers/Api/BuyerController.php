<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Buyer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class BuyerController extends Controller
{
    public function index()
    {
        $this->authorize('sadmin');
        $buyers = Buyer::latest()->paginate(20);
        return response()->json(compact('buyers'));
    }
    public function listBuyer()
    {
        $this->authorize('sadmin');
        $buyers = Buyer::select('id', 'name')->get();
        return response()->json(compact('buyers'));
    }

    public function createBuyer(Request $request)
    {
        $this->authorize('sadmin');
        $request->validate([
            'name' => 'required|unique:buyers',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp',
        ]);

        $slug = Str::slug($request->name);
        $path = 'images/buyers/logo/';
        $imageName = $path . $slug . time() . '.webp';

        if (!File::exists($path)) {
            File::makeDirectory($path, $mode = 0777, true, true);
        }

        if (Image::make($request->logo)->encode('webp', 80)->save($imageName)) {
            $buyer = new Buyer();
            $buyer->name = $request->name;
            $buyer->slug = $slug;
            $buyer->logo = $imageName;
            $buyer->save();
        };

        return response()->json('Buyer successfully created');
    }

    public function editBuyer($id)
    {
        $this->authorize('sadmin');
        $buyer = Buyer::where('id', $id)->first();
        if (isset($buyer)) {
            return response()->json(compact('buyer'));
        } else {
            return response()->json(['message' => 'Buyer not found'], 422);
        }
    }

    public function updateBuyer(Request $request, $id)
    {
        $this->authorize('sadmin');
        $request->validate([
            'name' => 'required',
        ]);

        $buyer = Buyer::where('id', $id)->first();
        $slug = Str::slug($request->name);
        $path = 'images/buyers/logo/';

        $image = $request->hasFile('logo');
        if ($image) {
            if (File::exists($buyer->logo)) {
                unlink($buyer->logo);
            }
            $imageName = $path . $slug . time() . '.webp';
            Image::make($request->logo)->encode('webp', 80)->save($imageName);
        } else {
            $imageName = $buyer->logo;
        }

        $buyer->name = $request->name;
        $buyer->slug = $slug;
        $buyer->logo = $imageName;
        $buyer->save();
        return response()->json('Buyer successfully updated');
    }

    public function deleteBuyer(Request $request)
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
            $buyer = Buyer::where('id', $id)->first();
            if (isset($buyer)) {
                if (File::exists($buyer->logo)) {
                    unlink($buyer->logo);
                }
                $buyer->delete();
            } else {
                return response()->json(['message' => 'Buyer Not found'], 422);
            }
        }
        return response()->json('Buyer successfully deleted');
    }

    public function searchBuyer(Request $request)
    {
        $this->authorize('sadmin');
        $request->validate([
            "collum" => "required"
        ]);
        $buyer = Buyer::where($request->collum, 'LIKE', '%' . $request->keyword . '%')->paginate(20);
        return response()->json(compact('buyer'));
    }
}
