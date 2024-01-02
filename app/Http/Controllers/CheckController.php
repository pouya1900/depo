<?php

namespace App\Http\Controllers;

use App\Models\Check;
use App\Models\User;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;

class CheckController extends Controller
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {
        $checks = Check::orderBy('date', 'asc')->get();

        return view('check.index', compact('checks'));
    }

    public function create()
    {
        $users = User::all();
        return view('check.create', compact('users'));
    }

    public function store()
    {
        try {
            $user_id = $this->request->input('car');
            $user = User::find($user_id);
            $amount = $this->request->input('amount');
            $number = $this->request->input('number');
            $bank = $this->request->input('bank');

            $j_date = $this->request->input('date');
            $date = Jalalian::fromFormat('Y-m-d', $j_date)->toCarbon();

            Check::create([
                'user_id' => $user_id,
                'amount'  => $amount,
                'date'    => $date,
                'number'  => $number,
                'bank'    => $bank,
            ]);

            $this->save_change(null, Check::class, "create", [
                'user_id' => $user_id,
                'amount'  => $amount,
                "date"    => date("Y-m-d H:i:s", strtotime($date)),
                'number'  => $number,
                'bank'    => $bank,
            ]);


            $user->update([
                "balance" => $user->balance + $amount,
            ]);

            $this->save_change($user->id, User::class, "update", [
                "balance" => $user->balance,
            ]);

            return redirect(route('checks'))->with('message', 'چک با موفقیت ثبت شد.');
        } catch (\Exception $e) {
            return redirect(route('checks'))->withErrors(['error' => 'مشکلی در ثبت چک وجود دارد.']);
        }
    }

    public function edit(Check $check)
    {
        $users = User::all();

        return view('check.edit', compact('check', 'users'));
    }

    public function update(Check $check)
    {
        try {

            $check->user->update([
                "balance" => $check->user->balance - $check->amount,
            ]);

            $this->save_change($check->user->id, User::class, "update", [
                "balance" => $check->user->balance,
            ]);

            $user_id = $this->request->input('car');
            $user = User::find($user_id);
            $amount = $this->request->input('amount');
            $number = $this->request->input('number');
            $bank = $this->request->input('bank');

            $j_date = $this->request->input('date');
            $date = Jalalian::fromFormat('Y-m-d', $j_date)->toCarbon();


            $check->update([
                'user_id' => $user_id,
                'amount'  => $amount,
                'date'    => $date,
                'number'  => $number,
                'bank'    => $bank,
            ]);

            $this->save_change($check->id, Check::class, "update", [
                'user_id' => $user_id,
                'amount'  => $amount,
                "date"    => date("Y-m-d H:i:s", strtotime($date)),
                'number'  => $number,
                'bank'    => $bank,
            ]);

            $user->update([
                "balance" => $user->balance + $amount,
            ]);

            $this->save_change($user->id, User::class, "update", [
                "balance" => $user->balance,
            ]);


            return redirect(route('checks'))->with('message', 'چک با موفقیت اپدیت شد.');
        } catch (\Exception $e) {
            return redirect(route('checks'))->withErrors(['error' => 'مشکلی در اپدیت چک وجود دارد.']);
        }
    }

    public function delete(Check $check)
    {
        try {
            $check->user->update([
                "balance" => $check->user->balance - $check->amount,
            ]);

            $this->save_change($check->user->id, User::class, "update", [
                "balance" => $check->user->balance,
            ]);

            $check->delete();

            $this->save_change($check->id, Check::class, "delete", null);

            return redirect(route('checks'))->with('message', 'چک با موفقیت حذف شد.');
        } catch (\Exception $e) {
            return redirect(route('checks'))->withErrors(['error' => 'مشکلی در حذف چک وجود دارد.']);
        }
    }
}
