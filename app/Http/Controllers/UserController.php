<?php

namespace App\Http\Controllers;

use App\Models\Hobby;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $registrationPrice = rand(100000, 125000);

        return view('pages/register', compact('registrationPrice'));
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
            'email' => 'required|email',
            'gender' => 'required|in:Male,Female',
            'hobbies' => 'required|string',
            'instagram' => 'required|string',
            'mobile_number' => 'required|digits_between:10,15',
            'age' => 'required|integer|min:0',
        ]);

        $hobbies = collect(explode(",", $validated['hobbies']))->map(function ($hobby) {
            return trim($hobby);
        });

        if(!str_contains($validated['instagram'], 'www.instagram.com')){
            return redirect()->back()->with('error', 'Instagram link not valid')->withInput();
        }

        if(count($hobbies) < 3){
            return redirect()->back()->withErrors('Hobbies minimal of 3')->withInput();
        }

        $user = User::create([
            'name' => $validated['name'],
            'password' => $validated['password'],
            'email' => $validated['email'],
            'gender' => $validated['gender'],
            'instagram' => $validated['instagram'],
            'mobile_number' => $validated['mobile_number'],
            'age' => $validated['age']
        ]);

        $user->hobbies()->attach(
            $hobbies->map(function ($hobby) {
                return Hobby::firstOrCreate(['name' => $hobby])->id;
            })
        );

        return redirect()->route('index')->with('success', 'User registered successfully');
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
