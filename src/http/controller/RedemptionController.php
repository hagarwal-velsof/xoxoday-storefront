<?php

namespace Xoxoday\Storefront\Http\Controller;

use Illuminate\Routing\Controller;
use Xoxoday\Storefront\Models\Product;
use Xoxoday\Storefront\Models\Redemption;
use Xoxoday\Storefront\Models\User;
use Xoxoday\Storefront\Models\State;
use Xoxoday\Storefront\Models\LoyaltyPoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Session;
use Config;
use Xoxoday\Sms\Sms;



class RedemptionController extends Controller
{
    /*
     * Function to show the login page
     */
    public function index()
    {   
        
        $products =  Product::get();
        $total_points = 0;
        $mobile = '';
        $user_bit = 0;
        $name = '';
        $states = State::all();
        $inprogress_product = array(); 
        // dd(Session::all());
        if (Auth::check()) {
            $user = Auth::user();
            $total_points = LoyaltyPoint::where('user_id', $user['id'])->sum('points');
            $first_name_array = explode(' ',$user->name);
            $first_name = $first_name_array[0];
            $name = $user->name;
            $mobile = $user->mobile;
            $user_bit = 1;
            $inprogress_product = Redemption::where('user_id', $user['id'])->where('status','0')->get()->pluck('product')->toArray();
          //  $inprogress_product = implode(',',$inprogress_product);
            return view('storefront::redemption',compact(['user','total_points','products','inprogress_product','name','mobile','user_bit','states']));
        }
        
        
        return view('storefront::redemption',compact(['products','total_points','mobile','name','user_bit','inprogress_product','states']));
    }

    /*
     * Function to validate login
     */
    public function verifyLogin(Request $request)
    {
       
        if (isset($request->mobile) && isset($request->otp) && isset($request->product_id)) {
            $mobile = $request->mobile;
            $product_id = $request->product_id;
            if (Auth::check()) {
                $otp = Config('app.default_otp');
            } else {
                $otp = $request->otp;
            }

            if (Auth::attempt(array('mobile' => $mobile, 'password' => $otp))) {
                // $request->session()->regenerate();
                $user = Auth::user();
                $product = Product::where('id', $product_id)->first();
                $inprogress_product = Redemption::where('user_id', $user['id'])->where('status','0')->get()->pluck('product')->toArray();
                if(in_array($product_id,$inprogress_product)){
                    return response()->json(['error' => 'A claim for this product is already in process.']);
                }
                $total_points = DB::table('loyalty_points')->where('user_id', $user['id'])->sum('points');
                if ($product && $total_points >= $product['points']) {
                    return response()->json(['success' => 'User Authenticated successfully.', 'product' => $product, 'total_points' => $total_points]);
                } elseif ($product && $total_points < $product['points']) {
                    return response()->json(['error' => 'Not enough loyalty points']);
                } else {
                    return response()->json(['error' => 'Product not available.']);
                }
            } else {
                return response()->json(['error' => 'OTP verification failed. Please try again.']);
            }

        } elseif (isset($request->mobile) && isset($request->otp)) {
           
            $mobile = $request->mobile;
            $otp = $request->otp;
            if (Auth::attempt(array('mobile' => $mobile, 'password' => $otp),true)) {
                return response()->json(['success' => 'User logged in successfully.']);
            } else {
                return response()->json(['error' => 'OTP verification failed. Please try again.']);
            }
            
        } else {
            return response()->json(['error' => 'OTP verification failed. Please try again.']);
        }

    }

