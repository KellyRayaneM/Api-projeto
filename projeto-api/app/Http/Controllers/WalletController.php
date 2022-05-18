<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wallet as Wallet;
use App\Models\User as User;
use App\Models\Transaction as Transaction;
use Illuminate\Support\Collection;


class WalletController extends Controller
{
    
    protected $wallet;

     function __construct(Wallet $wallet,User $user, Transaction $transaction)
    {
        $this->wallet = $wallet;
        $this->user = $user;
        $this->transaction = $transaction;

    } 

    public function index()
    {
        return response()->json($this->wallet->all());
    }
    
    public function store(Request $request)
    {
        $dadosRequest = $request->all();

        $this->validate($request, ['id_user' => 'required|integer','sale' => 'required|numeric|min:0.01']);

        $userId = $this->user->returnById($dadosRequest['id_user']);

        if (!$userId) return response()->json(['message' => 'user not found'], 404);

        $walletDados = $this->wallet->returnWallet($request->id_user)->all();

        if(!empty($walletDados[0]->sale)){
           
            $walletDados[0]->sale += $dadosRequest['sale'];

            try{

                $wallet = $this->wallet->updateWallet($walletDados[0]->sale, $walletDados[0]->id_user);
                $this->transaction->insertTransactionDeposit($dadosRequest['sale'], $walletDados[0]->id_user);
                return response()->json($wallet, 201);

             } catch (\Exception $e) {
              return response()->json(['messege' => $e->getMessage()], 500);
           }
        }
        
       try{

            $this->wallet->beginTransaction();

            $wallet = $this->wallet->create($dadosRequest);
            $this->transaction->insertTransactionDeposit($dadosRequest['sale'], $dadosRequest['id_user']);

            $this->wallet->commit();
            
            return response()->json($wallet, 201);
       } catch (\Exception $e) {
           $this->wallet->rollBack();
           return response()->json(['messege' => $e->getMessage()], 500);
       }
    }

   
    public function show($id)
    {
        //
    }
  
    public function transfer(Request $request)
    {
        $this->validate($request, [
            'id_user_in' => 'required|integer',
            'id_user_out' => 'required|integer',
            'value' => 'required|numeric|min:0.01'
        ]);

        if ($request->id_user_in == $request->id_user_out) {
            return response()->json(['message' => 'Transfer to yourself is not allowed.'], 401);
        } 

        $id_user_in = $this->wallet->returnWallet($request->id_user_in)->all();
        $id_user_out = $this->wallet->returnWallet($request->id_user_out)->all();

        if (!$id_user_in) return response()->json(['message' => 'user in not found'], 404);
        if (!$id_user_out) return response()->json(['message' => 'user not found please register for account'], 404);

        $userCommom = $this->user->returnByIdUserCommum($request->id_user_out)->all();
      
        if(!$userCommom) return response()->json(['message' => ' transfer not allowed for this type of user'], 401);

        if ($id_user_out[0]->sale <= $request->value) return response()->json(['message' => 'insufficient sale'], 401);

        try{

            $this->wallet->beginTransaction();

            $transition = $this->transaction->insertTransactionTransfer($request->all());
            $id_user_in[0]->sale += $request->value;
            $id_user_out[0]->sale -= $request->value;
            $this->wallet->updateWallet($id_user_in[0]->sale, $request->id_user_in);
            $this->wallet->updateWallet($id_user_out[0]->sale, $request->id_user_out);

            $this->wallet->commit();

            return response()->json($transition);
        }catch(\Exception $e) {
            $this->wallet->rollBack();
            return response()->json(['message' => 'Unable to transfer'], 501);
        }
    }
}
