<?php
namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Support\Facades\Auth;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Mail;
use App\Models\User;
use App\Models\Currency;
use App\Models\DealerPercentage;
use App\Models\MainDealerPercentage;
use App\Enums\UserRolesEnums;
use App\Enums\UserStatusEnums;
use App\Enums\DeleteStatusEnums;
use App\Mail\User\UserRegisterMail;
class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checknewuser');
        $this->middleware('checkroleboth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::user()->id;
        $role = Auth::user()->role;
        $userList = User::where('id', '!=', 1)->where('role','!=', 'subdealer')->get();
        if ($role == 'dealer') {
            $userList = User::leftJoin('sub_dealer_pricing', 'users.id', '=', 'sub_dealer_pricing.sub_dealer_id')
            ->select('users.*', 'sub_dealer_pricing.percentage as percentage')
            ->where('users.dealer_id', '=', $userId)
            ->where('users.id', '!=', 1)
            ->get();
        }
        return view('user.view',  ['allUserList' => $userList]);
    }
    public function viewsubdelear()
    {
        $userList = User::leftJoin('sub_dealer_pricing', 'users.id', '=', 'sub_dealer_pricing.sub_dealer_id')
            ->join('users as dealer', 'sub_dealer_pricing.dealer_id', '=', 'dealer.id')
            ->select('users.*','dealer.dealer_name as maindealer_name', 'sub_dealer_pricing.percentage as percentage')
            ->where('users.role', '=', 'subdealer')
            ->where('users.id', '!=', 1)
            ->get();
        return view('user.viewsubdealer',  ['allUserList' => $userList]);
    }
    public function subdealer(string $id)
    {
        $userList = User::leftJoin('sub_dealer_pricing', 'users.id', '=', 'sub_dealer_pricing.sub_dealer_id')
        ->select('users.*', 'sub_dealer_pricing.percentage as percentage')
        ->where('users.dealer_id', '=', $id)->where('users.role','=', 'subdealer')
        ->get();
        return view('user.subdealerview',  ['allUserList' => $userList]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dealerList = User::where([['role', '=', 'dealer'],['status', '=', 'active']])->get();
        $currencyList = Currency::all();
        return view('user.add',  ['allDealerList' => $dealerList, 'allcurrencyList' => $currencyList]);
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
            'currency' => 'required',
            'identification_no' => 'required|string|max:250|unique:users',
            'role' => ['required', new Enum(UserRolesEnums::class)],
            'dealer_id' => 'required_if:role,subdealer',
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
            'currency.required' => 'Please select currency.',
            'identification_no.required' => 'Please enter identification no.',
            'identification_no.unique' => 'This dealer identification no. already exists.',
            'role.required' => 'Please select user role.',
            'dealer_id.required_if' => 'Please select dealer.',
            'status.required' => 'Please select user status.'
        ]);
        $prefix = "SD";  
        $user_code = IdGenerator::generate(['table' => 'users','field'=>'user_code' ,'length' => 7, 'prefix' => $prefix]);
        $password = Str::password(10);
        $hasdedPassword = Hash::make($password);
        $indentificationNo = $request->identification_no;
        $tokenKey = time().$request->email;
        $token = Hash::make($tokenKey);
        $dealer_id = 0;
        if ($request->dealer_id) {
            $dealer_id = $request->dealer_id;
        }
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
        $insertData->currency = $request->currency;
        $insertData->identification_no = $indentificationNo;
        $insertData->dealer_id = $dealer_id;
        $insertData->status = $request->status;
        $insertData->user_code = $user_code;
        $insertData->password = $hasdedPassword;
        $insertData->token = $token;
        $insertData->created_by = Auth::user()->id;
        $insertData->modified_by = Auth::user()->id;
        $insertData->new_user = 'newuser';
        $insertData->save();
        $mailData = [
            'name' => $request->name,
            'useremail' => $request->email,
            'password' => $password
        ];
        Mail::to($request->email)->send(new UserRegisterMail($mailData));
        if ($request->role == 'subdealer') {
            Mail::to('info@shamsnaturals.com')->send(new UserRegisterMail($mailData));
            return redirect()->route('user.edit',$insertData->id)->with('success', 'Sub Dealer created successfully. Kindly Update Subdealer Percentage.');
        }
        elseif($request->role == 'dealer') {
            return redirect()->route('user.edit',$insertData->id)->with('success', 'Dealer created successfully. Kindly Update Dealer Percentage.');
        }
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
        $userDetails = User::findOrFail($id);
        $currencyList = Currency::all();
        if($userDetails->role == 'subdealer'){
            $percentage = DealerPercentage::where('sub_dealer_id',$id)->first();
            $percentageData = 0;
            $incDec = '';
            $percentageOption = '';
            if($percentage) {
                $percentageData = $percentage->percentage;
            }
        } elseif ($userDetails->role == 'dealer') {
            $percentage = MainDealerPercentage::where('dealer_id',$id)->first();
            if($percentage) {
                $percentageOption = $percentage->discount_option;
                $percentageData = 0;
                $incDec = '';
                if($percentage) {
                    $percentageData = $percentage->percentage;
                    $incDec = $percentage->inc_dec;
                }
            } else {
                $percentageData = 0;
                $incDec = '';
                $percentageOption= 0;
            }
        } else {
            $percentageData = 0;
            $incDec = '';
            $percentageOption= 0;
        }
        $dealerList = User::where([['role', '=', 'dealer'],['status', '=', 'active']])->get();
        return view('user.edit',  ['allDealerList' => $dealerList, 'allcurrencyList' => $currencyList, 'userDetails'=> $userDetails, 'percentage'=> $percentageData, 'incDec' => $incDec, 'percentageOption' => $percentageOption]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:250',
            'email' => 'required|email|max:250|unique:users,email,'.$id,
            'dealer_name' => 'required|string|max:250',
            'address' => 'required|string|max:250',
            'phone_no' => 'required|string|max:250',
            'region' => 'required|string|max:40',
            'community' => 'required|string|max:40',
            'currency' => 'required',
            'identification_no' => 'required|string|max:250|unique:users,identification_no,'.$id,
            'role' => ['required', new Enum(UserRolesEnums::class)],
            'dealer_id' => 'required_if:role,subdealer',
            'discount_option' => 'required',
            'percentage' => 'required_if:role,subdealer|numeric',
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
            'currency.required' => 'Please select currency.',
            'identification_no.required' => 'Please enter identification no.',
            'identification_no.unique' => 'This dealer identification no. already exists.',
            'role.required' => 'Please select user role.',
            'dealer_id.required_if' => 'Please select dealer.',
            'discount_option.required' => 'Please select percentage option',
            'percentage.required_if' => 'Please enter pecentage.',
            'status.required' => 'Please select user status.'
        ]);
        $indentificationNo = $request->identification_no;
        $tokenKey = time().$request->email;
        $token = Hash::make($tokenKey);
        $dealer_id = 0;
        if ($request->dealer_id) {
            $dealer_id = $request->dealer_id;
        }
        $updateData = User::findOrFail($id);
        $updateData->name = $request->name;
        $updateData->email = $request->email;
        $updateData->dealer_name = $request->dealer_name;
        $updateData->address = $request->address;
        $updateData->phone_no = $request->phone_no;
        $updateData->region = $request->region;
        $updateData->community = $request->community;
        $updateData->currency = $request->currency;
        $updateData->identification_no = $indentificationNo;
        $updateData->dealer_id = $dealer_id;
        $updateData->role = $request->role;
        $updateData->status = $request->status;
        $updateData->token = $token;
        $updateData->modified_by = Auth::user()->id;
        $updateData->save();
        if ($request->role == 'subdealer') {
            $percentage = DealerPercentage::where('sub_dealer_id',$id)->first();
            if ($percentage) {
                $perUpdateData = DealerPercentage::findOrFail($percentage->id);
                $perUpdateData->dealer_id = $dealer_id;
                $perUpdateData->percentage = $request->percentage;
                $perUpdateData->save();
            } else {
                $insertData = new DealerPercentage();
                $insertData->dealer_id = $dealer_id;
                $insertData->sub_dealer_id = $id;
                $insertData->percentage = $request->percentage;
                $insertData->save();
            }
        }
        if ($request->role == 'dealer') {
            $percentage = MainDealerPercentage::where('dealer_id',$id)->first();
            if ($percentage) {
                $perUpdateData = MainDealerPercentage::findOrFail($percentage->id);
                $perUpdateData->percentage = $request->percentage;
                $perUpdateData->inc_dec = $request->inc_dec;
                $perUpdateData->discount_option = $request->discount_option;
                $perUpdateData->save();
            } else {
                $insertData = new MainDealerPercentage();
                $insertData->dealer_id = $id;
                $insertData->percentage = $request->percentage;
                $insertData->inc_dec = $request->inc_dec;
                $insertData->discount_option = $request->discount_option;
                $insertData->save();
            }
        }
        return redirect()->route('user.index')->with('success', 'User updated successfully.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}