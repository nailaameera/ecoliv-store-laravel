<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\TransactionDetail;
use App\Models\User;

class DashboardController extends Controller
{
      /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $buyTransactions = TransactionDetail::with(['transaction.user', 'product.galleries'])
                        ->whereHas('transaction', function($transaction){
                            $transaction->where('users_id', Auth::user()->id);
                        })->get();
        return view('pages.dashboard',[
            'buyTransactions' => $buyTransactions
        ]);
    }

    public function details(Request $request, $id)
    {
        $transaction = TransactionDetail::with(['transaction.user', 'product.galleries'])
                        ->findOrFail($id);

        return view('pages.dashboard-transactions-details',[
            'transaction' => $transaction
        ]);
    }

    public function updatee(Request $request, $id)
    {
        $data = $request->all();

        $item = TransactionDetail::findOrFail($id);

        $item->update($data);

        return redirect()->route('dashboard-transaction-details', $id);
    }

    public function account()
    {
        $user = Auth::user();
        return view('pages.dashboard-account', [
            'user' => $user
        ]);
    }

    public function update(Request $request, $redirect)
    {
        $data = $request->all();
        $item = Auth::user();

        $item->update($data);

        return redirect()->route($redirect);
    }
}