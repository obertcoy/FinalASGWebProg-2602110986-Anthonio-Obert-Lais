<?php

namespace App\Http\Controllers;

use App\Models\Hobby;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get gender and hobbies search parameters from the request (if any)
        $gender = $request->input('gender');
        $hobbiesSearch = $request->input('hobbies');

        if (Auth::check()) {
            $currentUser = Auth::user();
            $query = User::where('id', '!=', $currentUser->id);
        } else {
            $query = User::query();
        }

        if ($gender) {
            $query->where('gender', $gender);
        }

        if ($hobbiesSearch) {
            $query->whereHas('hobbies', function ($query) use ($hobbiesSearch) {
                $query->where('name', 'like', '%' . $hobbiesSearch . '%');
            });
        }

        $featuredUsers = $query->get();

        return view('pages.welcome', compact('featuredUsers'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages/register');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'required',
            'password_confirm' => 'required|same:password',
            'email' => 'required|email|unique:users,email',
            'gender' => 'required|in:Male,Female',
            'hobbies' => 'required|string',
            'instagram' => 'required|string',
            'mobile_number' => 'required|digits_between:10,15',
            'age' => 'required|integer|min:0',
        ]);

        $registrationPrice = rand(100000, 125000);

        $hobbies = collect(explode(",", $validated['hobbies']))->map(function ($hobby) {
            return trim($hobby);
        });

        if (!str_contains($validated['instagram'], 'www.instagram.com')) {
            return redirect()->back()->with('error', 'Instagram link not valid')->withInput();
        }

        if (count($hobbies) < 3) {
            return redirect()->back()->withErrors('Hobbies minimal of 3')->withInput();
        }

        session([
            'registration_data' => $validated,
            'registration_price' => $registrationPrice
        ]);

        return redirect()->route('user.payment');
    }


    public function showPayment()
    {
        $registrationData = session('registration_data');

        if (!$registrationData) {
            return redirect()->route('register')->withErrors('Registration data not found.');
        }

        $registrationPrice = session('registration_price');

        $overpaidAmount = -1;

        return view('pages/register-payment', compact('overpaidAmount', 'registrationPrice'));
    }

    public function processPayment(Request $request)
    {
        $validated = $request->validate([
            'payment' => 'required|numeric|min:0',
        ]);

        $registrationData = session('registration_data');

        if (!$registrationData) {
            return redirect()->route('register')->with('error', 'Registration data not found.');
        }

        $registrationPrice = session('registration_price');
        $payment = $validated['payment'];

        if ($payment < $registrationPrice) {
            $underpaidAmount = $registrationPrice - $payment;
            return redirect()->back()->with('error', "You are underpaid by $underpaidAmount")->withInput();
        }

        $overpaidAmount = $payment - $registrationPrice;
        if ($payment > $registrationPrice && !$request->input('overpaid')) {
            return view('pages/register-payment', compact('overpaidAmount', 'registrationPrice', 'payment'));
        }

        $user = User::create([
            'name' => $registrationData['name'],
            'password' => bcrypt($registrationData['password']),
            'email' => $registrationData['email'],
            'gender' => $registrationData['gender'],
            'instagram' => $registrationData['instagram'],
            'mobile_number' => $registrationData['mobile_number'],
            'age' => $registrationData['age'],
        ]);

        $hobbies = collect(explode(",", $registrationData['hobbies']))->map(function ($hobby) {
            return trim($hobby);
        });

        $user->hobbies()->attach(
            $hobbies->map(function ($hobby) {
                return Hobby::firstOrCreate(['name' => $hobby])->id;
            })
        );

        $user->increment('wallet', $overpaidAmount);

        session()->forget('registration_data');
        session()->forget('registration_price');

        Auth::login($user);

        return redirect()->route('index')->with('success', 'User registered successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
