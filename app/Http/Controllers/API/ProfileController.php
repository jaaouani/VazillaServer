<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\User;

/**
 * Description of ProfileController
 *
 * @author jaaouani
 */
class ProfileController extends Controller {
    private $request = null;
    private $user = null;
    private $validator = null;
    
    public function __construct(Request $request) { $this->request = $request; }
    
    public function retrieveAccount() {
        $this->user = $this->request->user();
        return $this->user;
    }
}
