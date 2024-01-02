<?php

namespace App\Http\Controllers;

use App\Models\Change;
use App\Models\Sell;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function Symfony\Component\Translation\t;

class DashboardController extends Controller
{

    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function home()
    {
        return redirect(route('sells'));
    }

    public function dashboard()
    {
        $now = Carbon::now();

        $first_of_week = Carbon::today()->startOfweek(6);
        $first_of_month = Carbon::today()->startOfMonth();

        $today = Sell::where('date', '>', date('Y-m-d 00:00:00'))->sum('total');
        $week = Sell::where('date', '>', $first_of_week)->sum('total');
        $month = Sell::where('date', '>', $first_of_month)->sum('total');

        $best_sand = Sell::selectRaw('sand_id,SUM(weight) as sum')->groupBy('sand_id')->orderBy('sum', 'desc')->where('date', '>', $first_of_month)->first();

        $best_user = Sell::selectRaw('user_id,SUM(total) as sum')->groupBy('user_id')->orderBy('sum', 'desc')->where('date', '>', $first_of_month)->first();

        $calculation = [
            "today"     => $today,
            "week"      => $week,
            "month"     => $month,
            "best_sand" => $best_sand,
            "best_user" => $best_user,
        ];

        return view('dashboard.index', compact('calculation'));
    }

    //    local
    public function update()
    {
        try {
            $parameters = Change::where("env", env("APP_ENV"))->get();
            if (!count($parameters)) {
                $url = env("APP_URL_SERVER") . "api/get_update";
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
                curl_setopt($ch, CURLOPT_POST, 0);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $result = curl_exec($ch);
                curl_close($ch);
                $response = json_decode($result, true);
                dd($result);
                if (!$response["status"]) {

                    $changes = $response["changes"];

                    DB::beginTransaction();
                    try {
                        foreach ($changes as $parameter) {

                            $model = $parameter["model"];
                            $model_id = $parameter["model_id"];
                            $action = $parameter["action"];
                            $data = $parameter["data"];
                            $data = json_decode($data, true);
                            if ($action == "create") {
                                $model::create($data);
                            } else if ($action == "update") {
                                $instance = $model::find($model_id);
                                $instance->update($data);
                            } else if ($action == "delete") {
                                $instance = $model::find($model_id);
                                $instance->delete();
                            }
                        }

                        $url = env("APP_URL_SERVER") . "api/get_update/success";
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $url);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
                        curl_setopt($ch, CURLOPT_POST, 0);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $result = curl_exec($ch);
                        curl_close($ch);
                        $response = json_decode($result, true);
                        if ($response["status"]) {
                            DB::rollback();
                            return redirect(route('dashboard'))->withErrors(['error' => 'مشکلی در همگام سازی اطلاعات وجود دارد.']);
                        }
                        DB::commit();
                        return redirect(route('dashboard'))->with('message', 'اطلاعات با موفقیت همگام سازی شد.');

                    } catch (\Exception|\Throwable $e) {
                        DB::rollback();
                        return redirect(route('dashboard'))->withErrors(['error' => 'مشکلی در همگام سازی اطلاعات وجود دارد.']);

                    }

                }


                return redirect(route('dashboard'))->with('message', 'اطلاعاتی برای همگام سازی وجود ندارد.');
            }

            $url = env("APP_URL_SERVER") . "api/update";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($parameters));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            curl_close($ch);
            $response = json_decode($result, true);

            if (!$response["status"]) {
                Change::where("id", '>', '0')->delete();
                return redirect(route('dashboard'))->with('message', 'اطلاعات با موفقیت همگام سازی شد.');
            }
            return redirect(route('dashboard'))->withErrors(['error' => 'مشکلی در همگام سازی اطلاعات وجود دارد.']);

        } catch (\Exception|\Throwable $e) {
            return redirect(route('dashboard'))->withErrors(['error' => 'مشکلی در همگام سازی اطلاعات وجود دارد.']);
        }
    }

    //    local


//    server

    public function do_update()
    {
        DB::beginTransaction();
        try {
            $parameters = $this->request->all();

            foreach ($parameters as $parameter) {

                $model = $parameter["model"];
                $model_id = $parameter["model_id"];
                $action = $parameter["action"];
                $data = $parameter["data"];
                $data = json_decode($data, true);
                if ($action == "create") {
                    $model::create($data);
                } else if ($action == "update") {
                    $instance = $model::find($model_id);
                    $instance->update($data);
                } else if ($action == "delete") {
                    $instance = $model::find($model_id);
                    $instance->delete();
                }
            }
            DB::commit();

            return response()->json(["status" => 0]);
        } catch (\Exception|\Throwable $e) {
            DB::rollback();
            return response()->json(["status" => 1, "message" => $e]);
        }
    }

    public function get_update()
    {
        try {
            $changes = Change::where("env", env("APP_ENV"))->get();
            if (!count($changes)) {
                return response()->json(["status" => 1]);
            }

            return response()->json(["status" => 0, 'changes' => $changes]);
        } catch (\Exception|\Throwable $e) {
            return response()->json(["status" => 1]);
        }
    }

    public function get_update_success()
    {
        try {
            Change::where("env", env("APP_ENV"))->delete();

            return response()->json(["status" => 0]);
        } catch (\Exception|\Throwable $e) {
            return response()->json(["status" => 1]);
        }
    }

//    server


}
