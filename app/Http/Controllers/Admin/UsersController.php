<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Users;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    {
        return Users::orderBy('id', 'DESC')->with('country')->get();
    }
    public function switchBlock(Request $request)
    {
        $getUser = Users::where('id', $request->id)->first();
        if ($getUser->block == '0') {
            Users::where('id', $request->id)->update('block', '1');
            return response()->json(['alert' => 'The user is blocked']);
        } else {
            Users::where('id', $request->id)->update('block', '0');
            return response()->json(['alert' => 'User ban removed']);
        }
    }
    public function deleteUser(Request $request)
    {
        return Users::where('id', '=', $request->id)->delete();
    }
    public function getTotalUsers()
    {
        return Users::count();
    }
    public function getActiveUsers()
    {
        return Users::where('verified', 1)->count();
    }
    public function getPendingUsers()
    {
        return Users::where('verified', 0)->count();
    }
}
