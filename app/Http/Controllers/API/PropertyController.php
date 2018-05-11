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
use App\Property;

/**
 * Description of PropertyController
 *
 * @author jaaouani
 */
class PropertyController extends Controller {
     
     private $request = null;
     private $validator = null;
     private $property = null;
     
     public function __construct(Request $request) { 
         $this->request = $request; 
     }
     
     public function createProperty() {
         if($this->_verifyRequestNew() == true) {
             $exist = Property::where('name', $this->request->input('name'))->first();
                   if($exist !== null) { return response()->json(['status' => 'error', 'message' => 'Nom de propriété existant'], 401); }
             $this->property = new Property; $this->property->price = $this->request->input('price'); $this->property->name = $this->request->input('name');
             $this->property->description = $this->request->input('description'); $this->property->address = $this->request->input('address');
             $this->property->logement = $this->request->input('logement'); $this->property->location = $this->request->input('location');
             $this->property->surface = $this->request->input('surface'); $this->property->user_id = Auth::user()->id; 
             $this->property->rooms_number = $this->request->input('rooms_number');
                   if(!$this->property->save()) { return response()->json(['status' => 'error', 'message' => 'Impossible d\'ajouter cette nouvelle propriété.'], 401); }
                   else { return response()->json(['status' => 'success', 'id' => $this->property->id], 200); }
         } else if($this->_verifyRequestNew() == false) { return response()->json(['message' => $this->validator->errors()->first(), 'status' => 'error'], 401); }
     }
     
     public function retrieveProperty() {
         
     }
     
     private function _verifyRequestNew() {
         $this->validator = Validator::make($this->request->all(),[
               'name' => 'required|string', 'description' => 'required|string',
               'address' => 'required|string', 'logement' => 'required|string', 'location' => 'required|string',
               'price' => 'required|string', 'surface' => 'required|numeric', 'rooms_number' => 'required|string'
         ]);
         if($this->validator->fails()) { return false; }
         else { return true; }
     }
}
