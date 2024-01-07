<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;

class MemberController extends Controller
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {
        $members = Member::all();

        return view('members.index', compact('members'));
    }

    public function create()
    {
        return view('members.create');
    }

    public function store()
    {
        try {
            $name = $this->request->input('name');

            Member::create([
                'name' => $name,
            ]);

            $this->save_change(null, Member::class, "create", [
                'name' => $name,
            ]);

            return redirect(route('members'))->with('message', 'عضو با موفقیت ثبت شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'مشکلی در ثبت عضو وجود دارد.']);
        }
    }

    public function edit(Member $member)
    {
        return view('members.edit', compact('member'));
    }

    public function update(Member $member)
    {
        try {
            $name = $this->request->input('name');

            $member->update([
                'name' => $name,
            ]);

            $this->save_change($member->id, Member::class, "update", [
                'name' => $name,
            ]);

            return redirect(route('members'))->with('message', 'عضو با موفقیت اپدیت شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'مشکلی در اپدیت عضو وجود دارد.']);
        }
    }

    public function delete(Member $member)
    {
        try {

            $member->delete();

            $this->save_change($member->id, Member::class, "delete", null);

            return redirect(route('members'))->with('message', 'عضو با موفقیت حذف شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'مشکلی در حذف عضو وجود دارد.']);
        }
    }

    public function show(Member $member)
    {
        $date1 = Jalalian::fromFormat('Y-m-d', $this->request->input("date1"))->toCarbon();
        $date2 = Jalalian::fromFormat('Y-m-d', $this->request->input("date2"))->toCarbon();

        $deposits = $member->deposits()->when($date1 && $date2, function ($q) use ($date1, $date2) {
            return $q->where("date", ">=", $date1)->where("date", "<=", $date2);
        })->get();

        return view('members.show', compact('member', 'date1', 'date2', 'deposits'));
    }

}
