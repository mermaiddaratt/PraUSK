<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        if(Auth::user()->role == 'admin'){
            $user = User::all()->count();
            $products = Product::all()->count();
            $transactions = Transaction::all()->count();
            $userAll = User::all();
            $mutasi = Wallet::where('status', 'done')->orderBy('created_at', 'DESC')->get();
            $transactionsAll = Transaction::where('status', 'paid')->orderBy('created_at', 'DESC')->paginate(5)->groupBy('order_id');


            return view('home', compact('mutasi', 'user','products', 'transactions', 'userAll', 'transactionsAll'));
        }

        if(Auth::user()->role == 'kantin'){
            $products = Product::all();
            $allProducts = Product::all()->count();
            $transactions = Wallet::where('description', 'Buy Product')->count();
            // $transactionAll = Transaction::where('status', 'paid')
            //     ->where('user_id', Auth::user()->id)
            //     ->orderBy('created_at', 'DESC')
            //     ->paginate(5)
            //     ->groupBy('order_id');
            $transactionAll = Transaction::where('status', 'paid')->orderBy('created_at', 'DESC')->paginate(5)->groupBy('order_id');
            $wallets = Wallet::where('description', 'Buy Product')->get();

            $credit = 0;
            $debit = 0;
            foreach ($wallets as $wallet){
                $credit += $wallet->credit;
                $debit += $wallet->debit;
            }
            $saldo = $debit + $credit;
            return view('home', compact('saldo', 'products', 'allProducts', 'transactions', 'transactionAll'));
        }

        if(Auth::user()->role == 'bank'){
            $wallets = Wallet::where('status', 'done')->get();

            $credit = 0;
            $debit = 0;
            foreach ($wallets as $wallet){
                $credit += $wallet->credit;
                $debit += $wallet->debit;
            }
            $saldo = $credit - $debit;
            $nasabah = User::where('role', 'siswa')->get()->count();
            $transactions = Transaction::all()->groupBy('order_id')->count();
            $request_payment = Wallet::where('status', 'process')->orderBy('created_at', 'DESC')->get();
            $mutasi = Wallet::where('status', 'done')->orderBy('created_at', 'DESC')->get();
            $allMutasi = Wallet::where('status', 'done')->count();


            return view('home', compact('allMutasi', 'saldo', 'nasabah', 'transactions', 'request_payment', 'mutasi'));
        }

        if (Auth::user()->role == 'siswa') {

            $wallets = Wallet::where('user_id', Auth::user()->id)->where('status', 'done')->get();
            $credit = 0;
            $debit = 0;

            foreach ($wallets as $wallet) {
                $credit += $wallet->credit;
                $debit += $wallet->debit;
            }

            $saldo = $credit - $debit;

            $carts = Transaction::where('status', 'not_paid')->where('user_id', Auth::user()->id)->get();
            $total_biaya = 0;
            $products = Product::all();

            foreach ($carts as $cart) {
                $total_price = $cart->price * $cart->quantity;
                $total_biaya += $total_price;
            }

            $transactions = Transaction::where('status', 'paid')
                ->where('user_id', Auth::user()->id)
                ->orderBy('created_at', 'DESC')
                ->paginate(5)
                ->groupBy('order_id');
            // $transactions = Transaction::where('status', 'paid')->where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->groupBy('order_id');
            $mutasi = Wallet::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->get();

            return view('home', compact('saldo', 'products', 'carts', 'total_biaya', 'mutasi', 'transactions', ));
        }
    }
}
