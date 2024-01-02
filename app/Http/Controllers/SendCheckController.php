<?php

namespace App\Http\Controllers;

use App\Models\SendCheck;
use App\Models\User;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;

class SendCheckController extends Controller
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {
        $checks = SendCheck::orderBy('date', 'asc')->get();

        return view('sendCheck.index', compact('checks'));
    }

    public function create()
    {
        return view('sendCheck.create');
    }

    public function store()
    {
        try {
            $user_name = $this->request->input('user_name');
            $own_name = $this->request->input('own_name');
            $amount = $this->request->input('amount');
            $number = $this->request->input('number');
            $bank = $this->request->input('bank');

            $j_date = $this->request->input('date');
            $date = Jalalian::fromFormat('Y-m-d', $j_date)->toCarbon();

            SendCheck::create([
                'user_name' => $user_name,
                'own_name'  => $own_name,
                'amount'    => $amount,
                'date'      => $date,
                'number'    => $number,
                'bank'      => $bank,
            ]);

            $this->save_change(null, SendCheck::class, "create", [
                'user_name' => $user_name,
                'own_name'  => $own_name,
                'amount'    => $amount,
                "date"      => date("Y-m-d H:i:s", strtotime($date)),
                'number'    => $number,
                'bank'      => $bank,
            ]);

            return redirect(route('send_checks'))->with('message', 'چک با موفقیت ثبت شد.');
        } catch (\Exception $e) {
            return redirect(route('send_checks'))->withErrors(['error' => 'مشکلی در ثبت چک وجود دارد.']);
        }
    }

    public function edit(SendCheck $check)
    {
        return view('sendCheck.edit', compact('check'));
    }

    public function update(SendCheck $check)
    {
        try {
            $user_name = $this->request->input('user_name');
            $own_name = $this->request->input('own_name');
            $amount = $this->request->input('amount');
            $number = $this->request->input('number');
            $bank = $this->request->input('bank');

            $j_date = $this->request->input('date');
            $date = Jalalian::fromFormat('Y-m-d', $j_date)->toCarbon();

            $check->update([
                'user_name' => $user_name,
                'own_name'  => $own_name,
                'amount'    => $amount,
                'date'      => $date,
                'number'    => $number,
                'bank'      => $bank,
            ]);

            $this->save_change($check->id, SendCheck::class, "update", [
                'user_name' => $user_name,
                'own_name'  => $own_name,
                'amount'    => $amount,
                "date"      => date("Y-m-d H:i:s", strtotime($date)),
                'number'    => $number,
                'bank'      => $bank,
            ]);

            return redirect(route('send_checks'))->with('message', 'چک با موفقیت اپدیت شد.');
        } catch (\Exception $e) {
            return redirect(route('send_checks'))->withErrors(['error' => 'مشکلی در اپدیت چک وجود دارد.']);
        }
    }

    public function delete(SendCheck $check)
    {
        try {

            $check->delete();

            $this->save_change($check->id, SendCheck::class, "delete", null);

            return redirect(route('send_checks'))->with('message', 'چک با موفقیت حذف شد.');
        } catch (\Exception $e) {
            return redirect(route('send_checks'))->withErrors(['error' => 'مشکلی در حذف چک وجود دارد.']);
        }
    }
}
