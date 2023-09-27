<?php

namespace App\Http\Controllers;

use App\Models\Passenger;
use Illuminate\Http\Request;
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
            ->allowedFilters(['first_name', 'last_name', 'email', 'date_of_birth', AllowedFilter::exact('id'), AllowedFilter::exact('flight_id')])
            ->defaultSort('-updated_at')
            ->allowedSorts(['first_name', 'last_name', 'email', 'date_of_birth', 'flight_id', '-updated_at'])
            ->paginate($request->input('per_page', 100))
            ->appends($request->query());

        return response(['success' => true, 'passengers' => $passengers]);
    }

    /**
     * Show the form for creating a new passenger.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created passenger in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified passenger.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified passenger.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified passenger in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified passenger from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
