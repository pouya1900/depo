<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use App\Models\Member;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;

class DepositController extends Controller
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {
        $deposits = Deposit::orderBy('date', 'desc')->get();

        return view('deposits.index', compact('deposits'));
    }

    public function create()
    {
        $members = Member::all();
        return view('deposits.create', compact('members'));
    }

    public function store()
    {
        try {
            $member = $this->request->input('member');
            $amount = $this->request->input('amount');
            $reason = $this->request->input('reason');

            $j_date = $this->request->input('date');
            $date = Jalalian::fromFormat('Y-m-d', $j_date)->toCarbon();

            Deposit::create([
                'member_id' => $member,
                'amount'    => $amount,
                'reason'    => $reason,
                'date'      => $date,
            ]);

            $this->save_change(null, Deposit::class, "create", [
                'member_id' => $member,
                'amount'    => $amount,
                'reason'    => $reason,
                "date"      => date("Y-m-d H:i:s", strtotime($date)),
            ]);

            return redirect(route('deposits'))->with('message', 'واریزی با موفقیت ثبت شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'مشکلی در ثبت واریزی وجود دارد.']);
        }
    }

    public function edit(Deposit $deposit)
    {
        $members = Member::all();
        return view('deposits.edit', compact('deposit', 'members'));
    }

    public function update(Deposit $deposit)
    {
        try {
            $member = $this->request->input('member');
            $amount = $this->request->input('amount');
            $reason = $this->request->input('reason');

            $j_date = $this->request->input('date');
            $date = Jalalian::fromFormat('Y-m-d', $j_date)->toCarbon();

            $deposit->update([
                'member_id' => $member,
                'amount'    => $amount,
                'reason'    => $reason,
                'date'      => $date,
            ]);

            $this->save_change($deposit->id, Deposit::class, "update", [
                'member_id' => $member,
                'amount'    => $amount,
                'reason'    => $reason,
                "date"      => date("Y-m-d H:i:s", strtotime($date)),
            ]);

            return redirect(route('deposits'))->with('message', 'واریزی با موفقیت اپدیت شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'مشکلی در اپدیت واریزی وجود دارد.']);
        }
    }

    public function delete(Deposit $deposit)
    {
        try {

            $deposit->delete();

            $this->save_change($deposit->id, Deposit::class, "delete", null);

            return redirect(route('deposits'))->with('message', 'واریزی با موفقیت حذف شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'مشکلی در حذف واریزی وجود دارد.']);
        }
    }
}
