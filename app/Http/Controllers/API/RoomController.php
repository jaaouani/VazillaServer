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
use App\Room;
use App\Property;
/**
 * Description of RoomController
 *
 * @author jaaouani
 */
class RoomController extends Controller {
    
    private $request = null;
    private $validator = null;
    private $room = null;
    
    public function __construct(Request $request) {
        $this->request = $request;
    }
    
     public function createRoom() {
         if($this->_verifyRequestNew() == true) {
             $this->room = new Room();
                $this->room->name = $this->request->input('name');
                $this->room->surface = $this->request->input('surface');
                $this->room->property_id = $this->request->input('property_id');
            if(!$this->room->save()) { return response()->json(['status' => 'error', 'message' => 'Impossible d\'ajouter cette nouvelle chambre.'], 401); }
            else { return response()->json(['status' => 'success'], 200); }
         } else if($this->_verifyRequestNew() == false) { return response()->json(['message' => $this->validator->errors()->first(), 'status' => 'error'], 401); }
     }
     
     public function retrieveRoom() {
     }
     
     private function _verifyRequestNew() {
         $this->validator = Validator::make($this->request->all(),[
            'surface' => 'required|string', 'name' => 'required|string',
            'property_id' => 'required|string' 
         ]);
         if($this->validator->fails()) { return false; }
         else { return true; }
     }
}
