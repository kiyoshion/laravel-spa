<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Auth;
use App\User;
use App\Item;

class HomeController extends Controller
{
    public function index()
    {
        $items = Item::where('user_id', \Auth::user()->id)
            ->with(['user', 'likes', 'comments'])
            ->orderBy('created_at', 'desc')
            ->paginate();

        // $items = Item::user()->paginate();

        return $items;
    }
    
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->profile = $request->profile;
        $user->update($request->all());

        return response($user, 201);
    }

    public function upload(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $file_name = date('YmdHis') . '-' . $id;
        $file_path = '/images/users/' . $id . '/avatar/';
        if (!file_exists(public_path() . $file_path)) {
            mkdir(public_path() . $file_path, 666, true);
        } else {
            $dir = glob(public_path() . $file_path . '*');
            foreach($dir as $target) {
                unlink($target);
            }
        }
        $avatar = Image::make($request->file->getRealPath())
        ->resize(150, null, function($constraint) {
            $constraint->aspectRatio();
        });
        $avatar->save(public_path() . $file_path . $file_name);
        $user->avatar = $file_path . $file_name;
        $user->save();

        return response($user, 201);
    }
}
