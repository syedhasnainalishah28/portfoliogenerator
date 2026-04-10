<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\AdminCustomEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function index()
    {
        // Load all users with their license info
        $users = User::with('license.plan')->latest()->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function sendEmail(Request $request, User $user)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'body'    => 'required|string',
        ]);

        try {
            Mail::to($user->email)->send(new AdminCustomEmail($request->subject, $request->body, $user));
            return back()->with('success', 'Custom email sent successfully to ' . $user->email);
        } catch (\Exception $e) {
            return back()->with('error', 'Error sending email: ' . $e->getMessage());
        }
    }
}
