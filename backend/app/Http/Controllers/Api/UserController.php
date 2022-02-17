<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    public function allUser()
    {
        $this->authorize("sadmin");
        $users = User::orderBy("created_at", "desc")->with("role")->paginate(50);
        return response()->json(compact("users"));
    }

    public function roleList()
    {
        $this->authorize("sadmin");
        $roles = Role::orderBy("name")->select("id", "name")->get();
        return response()->json(compact("roles"));
    }

    public function statusUser($id)
    {
        $this->authorize("sadmin");
        $user = User::where("id", $id)->first();
        $user->suspend = !$user->suspend;
        $user->save();
        return response()->json("User status successfully changed");
    }

    public function searchUser(Request $request)
    {
        $this->authorize("sadmin");
        $request->validate([
            "collum" => "required"
        ]);
        $users = User::where($request->collum, "LIKE", "%" . $request->keyword . "%")->orderBy("created_at", "desc")->with("role")->paginate(20);
        return response()->json(compact("users"));
    }

    public function createUser(Request $request)
    {
        $this->authorize("sadmin");
        $request->validate([
            "name" => "required",
            "email" => "required",
            "password" => "required|min:6",
            "role_id" => "required",
        ]);

        $slug = Str::slug($request->name) . Str::random(2);

        if ($request->hasFile("avatar")) {
            $path = "images/users/avatar/";
            $imageName = $path . $slug . time() . ".webp";

            if (!File::exists($path)) {
                File::makeDirectory($path, $mode = 0777, true, true);
            }
            Image::make($request->avatar)->encode("webp", 70)->save($imageName);
        };
        $user = new User();
        $user->name = $request->name;
        $user->slug = $slug;
        $user->role_id = $request->role_id;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->text_password = $request->password;
        $request->hasFile("avatar") ? $user->avatar = $imageName : "";
        $user->save();

        return response()->json("User successfully created");
    }

    public function editUser($id)
    {
        $this->authorize("sadmin");
        $user = User::where("id", $id)->first();
        return response()->json(compact("user"));
    }

    public function updatUser(Request $request, $id)
    {
        $this->authorize("sadmin");
        $request->validate([
            "name" => "required",
            "email" => "required",
            "password" => "required|min:6",
            "role_id" => "required",
        ]);

        $user = User::where("id", $id)->first();
        $slug = Str::slug($request->name) . Str::random(2);

        if ($request->hasFile("avatar")) {
            $path = "images/users/avatar/";
            $imageName = $path . $slug . time() . ".webp";

            if (!File::exists($path)) {
                File::makeDirectory($path, $mode = 0777, true, true);
            }

            if ($user->avatar === "images/user.png") {
                Image::make($request->avatar)->encode("webp", 70)->save($imageName);
            } else {
                if (File::exists($user->avatar)) {
                    unlink($user->avatar);
                }
                Image::make($request->avatar)->encode("webp", 70)->save($imageName);
            }
        };
        $user->name = $request->name;
        $user->slug = $slug;
        $user->role_id = $request->role_id;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->text_password = $request->password;
        $request->hasFile("avatar") ? $user->avatar = $imageName : "";
        $user->save();

        return response()->json("User successfully updated");
    }
}
