<?php
namespace App\Http\Controllers\Auth;

namespace App\Http\Controllers\API;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use Illuminate\Support\Facades\Auth;


class AdminController extends Controller
{
    use RegistersUsers;




    protected $redirectTo = RouteServiceProvider::HOME;


    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'Email' => 'required|email|string|unique:users',
            'name' => 'required|string|max:255',
            'password' => 'required|min:8|confirmed',
        ]);
        return User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'image'=> $request['image']->nullable,
            'password' => Hash::make($request['password']),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::where('id',$id)->first();
        return response()->json([ 
            'id'=>$user->id,
            'Email' => $user->email,
            'name' => $user->name,
            'password' => $user->password,
            ]);
    }
    public function profile()
    {
        $user = Auth::user();
       
       $admin = auth()->user();
        return  response()
        ->json([
        'auth'=>$user
        ]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::where('id',$id)->first();

        $request->validate([
            'Email' => 'required|email',
            'name' => 'required|string|max:255',
            'password' => 'required|min:8',
        ]);
        $user->update([
            'Email' => $request->email,
            'name' => $request->name,
            'password' => Hash::make($request['password']),
        ]);
        return response()->json(['message'=>'Agent Modifié']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $invoice = User::findOrFail($id);

        $invoice->delete();

        return response()
            ->json(['deleted' => true]);
    }
}
