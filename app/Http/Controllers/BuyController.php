<?php

namespace App\Http\Controllers;

use App\Models\Buy;
use App\Models\Mine;
use App\Models\Sand;
use App\Models\Sell;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;

class BuyController extends Controller
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {
        $buys = Buy::all();

        return view('buy.index', compact('buys'));
    }

    public function create()
    {
        $sands = Sand::all();
        $mines = Mine::all();

        return view('buy.create', compact('sands', 'mines'));
    }

    public function store()
    {
        try {
            $sand_id = $this->request->input('sand');
            $mine_id = $this->request->input('mine');

            $sand = Sand::find($sand_id);
            $mine = Mine::find($mine_id);

            $car = $this->request->input('car');
            $real_weight = $this->request->input('real_weight');
            $mine_weight = $this->request->input('mine_weight');
            $price = $this->request->input('price');
            $type = $this->request->input('type');

            $j_date = $this->request->input('date');
            $date = Jalalian::fromFormat('Y-m-d', $j_date)->toCarbon();

            $total = $price * $mine_weight / 1000;

            Buy::create([
                'sand_id'     => $sand_id,
                'mine_id'     => $mine_id,
                'car'         => $car,
                'real_weight' => $real_weight,
                'mine_weight' => $mine_weight,
                'price'       => $price,
                'type'        => $type,
                'total'       => $total,
                'date'        => $date,
            ]);

            $sand->update([
                "weight" => $sand->weight + $real_weight,
            ]);

            if ($type == "order") {
                $mine->update([
                    "balance" => $mine->balance - $total,
                ]);
            }
            return redirect(route('buys'))->with('message', 'خرید با موفقیت ثبت شد.');
        } catch (\Exception $e) {
            return redirect(route('buys'))->withErrors(['error' => 'مشکلی در ثبت خرید وجود دارد.']);
        }
    }

    public function edit(Buy $buy)
    {
        $sands = Sand::all();
        $mines = Mine::all();
        return view('buy.edit', compact('buy', 'sands', 'mines'));
    }

    public function update(Buy $buy)
    {
        try {
            $sand = $buy->sand;
            $mine = $buy->mine;
            $sand->update([
                "weight" => $sand->weight - $buy->real_weight,
            ]);

            if ($buy->type == "order") {
                $mine->update([
                    "balance" => $mine->balance + $buy->total,
                ]);
            }

            $sand_id = $this->request->input('sand');
            $mine_id = $this->request->input('mine');

            $sand = Sand::find($sand_id);
            $mine = Mine::find($mine_id);

            $car = $this->request->input('car');
            $real_weight = $this->request->input('real_weight');
            $mine_weight = $this->request->input('mine_weight');
            $price = $this->request->input('price');
            $type = $this->request->input('type');

            $j_date = $this->request->input('date');
            $date = Jalalian::fromFormat('Y-m-d', $j_date)->toCarbon();

            $total = $price * $mine_weight / 1000;

            $buy->update([
                'sand_id'     => $sand_id,
                'mine_id'     => $mine_id,
                'car'         => $car,
                'real_weight' => $real_weight,
                'mine_weight' => $mine_weight,
                'price'       => $price,
                'type'        => $type,
                'total'       => $total,
                'date'        => $date,
            ]);

            $sand->update([
                "weight" => $sand->weight + $real_weight,
            ]);

            if ($type == "order") {
                $mine->update([
                    "balance" => $mine->balance - $total,
                ]);
            }
            return redirect(route('buys'))->with('message', 'خرید با موفقیت اپدیت شد.');
        } catch (\Exception $e) {
            return redirect(route('buys'))->withErrors(['error' => 'مشکلی در اپدیت خرید وجود دارد.']);
        }
    }

    public function delete(Buy $buy)
    {
        try {
            $sand = $buy->sand;
            $mine = $buy->mine;
            $sand->update([
                "weight" => $sand->weight - $buy->real_weight,
            ]);

            if ($buy->type == "order") {
                $mine->update([
                    "balance" => $mine->balance + $buy->total,
                ]);
            }
            $buy->delete();
            return redirect(route('buys'))->with('message', 'خرید با موفقیت حذف شد.');
        } catch (\Exception $e) {
            return redirect(route('buys'))->withErrors(['error' => 'مشکلی در حذف خرید وجود دارد.']);
        }
    }
}
