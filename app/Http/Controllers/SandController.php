<?php

namespace App\Http\Controllers;

use App\Models\Sand;
use App\Models\User;
use Illuminate\Http\Request;

class SandController extends Controller
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {
        $sands = Sand::orderBy('id', 'desc')->get();

        return view('sand.index', compact('sands'));
    }

    public function create()
    {
        return view('sand.create');
    }

    public function store()
    {
        try {
            $name = $this->request->input('name');
            $price = $this->request->input('price');
            $weight = $this->request->input('weight');

            Sand::create([
                'name'   => $name,
                'weight' => $weight,
                'price'  => $price,
            ]);
            $this->save_change(null, Sand::class, "create", [
                'name'   => $name,
                'weight' => $weight,
                'price'  => $price,
            ]);
            return redirect(route('sands'))->with('message', 'شن با موفقیت ثبت شد.');
        } catch (\Exception $e) {
            return redirect(route('sands'))->withErrors(['error' => 'مشکلی در ثبت شن وجود دارد.']);
        }
    }

    public function edit(Sand $sand)
    {
        return view('sand.edit', compact('sand'));
    }

    public function update(Sand $sand)
    {
        try {
            $name = $this->request->input('name');
            $price = $this->request->input('price');
            $weight = $this->request->input('weight');

            $sand->update([
                'name'   => $name,
                'weight' => $weight,
                'price'  => $price,
            ]);

            $this->save_change($sand->id, Sand::class, "update", [
                'name'   => $name,
                'weight' => $weight,
                'price'  => $price,
            ]);

            return redirect(route('sands'))->with('message', 'شن با موفقیت اپدیت شد.');
        } catch (\Exception $e) {
            return redirect(route('sands'))->withErrors(['error' => 'مشکلی در اپدیت شن وجود دارد.']);
        }
    }
}
