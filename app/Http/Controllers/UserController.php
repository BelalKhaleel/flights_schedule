<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = QueryBuilder::for(User::class)
            ->allowedFilters(['name', 'email', AllowedFilter::exact('id')])
            ->defaultSort('-updated_at')
            ->allowedSorts(['name', 'email', '-updated_at'])
            ->paginate($request->input('per_page', 100))
            ->appends($request->query());

        return response(['success' => true, 'users' => $users]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|min:6|max:255',
            'password' => 'required|string|min:8',
        ]);

        $data['password'] = bcrypt($request->input('password'));

        $user = User::create($data);

        $user->assignRole('user');

        $user->load('roles.permissions');
        
        return response([
            'success' => true,
            'message' => 'User created successfully',
            'user' => $user,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $is_admin = $user->hasRole('admin');

        $permissions = $user->getPermissionsViaRoles();

        return response([
             'success' => true, 
             'is_admin' => $is_admin,
             'user' => $user, 
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|min:6|max:255',
            'password' => 'required|string|min:8',
        ]);

        $data['password'] = bcrypt($request->input('password'));

        $user->update($data);

        return response([
            'success' => true,
            'message' => 'User updated successfully',
            'user' => $user,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json();
    }
}
