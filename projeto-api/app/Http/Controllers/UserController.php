<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Wallet;



class UserController extends Controller
{

    protected $user;

     function __construct(User $user, Wallet $wallet)
    {
        $this->user = $user;
        $this->wallet = $wallet;

    }  

     public function store(StoreUserRequest $request){


       $dados = $request->all();
       
       try{
           
           $data = $this->user->create($dados);
           if($data) $this->user->inserTypetUser($dados['type_user'],$data['id']);
           
           $dados['sale'] = 0.00;
           $dados['id_user'] = $data['id'];
           $this->wallet->create($dados);
           
            return response()->json($data, 201);

       } catch (\Exception $e) {
           return response()->json(['messege' => $e->getMessage()], 500);
       }
        

    }

    public function update(StoreUserRequest $request, $id){
      
        $dados = $request->all();
        $userId = $this->user->updateUser($dados, $id);
        return $userId;  

    }

    public function delete(int $id){

        $userId = $this->user->deleteById($id);
        return response()->json($userId);
    } 

    public function index(){

        return response()->json($this->user->all());

    }

    public function show(int $id){

        $userId = $this->user->returnById($id);
        return response()->json($userId);
        
    } 

    public function showEmail(string $email){
    
        $userEmail = $this->user->returnByEmail($email);
        return response()->json($userEmail);
        
    } 

    public function showDocument(string $document){

        $userDocument = $this->user->returnByDocument($document);
        return response()->json($userDocument);
        
    }
}
