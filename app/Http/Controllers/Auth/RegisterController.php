<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function modifier(Request $request ,$id)
    {
        $request->validate([
            'name' => 'required|string',
            'Email' => 'required|email',
            'password' => 'required|min:8|max:15',
        ]);  
       $id->update([
           'name' => $request->nom,
           'prenom' =>$request->prenom,
           'Email'=>$request->Email,
           'password' => Hash::make($request['password']),

       ]);
       return response()->json(['message'=>'Fournisseur Modifié']);
    }
    public function update(Request $request)
    {
        $article = User::where('id',8)->first();
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8',
           
        ]);
         $name = null;
         $photo = $article->image;
        if($request->hasFile('image')){
            $name = time().'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('image'),$name);
            $photo = '/image/'.$name;
        } 
        $url = explode('/',url()->current());
        $article->update([
            'name' => $request->name,
            'email' =>$request->email,
            'password'=>$request->password,
            'image'=>$photo,
        ]);
        return response()->json(['message'=>$request->name]);
    }
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }
    public function index()
    {
        return User::latest()->paginate(8);
    }
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
     public function destroy($id)
    {
        $invoice = User::findOrFail($id);

        $invoice->delete();

        return response()
            ->json(['deleted' => true]);
    }

    public function profile()
    {
        $user = Auth::user();
        return  response()
        ->json(['user' => $user]);
    }
    public function show()
    {
        $user = User::where('id',8)->first();
       return  response()
       ->json(['id' => $user->id,
       'email' => $user->email,
       'name' => $user->name,
       'password' => $user->password,
       'image' => $user->image
       ]);
       
    }
  
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|string|unique:users',
            'name' => 'required|string|max:255',
            'password' => 'required|min:8',
        ]);
        return User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);
    }
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
