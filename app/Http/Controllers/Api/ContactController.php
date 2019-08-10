<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use JWTAuth;
class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $user;

    /**
     * Adds the Middleware to chekc whether the user is logged in or not
     */
    public function __construct()
    {
        // check the user is logged in or not
        $this->middleware('jwtcustom');
        // if the user is logged in then fetches the details of the user
        $this->middleware(function($request, $next) {
            $this->user = JWTAuth::parseToken()->authenticate();
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        
        $data = User::where('user_id', $this->user->id)
                        ->when($request->filled('search'), function($q) use ($request)
                        {
                            $q->where('username', 'like', '% '. $request->input("search").' %');
                            $q->where('first_name', 'like', '% '. $request->input("search").' %');
                            $q->where('last_name', 'like', '% '. $request->input("search").' %');

                        })->get();
        if ($data->count()) {
            return response()->json(['message'=>'Contacts Found', 'contacts'=>$data], 200);
        }
        return response()->json(['message'=>'No Contacts Found'], 400);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'username'=>'bail|required|string|min:1|max:25|unique:users,username',
            'phone_number'=>'bail|required|numeric|digits_between:10,12',
            'email'=>'bail|required|email|string|min:1|max:50',
            'first_name'=>'bail|required|string|min:1|max:50',
            'last_name'=>'bail|string|min:1|max:50',
            'image'=>'bail|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'city'=>'bail|string|min:1|max:50',
            'pin'=>'bail|string|min:1|max:10',
        ]);

        $user = User::create($request->only('username', 'phone_number', 'email', 'first_name', 'last_name'));
        $user->role = 2;
        $user->password = bcrypt(rand(1001, 9999));

        $imageName = null;
        if (request()->image) {
            $imageName = time().'.'.request()->image->getClientOriginalExtension();
            request()->image->move(public_path('images'), $imageName);
        }
        
        $user->image = $imageName;
        $user->user_id = $this->user->id;
        if ($user->save()) {
            return response()->json(['message'=>'Contacts Saved', 'contact'=>$user], 200);
        }

        return response()->json(['message'=>'Something went wrong'], 400);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $data = User::where('id', $id)->first(); 
       if ($data) {
            return response()->json(['message'=>'Contacts Found', 'contacts'=>$data], 200);
        }
        return response()->json(['message'=>'No Contacts Found'], 400);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
       $request->validate([
            'username'=>'bail|required|string|min:1|max:25|unique:users,username,'.$id.',id',
            'phone_number'=>'bail|required|numeric|digits_between:10,12',
            'email'=>'bail|required|email|string|min:1|max:50',
            'first_name'=>'bail|required|string|min:1|max:50',
            'last_name'=>'bail|string|min:1|max:50',
            'image'=>'bail|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'city'=>'bail|string|min:1|max:50',
            'pin'=>'bail|string|min:1|max:10',
        ]);
        $data = $request->only('username', 'phone_number', 'email', 'first_name', 'last_name', 
                            'city', 'pin');

        
        $imageName = null;
        if (request()->image) {
            $imageName = time().'.'.request()->image->getClientOriginalExtension();
            request()->image->move(public_path('images'), $imageName);
        }
        
        $data['image'] = $imageName;
        
        if ( User::where('id', $id)->update($data)) {
            return response()->json(['message'=>'Contacts Saved', 'contact'=>$data], 200);
        }

        return response()->json(['message'=>'Something went wrong'], 400);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $data = User::where('id', $id)->delete(); 

       if ($data) {
            return response()->json(['message'=>'Contacts Deleted'], 200);
        }
        return response()->json(['message'=>'Something went wrong'], 400);
    }
}
