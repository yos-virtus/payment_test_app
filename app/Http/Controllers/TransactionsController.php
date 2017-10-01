<?php

namespace App\Http\Controllers;

use App\User;
use App\UserTransaction;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    public function index(Request $request)
    {
        $user = User::with(['transactions' => function($query) {
                        return $query->orderBy('created_at')->take(30);
                    }])->where('name', $request->name)->first();


        return view('transactions', compact('user'));
    }
}
