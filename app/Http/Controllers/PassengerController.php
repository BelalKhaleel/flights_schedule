<?php

namespace App\Http\Controllers;

use App\Models\Passenger;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class PassengerController extends Controller
{
    /**
     * Display a listing of the passengers.
     */
    public function index(Request $request)
    {

        $passengers = QueryBuilder::for(Passenger::class)
            ->with('flights')
            ->allowedFilters(['first_name', 'last_name', 'email', 'date_of_birth', AllowedFilter::exact('id')])
            ->defaultSort('-updated_at')
            ->allowedSorts(['first_name', 'last_name', 'email', 'date_of_birth', '-updated_at'])
            ->paginate($request->input('per_page', 100))
            ->appends($request->query());

        return response(['success' => true, 'passengers' => $passengers]);
    }

    /**
     * Store a newly created passenger in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:passengers,email|max:255',
            'password' => 'required|string|min:8',
            'date_of_birth' => 'required|date',
            'passport_expiry_date' => 'required|date',
        ]);

        $data['password'] = bcrypt($data['password']);

        $flights = json_decode($request->input('flights'));

        $passenger = Passenger::create($data);

        $passenger->flights()->sync($flights);

        return response([
            'success' => true, 
            'passenger' => $passenger,
            'flights' => $flights,
        ]);
    }

    /**
     * Display the specified passenger.
     */
    public function show(string $id)
    {
        $passenger = Passenger::find($id);   
        return response(['success' => true, 'passenger' => $passenger]);
    }

    /**
     * Update the specified passenger in storage.
     */
    public function update(Request $request, string $id)
    {
        $passenger = Passenger::find($id);

        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:passengers,email|max:255',
            'password' => 'required|string|min:8',
            'date_of_birth' => 'required|date',
            'passport_expiry_date' => 'required|date',
        ]);

        if (request()->has('password'))
        $data['password'] = bcrypt($data['password']);

        $passenger->update($data);

        $flights = json_decode($request->input('flights'));
        
        $passenger->flights()->sync($flights);
        
        return response([
            'success' => true, 
            'passenger' => $passenger,
            'flights' => $flights,
        ]);
    }

    /**
     * Remove the specified passenger from storage.
     */
    public function destroy(string $id)
    {
        $passenger = Passenger::find($id);
        $passenger->delete();
        return response()->json();
    }
}
