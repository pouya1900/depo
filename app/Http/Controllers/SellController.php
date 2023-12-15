<?php

namespace App\Http\Controllers;

use App\Models\Sand;
use App\Models\Sell;
use App\Models\User;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;

class SellController extends Controller
{

    public function __construct(Request $request)
    {
        $this->request = $request;
    }


    public function index()
    {
        $date = $this->request->input('date');
        $user_id = $this->request->input('user');
        $sand_id = $this->request->input('sand');

        $filter = [
            'date' => $date,
            'user' => $user_id ? User::find($user_id) : null,
            'sand' => $sand_id ? Sand::find($sand_id) : null,
        ];

        $sells = Sell::when($date, function ($q) use ($date) {
            return $q->where('date', '>=', date('Y-m-d 00:00:00', $date))->where('date', '<', date('Y-m-d 00:00:00', $date + 86400));
        })->when($user_id, function ($q) use ($user_id) {
            return $q->where('user_id', $user_id);
        })->when($sand_id, function ($q) use ($sand_id) {
            return $q->where('sand_id', $sand_id);
        })->orderBy('id', 'desc')->get();
        return view('sell.index', compact('sells', 'filter'));
    }

    public function create()
    {
        $sands = Sand::all();
        $users = User::all();
        $chars = [
            'ا',
            'ب',
            'پ',
            'ت',
            'ث',
            'ج',
            'چ',
            'ح',
            'خ',
            'د',
            'ذ',
            'ر',
            'ز',
            'ژ',
            'س',
            'ش',
            'ص',
            'ض',
            'ط',
            'ظ',
            'ع',
            'غ',
            'ف',
            'ق',
            'ک',
            'گ',
            'ل',
            'م',
            'ن',
            'و',
            'ه',
            'ی'];

        return view('sell.create', compact('sands', 'users', 'chars'));
    }

    public function store()
    {
        try {

            if ($user_id = $this->request->input('car')) {
                $user = User::find($user_id);
            } else {
                $car = 'ایران' . $this->request->input('pluck1') . '-' . $this->request->input('pluck2') . $this->request->input('pluck3') . $this->request->input('pluck4');

                if (!$user = User::where('car', $car)->first()) {
                    $user = User::create([
                        'car'     => $car,
                        'name'    => $this->request->input('driver_name'),
                        'balance' => 0,
                    ]);
                }
            }

            $sand_id = $this->request->input('sand');
            $weight = $this->request->input('weight');
            $price = $this->request->input('price');
            $paid = $this->request->input('paid');

            $j_date = $this->request->input('date');
            $date = Jalalian::fromFormat('Y-m-d', $j_date)->toCarbon();


            $sand = Sand::find($sand_id);

            $total = $weight * $price / 1000;

            $remaining = $total - $paid;

            if ($remaining == 0) {
                $total_paid = $total;
                $use_balance = 0;
            } else {
                if ($user->balance > $remaining) {
                    $total_paid = $total;
                    $use_balance = $remaining;
                } else {
                    $total_paid = $user->balance > 0 ? $user->balance + $paid : $paid;
                    $use_balance = max($user->balance, 0);
                }

                $user->update([
                    'balance' => $user->balance - $remaining,
                ]);

            }

            $sand->update([
                'weight' => $sand->weight - $weight,
            ]);

            Sell::create([
                "sand_id" => $sand_id,
                "user_id" => $user->id,
                "weight"  => $weight,
                "price"   => $price,
                "total"   => $total,
                "paid"    => $total_paid,
                "cash"    => $paid,
                "balance" => $use_balance,
                "date"    => $date,
            ]);


            return redirect(route('sells'))->with('message', 'فاکتور با موفقیت ثبت شد.');
        } catch (\Exception $e) {
            return redirect(route('sells'))->withErrors(['error' => 'مشکلی در ثبت فاکتور وجود دارد.']);
        }
    }