    /*
     * Function to add points after customer confirmations and OTP verification
     */
    public function redeemPoints(Request $request)
    {
        $mobile = $request->mobile;
        $product_id = $request->product_id;
        $address =  $request->address;
        $address2 =  $request->address;
        $city =  $request->city;
        $state =  $request->state;
        $pincode =  $request->pincode;
        $landmark =  $request->landmark;

        if($address == '' || $city == '' || $state == '' || $pincode == '' || $mobile == '' || $product_id == '' ){
            return response()->json(['error' => 'Request failed due to some error.']);
        }
        try {
            $user_id = User::select('id')->where('mobile', $mobile)->first();
        } catch (QueryException $ex) {
            Log::channel('sql_error')->info(date('Y-m-d H:i:s') . ':: RedemptionController-User id fetching Failed :: SQL Error code' . $ex->errorInfo[1] . ' -SQL Error Message' . $ex->getmessage());
            return response()->json(['error' => 'Reqeust failed due to some error.']);
        }

        if ($user_id) {
            $product = Product::where('id', $product_id)->first();
            $total_points = LoyaltyPoint::where('user_id', $user_id['id'])->sum('points');
            if ($total_points >= $product['points']) {
                try {
                    $redemption_create = Redemption::create([
                        'user_id' => $user_id['id'],
                        'product' => $product_id,
                        'status' => 0, //save default status as 0 - Pending
                        'request_date' => date('Y-m-d H:i:s'),
                        'address' => $address,
                        'address2' => $address2,
                        'city' => $city,
                        'state' => $state,
                        'pincode' => $pincode,
                        'landmark' => $landmark
                    ]);
                } catch (QueryException $ex) {
                    Log::channel('sql_error')->info(date('Y-m-d H:i:s') . ':: RedemptionController-Redemption entry Failed :: SQL Error code' . $ex->errorInfo[1] . ' -SQL Error Message' . $ex->getmessage());
                    return response()->json(['error' => 'Request failed due to some error.']);
                }
                $points_redeemed = 0 - $product['points'];

                Session::put('redeem_product_id', $product_id);

                if ($redemption_create) {
                    $points_adjustment = $this->addLoyaltyPoints($user_id['id'], 0, $points_redeemed, 'Points Redeemed', $redemption_create['id']);
                    if ($points_adjustment) {
                        return response()->json(['success' => 'Points Redeemed','url' => url("/confirmation")]);
                    }
                } else {
                    return response()->json(['error' => 'Request failed due to some error.']);
                }
            } else {
                return response()->json(['error' => 'Request failed due to some error.']);
            }
        } else {
            return response()->json(['error' => 'User not found.']);
        }
    }

    public function logout (Request $request){

        if (Auth::check()) {
            Session::flush();
            Auth::logout();
            return response()->json(['success' => 'Logout Successfully']);
        }else{
            return response()->json(['success' => 'No user logged in.']);
        }
        
    }

    public function confirmation(){
        $user_bit = 0;
        $total_points = 0;
        $product = '';
        if (Auth::check()) {
            $user = Auth::user();
            $user_bit = 1;
            $total_points = LoyaltyPoint::where('user_id', $user['id'])->sum('points');
            $product_id = Session::get('redeem_product_id');
            if($product_id == null){
                $this->index();
            }
            $product =  Product::where('id', $product_id)->first();
            return view('storefront::confirmation',compact(['product','total_points','user_bit']));
        }else{
            $error = "Kindly login to redeem points";
            return view('storefront::confirmation',compact(['error','user_bit','product','total_points']));
        }
        
    }

    public function sendOtp(Request $request)
    {
        
        $last_sent_time = Session::get('last_sms_time');
        if(!empty($last_sent_time) && (time() - $last_sent_time) < 60) {
            return "Failed";
        }
        if (isset($request->mobile)) {
            $mobile = $request->mobile;
            // $otp = $this->generateUniqueNumber();
            // $sent_status = $this->sendSMS($mobile, $otp);
            // if (!$sent_status) {
            //     // If SMS Is not sent then use the default password.
            //     $otp = Config('app.default_otp');
            // }
            $otp = Config('app.default_otp');
            $password = bcrypt($otp);
            try {
                $otp_status_update = User::where('mobile', $mobile)->update(['password' => $password]);
            } catch (QueryException $ex) {
                Log::channel('sql_error')->info(date('Y-m-d H:i:s') . ':: ApiController-Code status update Failed :: SQL Error code' . $ex->errorInfo[1] . ' -SQL Error Message' . $ex->getmessage());
                echo "Failed";
                die();
            }
            echo "Success";
        } else {
            echo "Failed";
        }
        die();
    }

    private function sendSMS($mobile, $otp)
    {
        Session::put('last_sms_time', time());
        Session::save();
        $sms = new Sms();

        return $sms->notification($mobile, Config('app.sms_message_otp'), $otp);
    }

    private function generateUniqueNumber($length = 4)
    {
        $input = '0123456789'; //Allowed Char List
        $input_length = strlen($input);
        $random_string = '';
        for ($i = 0; $i < $length; $i++) {
            $random_character = $input[mt_rand(0, $input_length - 1)]; //Randonly pick char from the given input list. 
            $random_string .= $random_character; //Append picked char to the final code.
        }
        return $random_string;
    }

    public function addLoyaltyPoints($user_id, $code_id, $points, $reason, $redemption_id)
    {
        try {
            $loyalty_points_entry = LoyaltyPoint::create([
                'user_id' => $user_id,
                'code_id' => $code_id,
                'redemption_id' => $redemption_id,
                'reason' => $reason,
                'points' => $points,
                'date_added' => date('Y-m-d H:i:s'),
            ]);

            return true;
        } catch (QueryException $ex) {
            Log::channel('sql_error')->info(date('Y-m-d H:i:s') . ':: ApiController-Loyalty Points entry Failed :: SQL Error code' . $ex->errorInfo[1] . ' -SQL Error Message' . $ex->getmessage());
            return false;
        }
    }

}
