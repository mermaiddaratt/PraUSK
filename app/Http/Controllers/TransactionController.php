<?php

namespace App\Http\Controllers;
use App\Models\Transaction;
use App\Models\Product;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function payNow(){
        $status = 'paid';
        $order_id = 'INV_' . Auth::user()->id . date('YmdHis');

        $carts = Transaction::where('user_id', Auth::user()->id)->where('status', 'not_paid')->get();
        $total_debit = 0;
        foreach($carts as $cart){
            $total_price = $cart->price * $cart->quantity;
            $total_debit += $total_price;
        }

        $wallets = Wallet::where('user_id', Auth::user()->id)->get();
        $credit = 0;
        $debit = 0;

        foreach($wallets as $wallet){
            $credit += $wallet->credit;
            $debit += $wallet->debit;
        }

        $saldo = $credit - $debit;

        if($total_debit > $saldo){
            return redirect()-> back()->with('status', 'Saldo tidak cukup');
        }

        else{
            foreach($carts as $cart){
                if($cart->product->stock > 0){
                    Transaction::find($cart->id)->update([
                        'status' => $status,
                        'order_id' => $order_id
                    ]);

                    Product::find($cart->product->id)->update([
                        'stok' => $cart->product->stock - $cart->quantity,
                    ]);
                }
                else{
                    $total_debit = $total_debit - ($cart->price * $cart->quantity);
                }
                Wallet::create([
                    'user_id' => Auth::user()->id,
                    'debit' => $total_debit,
                    'description' => 'Buy Product',
                ]);
            }

            return redirect()->back()->with('status', 'Success Payment');
        }
    }

    public function addToCart (Request $request){

        $user_id = $request->user_id;
        $product_id = $request->product_id;
        $status = 'not_paid';
        $price = $request->price;
        $quantity = $request->quantity;

        $stock = Product::find($product_id)->stock;

        if($stock <= 0){
            return redirect()-> back()->with('status', 'Stock habis');
        }
        else{
            Transaction::create([
                'user_id' =>$user_id,
                'product_id' =>$product_id,
                'status' => $status,
                'price' =>$price,
                'quantity' =>$quantity,
            ]);
            return redirect()-> back()->with('status', 'Success Add to Cart');
        }

    }

    public function download($order_id){
        $transactions = Transaction::where('order_id', $order_id)->get();
        $total_biaya = 0;

        foreach($transactions as $transaction){
            $total_price = $transaction->price * $transaction->quantity;
            $total_biaya += $total_price;
        }
        return view('detail', compact('transactions', 'total_biaya'));
    }  
        
    public function destroy($id){
    // Find the transaction by ID
    $transaction = Transaction::find($id);

    // Check if the transaction exists
    if ($transaction) {
        // If it exists, delete the transaction
        $transaction->delete();

        // Redirect back with a success message
        return redirect()->back()->with('status', 'Order Deleted');
    } else {
        // If the transaction does not exist, redirect back with an error message
        return redirect()->back()->with('error', 'Order not found');
    }
}

}
