<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Plant;
class DiaryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {

        $user = User::where('id', Auth::id())->first();
        $plant = Plant::whereId($request->id)->first();

        if($user->plants()->get()->contains($plant)){     
            return view('diary', ['user' => $user, 'plant' => $plant ]);
        }else return redirect()->back();
    }

    public function diaryUpdate(Request $request){
            $plant = Plant::whereId($request->id)->first();
            $plant->diary = $request->diary;

            $plant->save();

            return redirect()->back();
    }
}