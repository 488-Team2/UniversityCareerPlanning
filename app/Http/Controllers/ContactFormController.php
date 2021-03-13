<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactFormController extends Controller
{
    public function submit(Request $request) {
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email',
            'message' => 'required',
        ]);
        $contact = Contact::create(['name' => $request->input(['name']), 
            'email' => $request->input(['email']), 
            'message' => $request->input(['message'])]);

        return response()->json(null, 200);
    }

    public function index() {
        $contact = Contact::latest()->orderBy('created_at', 'desc')->get();

        return response()->json($contact);
    }
}
