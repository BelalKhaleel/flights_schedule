<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class FlightController extends Controller
{
    /**
     * Display a listing of the flights.
     */
    public function index(Request $request)
    {

        $flights = QueryBuilder::for(Flight::class)
            ->with(['passengers'])
            ->allowedFilters(['departure_city', 'arrival_city', 'departure_time', 'arrival_time', AllowedFilter::exact('id'), AllowedFilter::exact('flight_number')])
            ->defaultSort('-updated_at')
            ->allowedSorts(['flight_number', 'departure_city', 'arrival_city', 'departure_time', 'arrival_time', '-updated_at'])
            ->paginate($request->input('per_page', 100))
            ->appends($request->query());

        return response(['success' => true, 'flights' => $flights]);
    }

    /**
     * Show the form for creating a new flight.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created flight in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified flight.
     */
    public function show(string $flight_number)
    {
        $flight = Flight::where('flight_number', $flight_number)->first();

        if(!$flight) {
            return response(['success' => false, 'message' => 'flight not found!', 404]);
        }

        $flight->load('passengers');
        return response(['success' => true, 'flight' => $flight]);
    }

    /**
     * Show the form for editing the specified flight.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified flight in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified flight from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
