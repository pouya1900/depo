<?php

namespace App\Http\Controllers;

use App\Models\Mine;
use Illuminate\Http\Request;

class MineController extends Controller
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {
        $mines = Mine::orderBy('id', 'desc')->get();

        return view('mine.index', compact('mines'));
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

    public function edit(Mine $mine)
    {
        return view('mine.edit', compact('mine'));
    }

    public function update(Mine $mine)
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