    public function edit(Sell $sell)
    {
        $sands = Sand::all();
        $users = User::all();
        $chars = [
            'ا',
            'ب',
            'پ',
            'ت',
            'ث',
            'ج',
            'چ',
            'ح',
            'خ',
            'د',
            'ذ',
            'ر',
            'ز',
            'ژ',
            'س',
            'ش',
            'ص',
            'ض',
            'ط',
            'ظ',
            'ع',
            'غ',
            'ف',
            'ق',
            'ک',
            'گ',
            'ل',
            'م',
            'ن',
            'و',
            'ه',
            'ی'];
        return view('sell.edit', compact('sell', 'sands', 'users', 'chars'));
    }

    public function update(Sell $sell)
    {
        try {

            $sand = $sell->sand;
            $user = $sell->user;

            $sand->update([
                'weight' => $sand->weight + $sell->weight,
            ]);

            $user->update([
                'balance' => $user->balance + $sell->balance + ($sell->total - $sell->paid),
            ]);

            if ($user_id = $this->request->input('car')) {
                $user = User::find($user_id);
            } else {
                $car = 'ایران' . $this->request->input('pluck1') . '-' . $this->request->input('pluck2') . $this->request->input('pluck3') . $this->request->input('pluck4');

                if (!$user = User::where('car', $car)->first()) {
                    $user = User::create([
                        'car'     => $car,
                        'name'    => $this->request->input('driver_name'),
                        'balance' => 0,
                    ]);
                }
            }

            $sand_id = $this->request->input('sand');
            $weight = $this->request->input('weight');
            $price = $this->request->input('price');
            $paid = $this->request->input('paid');

            $j_date = $this->request->input('date');
            $date = Jalalian::fromFormat('Y-m-d', $j_date)->toCarbon();

            $sand = Sand::find($sand_id);

            $total = $weight * $price / 1000;

            $remaining = $total - $paid;

            if ($remaining == 0) {
                $total_paid = $total;
                $use_balance = 0;
            } else {
                if ($user->balance > $remaining) {
                    $total_paid = $total;
                    $use_balance = $remaining;
                } else {
                    $total_paid = $user->balance > 0 ? $user->balance + $paid : $paid;
                    $use_balance = max($user->balance, 0);
                }

                $user->update([
                    'balance' => $user->balance - $remaining,
                ]);

            }

            $sand->update([
                'weight' => $sand->weight - $weight,
            ]);

            $sell->update([
                "sand_id" => $sand_id,
                "user_id" => $user->id,
                "weight"  => $weight,
                "price"   => $price,
                "total"   => $total,
                "paid"    => $total_paid,
                "cash"    => $paid,
                "balance" => $use_balance,
                "date"    => $date,
            ]);


            return redirect(route('sells'))->with('message', 'فاکتور با موفقیت اپدیت شد.');
        } catch (\Exception $e) {
            return redirect(route('sells'))->withErrors(['error' => 'مشکلی در اپدیت فاکتور وجود دارد.']);
        }
    }

    public function delete(Sell $sell)
    {
        try {
            $sand = $sell->sand;
            $user = $sell->user;

            $sand->update([
                'weight' => $sand->weight + $sell->weight,
            ]);

            $user->update([
                'balance' => $user->balance + $sell->balance,
            ]);

            $sell->delete();
            return redirect(route('sells'))->with('message', 'فاکتور با موفقیت حذف شد.');
        } catch (\Exception $e) {
            return redirect(route('sells'))->withErrors(['error' => 'مشکلی در حذف فاکتور وجود دارد.']);
        }
    }

    public function complete_sell(Sell $sell)
    {
        try {
            $remaining = $sell->total - $sell->paid;

            $sell->update([
                "paid" => $sell->total,
                "cash" => $sell->cash + $remaining,
            ]);

            $sell->user->update([
                "balance" => $sell->user->balance + $remaining,
            ]);
            return redirect(route('sells'))->with('message', 'فاکتور با موفقیت پرداخت شد.');
        } catch (\Exception $e) {
            return redirect(route('sells'))->withErrors(['error' => 'مشکلی در پرداخت فاکتور وجود دارد.']);
        }
    }

}
