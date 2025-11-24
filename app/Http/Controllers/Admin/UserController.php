<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index(Request $request)
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'Only administrators can manage users.');
        }
        $query = User::query()->with('roles');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Role filter
        if ($request->filled('role')) {
            $query->role($request->role);
        }

        // Status filter (email verification)
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->whereNotNull('email_verified_at');
            } elseif ($request->status === 'inactive') {
                $query->whereNull('email_verified_at');
            }
        }

        // Get paginated users
        $users = $query->latest()->paginate(15)->withQueryString();

        // Calculate statistics
        $stats = [
            'total' => User::count(),
            'active' => User::whereNotNull('email_verified_at')->count(),
            'new_this_month' => User::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
            'admins' => User::role('admin')->count(), //   This will now work
        ];

        // Get all roles for filter dropdown
        $roles = Role::all();

        return view('users.index', compact('users', 'stats', 'roles'));
    }

    /**
     * Display the Specific User.
     */
    public function show(User $user)
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'Only administrators can view user details.');
        }
        $user->load('roles', 'posts', 'reactions');

        return view('users.show', compact('user'));
    }

    /**
     * Delete a User.
     */
    public function destroy(User $user)
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'Only administrators can delete users.');
        }
        // Prevent deleting self
        if ($user->id === Auth::id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
