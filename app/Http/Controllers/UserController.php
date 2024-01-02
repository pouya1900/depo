<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {
        $users = User::orderBy('id', 'desc')->get();

        return view('user.index', compact('users'));
    }

    public function create()
    {
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
        return view('user.create', compact('chars'));
    }

    public function store()
    {
        try {
            $car = $this->request->input('pluck2') . "-" . $this->request->input('pluck4');
            $name = $this->request->input('name');
            $balance = $this->request->input('balance');

            User::create([
                'car'     => $car,
                'name'    => $name,
                'balance' => $balance,
            ]);

            $this->save_change(null, User::class, "create", [
                'car'     => $car,
                'name'    => $name,
                'balance' => $balance,
            ]);


            return redirect(route('users'))->with('message', 'کاربر با موفقیت ثبت شد.');
        } catch (\Exception $e) {
            return redirect(route('users'))->withErrors(['error' => 'مشکلی در ثبت کاربر وجود دارد.']);
        }
    }

    public function edit(User $user)
    {
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

        $car = $user->car;

        $pluck = [];

        $pluck[1] = substr($car, 10, 2);
        $pluck[2] = substr($car, 13, 2);
        $pluck[3] = substr($car, 15, 2);
        $pluck[4] = substr($car, 17, 3);

        return view('user.edit', compact('chars', 'user', 'pluck'));
    }

    public function update(User $user)
    {
        try {
            $car = $this->request->input('pluck2') . "-" . $this->request->input('pluck4');
            $name = $this->request->input('name');
            $balance = $this->request->input('balance');

            $user->update([
                'car'     => $car,
                'name'    => $name,
                'balance' => $balance,
            ]);

            $this->save_change($user->id, User::class, "update", [
                'car'     => $car,
                'name'    => $name,
                'balance' => $balance,
            ]);


            return redirect(route('users'))->with('message', 'کاربر با موفقیت ثبت شد.');
        } catch (\Exception $e) {
            return redirect(route('users'))->withErrors(['error' => 'مشکلی در ثبت کاربر وجود دارد.']);
        }
    }


}
