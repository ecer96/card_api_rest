<?php

namespace App\Http\Controllers;

use App\Models\Accounts;

use Illuminate\Http\Request;


class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return  Accounts::all();
    }


   

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $account = Accounts::find($id);

        if (!$account) {
            return response()->json(['Message' => 'Error Finding This Account, Please Try Again'], 404);
        }

        return response()->json(['Message' => $account], 200);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $account = Accounts::find($id);

        if (!$account) {
            return response()->json(['We couldnt match an account for this id, please try whit another one..'], 404);
        }

        $account->update($request->only($account->getFillable()));

        return response()->json(['Message' => 'User Updated Sucessfully' . $account]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $account = Accounts::find($id);
        if (!$account) {
            return response()->json(['Message' => 'This Account Doesnt Exist, Please Try Again'], 404);
        }
        $account->delete();
        return response()->json(['Message' => 'This account was deleted:' . $account], 200);
    }
}
