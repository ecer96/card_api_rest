<?php

namespace App\Http\Controllers;

use App\Models\Accounts;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;
use Faker\Factory as FakerFactory;


class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Users::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $faker = FakerFactory::create();

        try {
            $validate = $request->validate([
                'name' => 'required|max:255',
                'birthday' => 'required|date:d/m/Y',
                'phone' => 'required|unique:users',
                'email' => 'required|unique:users',
                'password' => 'required|min:8',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['success' => false, 'errors' => $e->errors()], 400);
        }

        $user = new Users;
        $user->name = $validate['name'];
        $user->birthday = $validate['birthday'];
        $user->phone = $validate['phone'];
        $user->email = $validate['email'];
        $user->password = Hash::make($validate['password']);

        $user->save();

        $account = new Accounts;
        $account->account_number = $faker->creditCardNumber();
        $account->balance = 0;
        $account->availability = true;
        $account->expiration_date = Carbon::now()->addYears(10);
        $account->deposits = 0;
        $account->withdrawals = 0;
        $user->accounts()->save($account);


        return response()->json(['success' => true, 'account_number' => $account->account_number], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Users::find($id);

        if (!$user) {
            return response()->json(['Message' => 'This User Not Exist in our Records , please Try Again Whit Another id...'], 404);
        }

        return response()->json(['id' => $user->id, 'user' => $user], 200);
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
        $user = Users::find($id);

        if (!$user) {
            return response()->json(['We couldnt match a user for this id, please try whit another one..'], 404);
        }

        if ($request->has('password')) {
            $request['password'] = Hash::make($request->password);
        }

        $user->update($request->only($user->getFillable()));

        return response()->json(['Message' => 'User Updated Sucessfully' . $user]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Users::find($id);
        if (!$user) {
            return response()->json(['Message' => 'This User Does not exist'], 404);
        }

        $user->destroy($id);

        return response()->json(['Message' => 'The User' . $user . 'Was Deleted'], 200);
    }
}
