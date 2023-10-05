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
            $car = 'ایران' . $this->request->input('pluck1') . '-' . $this->request->input('pluck2') . $this->request->input('pluck3') . $this->request->input('pluck4');
            $name = $this->request->input('name');
            $balance = $this->request->input('balance');

            User::create([
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
        return view('user.edit', compact('chars', 'user'));
    }

    public function update(User $user)
    {
        try {
            $car = 'ایران' . $this->request->input('pluck1') . '-' . $this->request->input('pluck2') . $this->request->input('pluck3') . $this->request->input('pluck4');
            $name = $this->request->input('name');
            $balance = $this->request->input('balance');

            $user->update([
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
