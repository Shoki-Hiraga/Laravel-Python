<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FormController extends Controller
{
    public function showForm()
    {
        return view('components.form');
    }

    public function submitForm(Request $request)
    {
        $validatedData = $request->validate([
            'maker' => 'required|string',
            'year' => 'required|string',
            'mileage' => 'required|string',
            'sell_target' => 'required|string',
            'sell_period' => 'required|string',
            'name' => 'required|string',
            'phone' => 'required|numeric',
            'age' => 'required|string',
            'applicant' => 'required|string',
            'prefecture' => 'required|string',
            'email' => 'required|email',
        ]);

        return back()->with('success', '送信されました！');
    }
}
