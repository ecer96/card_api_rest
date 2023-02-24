<?php

namespace App\Http\Controllers;

use App\Models\Accounts;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CardController extends Controller
{
    public function deposit(Request $request, $id)
    {
        $account = Accounts::find($id);

        if (!$account) {
            return response()->json(['Message' => 'Account not found'], 404);
        }

        $amount = $request->input('amount');


        if (!$amount) {
            return response()->json(['Message' => 'Invalid amount'], 400);
        }

        $account->balance += $amount;
        $account->deposits += $amount;
        $account->save();

        return response()->json(['Message' => 'Deposit successful']);
    }

    public function withdraw(Request $request, $id)
    {
        $account = Accounts::find($id);

        if (!$account) {
            return response()->json(['Message' => 'Account not found'], 404);
        }

        $amount = $request->input('amount');


        if (!$amount) {
            return response()->json(['Message' => 'Invalid amount'], 400);
        }

        $account->balance -= $amount;
        $account->withdrawals += $amount;
        $account->save();

        return response()->json(['Message' => 'Deposit successful']);
    }

    public function send(Request $request, $from_account_number, $to_account_number)
{
    $from_account = Accounts::where('account_number', $from_account_number)->first();
    $to_account = Accounts::where('account_number', $to_account_number)->first();

    if (!$from_account) {
        return response()->json(['Message' => 'Account not found'], 404);
    }

    if (!$to_account) {
        return response()->json(['Message' => 'Destination account not found'], 404);
    }

    $amount = $request->input('amount');

    if (!$amount) {
        return response()->json(['Message' => 'Invalid amount'], 400);
    }

    if ($from_account->balance < $amount) {
        return response()->json(['Message' => 'Insufficient balance'], 400);
    }

    DB::beginTransaction();

    try {
        $from_account->balance -= $amount;
        $from_account->withdrawals += $amount;
        $from_account->save();

        $to_account->balance += $amount;
        $to_account->deposits += $amount;
        $to_account->save();

        DB::commit();

        return response()->json(['Message' => 'Transfer successful']);
    } catch (Exception $e) {
        DB::rollback();
        return response()->json(['Message' => 'Transfer failed'], 500);
    }
}

    
    
    
}
