<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Transaction;
use App\Models\TransactionDetail;

class DashboardController extends Controller
{
    public function index ()
    {
        $sellTransactions = TransactionDetail::with(['transaction.user', 'product.galleries'])
                        ->whereHas('product',  function($product){
                            $product->where('users_id', Auth::user()->id);
                        })->get();
                        
        $customer = User::count();
        $revenue = Transaction::sum('total_price');
        $transaction = Transaction::count();

        return view('pages.admin.dashboard', [
            'customer' => $customer,
            'revenue' => $revenue,
            'transaction' => $transaction,
            'sellTransactions' => $sellTransactions
        ]);
    }

    public function details(Request $request, $id)
    {
        $transaction = TransactionDetail::with(['transaction.user', 'product.galleries'])
                        ->findOrFail($id);

        
        return view('pages.admin.dashboard-transactions-details',[
            'transaction' => $transaction
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        $item = TransactionDetail::findOrFail($id);

        $item->update($data);

        return redirect()->route('admin-dashboard-transactions-details', $id);
    }
}
