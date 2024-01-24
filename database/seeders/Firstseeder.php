<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Product;
use App\Models\Role;
use App\Models\Transaction;
use App\Models\Category;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class Firstseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            "name" => "Dodo",
            "username" => "dodo",
            "password" => Hash::make("dodox"),
            "role" => "siswa",
        ]);
        
        User::create([
            "name" => "Admin",
            "username" => "admin",
            "password" => Hash::make("admin"),
            "role" => "admin",
         ]);

          User::create([
            "name" => "Kantin",
            "username" => "kantin",
            "password" => Hash::make("kantin"),
            "role" => "kantin",
         ]);

          User::create([
            "name" => "Bank",
            "username" => "bank",
            "password" => Hash::make("bank"),
            "role" => "bank",
         ]);

         Category::create([
            "name" => "Makanan",
        ]);
        Category::create([
            "name" => "Minuman",
        ]);
        Category::create([
            "name" => "Snack",
        ]);

        Product::create([
            "name" => "Nasi Goreng",
            "price" => 20000,
            "stock" => 14,
            "photo" => "img/nasgor.jpg",
            "description" => "Nasi Goreng Spesial",
            "category_id"=>1,
            "stand"=>1
        ]);

        Product::create([
            "name" => "Ice Matcha",
            "price" => 10000,
            "stock" => 30,
            "photo" => "img/matcha.jpg",
            "description" => "Es Matcha Latte",
            "category_id"=>2,
            "stand"=>2
        ]);

        Product::create([
            "name" => "Dimsum",
            "price" => 6000,
            "stock" => 26,
            "photo" => "img/dimsam.jpg",
            "description" => "Dimsum Aneka Rasa",
            "category_id"=> 3,
            "stand"=> 1
        ]);

        Wallet::create([
            'user_id'=>4,
            'credit'=>100000,
            'debit'=>null,
            'description'=>'Pembukaan Tabungan'
        ]);

        Wallet::create([
            'user_id'=>4,
            'credit'=>15000,
            'debit'=>null,
            'description'=>'Pembelian'
        ]);

        Wallet::create([
            'user_id'=>4,
            'credit'=>20000,
            'debit'=>null,
            'description'=>'Pembelian'
        ]);

        Transaction::create([
            'user_id'=>4,
            'product_id'=>1,
            'status'=>'taken',
            'order_id'=>"INV_12345",
            'price'=>10000,
            'quantity'=>1
        ]);

        Transaction::create([
            'user_id'=>4,
            'product_id'=>2,
            'status'=>'taken',
            'order_id'=>"INV_12345",
            'price'=>20000,
            'quantity'=>1
        ]);

        Transaction::create([
            'user_id'=>4,
            'product_id'=>3,
            'status'=>'taken',
            'order_id'=>"INV_12345",
            'price'=>15000,
            'quantity'=>2
        ]);

        $total_debit=0;

        $transactions=Transaction::where('order_id' == 'INV_12345');

        foreach($transactions as $transaction){
            $total_price=$transaction->price * $transaction->quantity;
            $total_debit += $total_price;
        };

        Wallet::create([
            'user_id'=>4,
            'credit'=>$total_debit,
            'description'=>'Pembelian produk'
        ]);

        foreach($transactions as $transaction){
            Transaction::find($transaction->id)->update([
                'status'=>'pay'
            ]);
        };

        foreach($transactions as $transaction){
            Transaction::find($transaction->id)->update([
                'status'=>'not_paid'
            ]);
        };

        foreach($transactions as $transaction){
            Transaction::find($transaction->id)->update([
                'status'=>'taken'
            ]);
        };
    }
}
