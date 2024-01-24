<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    public function topUpNow (Request $request){
        $user_id = Auth::user()->id;
        $credit = $request->credit;
        $status = 'process';
        $description = 'Top Up Saldo';

        Wallet::create([
            'user_id' => $user_id,
            'credit' => $credit,
            'status' => $status,
            'description' => $description
        ]);

        return redirect()->back()->with('status', 'TopUp request is processed');

    }

    public function withdrawNow(Request $request)
    {
        $user_id = Auth::user()->id;
        $debit = $request->debit;
        $status = 'process';
        $description = 'Withdraw Saldo';

        Wallet::create([
            'user_id' => $user_id,
            'debit' => $debit,
            'status' => $status,
            'description' => $description
        ]);

        return redirect()->back()->with('status', 'Withdrawal request is processed');
    }


    public function acceptRequest(Request $request){
        $wallet_id = $request->wallet_id;

        Wallet::find($wallet_id)->update([
            'status' => 'done'
        ]);

        return redirect()->back()->with('status', 'successfully approved the top up request');
    }

}
