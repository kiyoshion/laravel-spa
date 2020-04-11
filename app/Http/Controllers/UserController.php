<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class UserController extends Controller
{
    
    public function edit(Request $request, $id)
    {
        $user = Auth::where('id', $id);
        var_dump($id);
        $user->name = $request->name;
        $user->save();

        return response($user, 201);
    }
}
