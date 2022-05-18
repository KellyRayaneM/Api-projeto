<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wallet extends Model
{
    use HasFactory,SoftDeletes;

    public $incrementing = true;

    protected $fillable = [
        'id_user',
        'sale'
    ];

    public function returnWallet(int $idUser){

        $sale = DB::table('wallets')->where('id_user', $idUser)->get();
        return $sale;

    }

    public function updateWallet(float $walletSale, int $idUser) {

        $wallet = DB::table('wallets')
                ->where('id_user', $idUser)
                ->update(
                    ['sale' => $walletSale]
                );
        
        return $wallet;
    }

   /*  public function validaTransaction(int $idUser){

        $users = DB::table('users')
                     ->join('wallets', 'users.id_user', '=', 'wallets.id_user')
                     ->join('user_common', 'users.id_user', '=', 'user_common.id_user')
                     ->select(DB::raw('wallet.sale'))
                     ->where('users.id_user', '=', $idUser)
                     ->get();
           
        return $users;
    } */

}
