<?php

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use Laravel\Passport\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\User;

/**
 * Description of AccountController
 *
 * @author jaaouani
 */
class AccountController extends Controller {
   
    private $request = null;
    private $user = null;
    private $validator = null;
    private $client = null;
    
    public function __construct(Request $request) { 
        $this->request = $request; 
        $this->client = Client::find(2);
    }
   
    public function createAccount() {
        if($this->_verifyRequestRegister() == true) { $existing = User::where('email', $this->request->input('email'))->first();
          if($existing == null) { $this->user = new User();
                $this->user->fullname = $this->request->input('fullname'); $this->user->password = Hash::make($this->request->input('password'));
                $this->user->email = $this->request->input('email'); $this->user->token = Hash::make($this->request->email.str_random(25).$this->request->fullname);
                $this->user->reference = uniqid('@KEY').'@REF@'. str_random(5);
                        if(!$this->user->save()) { return response()->json(['message' => 'Inscription échoué.', 'status' => 'error'], 401); }
                        else { return $this->loginAccount(); }
          } else { return response()->json(['status' => 'error', 'message' => 'Un utilisateur avec cet email existe chez nous'], 401); }
        } else if($this->_verifyRequestRegister() == false) { return response()->json(['message' => $this->validator->errors()->first(), 'status' => 'error'], 401); }
    }
    
    public function loginAccount() {
        if($this->_verifyRequestLogin() == true) {
            $params = [ 'grant_type' => 'password', 'client_id' => $this->client->id, 
                              'client_secret' => $this->client->secret,
                              'username' => $this->request->input('email'), 
                              'password' => $this->request->input('password'), 
                              'scope' => '*' 
                            ];
            $this->request->request->add($params); $proxy = Request::create('oauth/token', 'POST');
            return Route::dispatch($proxy);
        } else if($this->_verifyRequestLogin() == false) { return response()->json(['message' => $this->validator->errors()->first(), 'status' => 'error'], 401); }
    }
    
    public function refreshAccount() {
        if($this->_verifyRequestRefresh() == true) {
            $params = [ 'grant_type' => 'refresh_token', 'refresh_token' => $this->request->input('refresh_token'),
                              'client_id' => $this->client->id, 'client_secret' => $this->client->secret, 'scope' => '*' ];
            $this->request->request->add($params); $proxy = Request::create('oauth/token', 'POST');
            return Route::dispatch($proxy);
        } else { return response()->json(['status' => 'error', 'message' => 'Token de rafraichissemnt non fourni'], 401); }
    }
    
    public function logoutAccount() {
        if(Auth::check()) {
            Auth::user()->OauthAccessToken()->delete();
            return response()->json(['message' => 'Déconnexion à succès.', 'status' => 'success'], 200);
        } else { return response()->json(['message' => 'Déconnexion échoué', 'status' => 'error'], 401); }
    }
    
    private function _verifyRequestLogin() {
        $this->validator = Validator::make($this->request->all(), [ 
            'email' => 'required|email|max:200',
            'password' => 'required|string|max:20|min:8'
        ]); if($this->validator->fails()) { return false; } else { return true; }
    }
    
    private function _verifyRequestRegister() {
        $this->validator = Validator::make($this->request->all(), [
            'email' => 'required|email|max:200',
            'password' => 'required|string|max:20|min:8',
            'fullname' => 'required|string|min:4'
        ]); if($this->validator->fails()) { return false; } else { return true; }
    }
    
    private function _verifyRequestRefresh() {
        $this->validator = Validator::make($this->request->all(), [
            'refresh_token' => 'required|string'
        ]); if($this->validator->fails()) { return false; } else { return true; }
    }
    
    private function _verifyRequestLogout() {
        $this->validator = Validator::make($this->request->all(), [
            'access_token' => 'required|string'
        ]); if($this->validator->fails()) { return false; } else { return true; }
    }
}
