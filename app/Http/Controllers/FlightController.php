<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
            ->with('passengers')
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
        $data = $request->validate([
            'flight_number' => 'required|numeric|max_digits:4',
            'departure_city' => 'required|string|min:1|max:85',
            'arrival_city' => 'required|string|min:1|max:85',
            'departure_time' => 'required|date_format:Y-m-d H:i:s',
            'arrival_time' => 'required|date_format:Y-m-d H:i:s',
        ]);

        $flight = Flight::create($data);

        return response([
            'success' => true,
            'flight' => $flight,
        ]);
    }

    /**
     * Display the specified flight.
     */
    public function show(string $flight_number)
    {
        $flight = Flight::where('flight_number', $flight_number)->first();

        if (!$flight) {
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
        $flight = Flight::find($id);

        $data = $request->validate([
            'flight_number' => 'required|numeric|max_digits:4',
            'departure_city' => 'required|string|min:1|max:85',
            'arrival_city' => 'required|string|min:1|max:85',
            'departure_time' => 'required|date_format:Y-m-d H:i:s',
            'arrival_time' => 'required|date_format:Y-m-d H:i:s',
        ]);

        $flight->update($data);

        return response([
            'success' => true,
            'flight' => $flight,
        ]);
    }

    /**
     * Remove the specified flight from storage.
     */
    public function destroy(string $id)
    {
        $flight = Flight::find($id);
        $flight->delete();
        return response(['flight' => $flight], Response::HTTP_NO_CONTENT);
    }
}
