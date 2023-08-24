<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Mail;
use App\Models\User;
use App\Enums\UserRolesEnums;
use App\Enums\UserStatusEnums;
use App\Enums\DeleteStatusEnums;
use App\Mail\User\UserRegisterMail;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userList = User::where('status', '!=', DeleteStatusEnums::Deleted)->get();
        return view('user.view',  ['allUserList' => $userList]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:250',
            'email' => 'required|email|max:250|unique:users',
            'dealer_name' => 'required|string|max:250',
            'address' => 'required|string|max:250',
            'phone_no' => 'required|string|max:250',
            'region' => 'required|string|max:40',
            'community' => 'required|string|max:40',
            'role' => ['required', new Enum(UserRolesEnums::class)],
            'status' => ['required', new Enum(UserStatusEnums::class)]
        ], [
            'name.required' => 'Please enter name.',
            'email.required' => 'Please enter email id.',
            'email.email' => 'Please enter valid email id.',
            'email.max' => 'Maximum 250 characters allowed.',
            'email.unique' => 'Email id already exists. Please use another email id.',
            'dealer_name.required' => 'Please enter user company name.',
            'dealer_name.required' => 'Please enter user company name.',
            'address.required' => 'Please enter user company address name.',
            'phone_no.required' => 'Please enter user phone no.',
            'region.required' => 'Please enter user region.',
            'community.required' => 'Please enter user community.',
            'role.required' => 'Please select user role.',
            'status.required' => 'Please select user status.'
        ]);

        $prefix = "SD";  
        $user_code = IdGenerator::generate(['table' => 'users','field'=>'user_code' ,'length' => 7, 'prefix' => $prefix]);
        $password = Str::password(10);
        $hasdedPassword = Hash::make($password);
        // Insert data into the database
        $insertData = new User();
        $insertData->name = $request->name;
        $insertData->email = $request->email;
        $insertData->dealer_name = $request->dealer_name;
        $insertData->address = $request->address;
        $insertData->phone_no = $request->phone_no;
        $insertData->region = $request->region;
        $insertData->community = $request->community;
        $insertData->role = $request->role;
        $insertData->status = $request->status;
        $insertData->user_code = $user_code;
        $insertData->password = $hasdedPassword;
        $insertData->save();

        $mailData = [
            'title' => 'Please find your Dealer Login Details.',
            'body' => 'Email id : '. $request->email . '<br/>
                       Password : '. $password .'<br/>'
        ];
         
        Mail::to($request->email)->send(new UserRegisterMail($mailData));
    
        return redirect()->route('user.create')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
