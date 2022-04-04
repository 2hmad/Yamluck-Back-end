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
