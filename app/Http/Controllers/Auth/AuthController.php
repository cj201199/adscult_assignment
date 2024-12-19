<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\User;
use Hash;
use Log;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function registration()
    {
        return view('auth.registration');
    }


    public function postLogin(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        try {
            $user = User::where('email', $request->email)->first();

            if ($user) {
                if (Hash::check($validatedData['password'], $user->password)) {

                    auth()->login($user);

                    return response()->json([
                        'status' => 200,
                        'message' => 'You have Logged in Successfully!',
                        'redirect_url' => url('dashboard'),
                    ]);
                } else {
                    return response()->json(['status' => 401, 'message' => 'Invalid credentials.']);
                }
            } else {
                return response()->json(['status' => 401, 'message' => 'Please enter correct credentials.']);
            }
        } catch (\Exception $e) {
            Log::error('postLogin function failed: ' . $e->getMessage());
            return response()->json(['status' => 500, 'message' => 'An error occurred during login. Please try again later.',]);
        }

    }

    public function postRegistration(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        try {
            $data = new User();
            $data->name = $request->name;
            $data->email = $request->email;
            $data->password = Hash::make($request->password);
            $data->save();

            return response()->json(['status' => 200, 'message' => 'You have registered successfully!']);
        } catch (\Exception $e) {
            Log::error('postRegistration function failed: ' . $e->getMessage());
            return response()->json(['status' => 500, 'message' => 'Registration failed. Please try again later.'], 500);
        }
    }

    public function dashboard()
    {
        if (Auth::check()) {
            $books = Book::with('reviews.user')->where('is_active',1)->get();
            return view('auth.dashboard',compact('books'));
        }

        return redirect("login")->withSuccess('Opps! You do not have access');
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();

        return Redirect('login');
    }
}
