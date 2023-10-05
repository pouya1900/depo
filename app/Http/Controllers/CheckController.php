<?php

namespace App\Http\Controllers;

use App\Models\Check;
use Illuminate\Http\Request;

class CheckController extends Controller
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {
        $checks = Check::all();

        return view('check.index', compact('checks'));
    }

    public function create()
    {
        return view('mine.create');
    }

    public function store()
    {
        try {
            $name = $this->request->input('name');
            $balance = $this->request->input('balance');

            Mine::create([
                'name'    => $name,
                'balance' => $balance,
            ]);

            return redirect(route('mines'))->with('message', 'معدن با موفقیت ثبت شد.');
        } catch (\Exception $e) {
            return redirect(route('mines'))->withErrors(['error' => 'مشکلی در ثبت معدن وجود دارد.']);
        }
    }

    public function edit(Check $check)
    {
        return view('mine.edit', compact('mine'));
    }

    public function update(Check $check)
    {
        try {
            $name = $this->request->input('name');
            $balance = $this->request->input('balance');

            $mine->update([
                'name'    => $name,
                'balance' => $balance,
            ]);

            return redirect(route('mines'))->with('message', 'معدن با موفقیت اپدیت شد.');
        } catch (\Exception $e) {
            return redirect(route('mines'))->withErrors(['error' => 'مشکلی در اپدیت معدن وجود دارد.']);
        }
    }
}
