<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    // Show contact page
    public function index()
    {
        return view('contact');
    }

    // Save contact message
    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required',
            'email'   => 'required|email',
            'message' => 'required'
        ]);

        Contact::create([
            'name'    => $request->name,
            'email'   => $request->email,
            'message' => $request->message
        ]);

        return back()->with('success', 'Your message has been sent successfully!');
    }
}