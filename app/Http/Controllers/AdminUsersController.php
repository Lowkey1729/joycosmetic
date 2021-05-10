<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class AdminUsersController extends Controller
{
    public function __construct ()
    {
        $this->middleware('admin');
    }

    public function list()
    {
        $users = User::all();
        $counts = User::count();
        return view('admin.users', ['users'=>$users, 'counts'=>$counts]);
    }
}
