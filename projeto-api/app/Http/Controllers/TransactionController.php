<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction as Transaction;

class TransactionController extends Controller
{

    protected $transaction;

     function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;

    }  
    
    public function index()
    {
        return response()->json($this->transaction->all());
    }

   
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        
    }

    
    public function show($id)
    {
        //
    }

   
    public function edit($id)
    {
        //
    }

    
    public function update(Request $request, $id)
    {
        //
    }

   
    public function destroy($id)
    {
        //
    }
}
