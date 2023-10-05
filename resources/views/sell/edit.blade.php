@extends('layouts.main')

@section('head')
    <link rel="stylesheet" href="storage/css/persian-datepicker.min.css"/>
    <script src="storage/js/persian-date.min.js"></script>
    <script src="storage/js/persian-datepicker.min.js"></script>
@endsection

@section('content')

    <div class="col-md-10">
        <div class="content_container">

            <div class="content_box">
                <div class="row justify-center">
                    <div class="col-md-6 col-12">
                        <form method="post" action="{{route('update_sell',$sell->id)}}">
                            {{csrf_field()}}


                            <div class="input-group">
                                <label for="car" class="input-group-text">ماشین</label>

                                <select id="car" name="car" class="form-control" onchange="select_user()">
                                    <option value="0">هیچکدام</option>
                                    @foreach($users as $user)
                                        <option data-balance="{{$user->balance}}"
                                                value="{{$user->id}}" {{$sell->user_id==$user->id ? "selected" : ""}}>{{$user->car." ".$user->name}}</option>
                                    @endforeach
                                </select>
                                <div class="car_pluck" style="display: none">
                                    <span class="">شماره پلاک</span>
                                    <div class="input-group">
                                        <label for="pluck1" class="input-group-text">ایران</label>
                                        <input type="text" maxlength="2" class="form-control" id="pluck1" name="pluck1">

                                        <input type="text" maxlength="2" class="form-control" id="pluck2" name="pluck2">

                                        <select name="pluck3">
                                            @foreach($chars as $char)
                                                <option value="{{$char}}">{{$char}}</option>
                                            @endforeach
                                        </select>

                                        <input type="text" maxlength="3" class="form-control" id="pluck4" name="pluck4">


                                    </div>
                                    <div class="input-group">
                                        <label for="driver_name" class="input-group-text">نام راننده</label>
                                        <input type="number" class="form-control" id="driver_name" name="driver_name">
                                    </div>
                                </div>

                            </div>

                            <div class="input-group">
                                <label for="date" class="input-group-text">تاریخ</label>
                                <input type="text" class="form-control" id="date" name="date"
                                       value="{{$sell->date}}">
                            </div>

                            <div class="input-group">
                                <label for="sand" class="input-group-text">نوع شن</label>
                                <select class="form-control" id="sand" name="sand" required onchange="select_sand()">
                                    <option>انتخاب</option>
                                    @foreach($sands as $sand)
                                        <option data-price="{{$sand->price}}"
                                                value="{{$sand->id}}" {{$sell->sand_id==$sand->id ? "selected" : ""}}>{{$sand->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="input-group">
                                <label for="weight" class="input-group-text">وزن</label>
                                <input type="number" class="form-control" id="weight" name="weight"
                                       value="{{$sell->weight}}"
                                       onkeyup="calculate()">
                            </div>
                            <div class="input-group">
                                <label for="price" class="input-group-text">قیمت واحد</label>
                                <input type="number" class="form-control" id="price" name="price"
                                       value="{{$sell->price}}"
                                       onkeyup="calculate()">
                            </div>

                            <div class="total_price_container">
                                <span>قیمت کل : </span>
                                <span id="total_price">{{number_format($sell->total)}}</span>
                            </div>

                            <div class="input-group">
                                <label for="paid" class="input-group-text">پرداخت نقدی</label>
                                <input type="number" class="form-control" id="paid" name="paid" onkeyup="payment()"
                                       value="{{$sell->cash}}">
                            </div>

                            <div class="total_price_container">
                                <span>باقی مانده : </span>
                                <span id="remaining">{{number_format($sell->total - $sell->paid)}}</span>
                            </div>

                            <div class="form-check form-switch">
                                اعتبار : <span
                                    id="user_balance">{{number_format($sell->user->balance)}}</span><span>{{"(+".number_format($sell->balance).")"}}</span>
                            </div>

                            <div class="input-group">
                                <button class="submit_button">ثبت</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

@section('script')
    <script>
        $("#date").pDatepicker({
            autoClose: true,
            format: "YYYY-MM-DD",
            calendar: {
                persian: {
                    locale: 'en'
                }
            }
        });
    </script>
    <script>

        let total = {{$sell->total}};
        let remain = {{$sell->total - $sell->paid}};
        let balance = {{$sell->user->balance + $sell->balance}};

        function calculate() {
            let weight = $("input[name=weight]").val();
            let price = $("input[name=price]").val();

            total = weight * price / 1000;

            $("input[name=paid]").val(total);
            $("#total_price").html(Intl.NumberFormat("en-US", {maximumFractionDigits: 6}).format(total));
        }

        function payment() {
            let paid = $("input[name=paid]").val();

            remain = total - paid;

            if (remain < 0) {
                $("#paid").css("color", "red");
            } else {
                $("#paid").css("color", "black");
            }

            if (balance > remain) {
                $("#user_balance").css("color", "green");
            } else {
                $("#user_balance").css("color", "red");
            }


            $("#remaining").html(Intl.NumberFormat("en-US", {maximumFractionDigits: 6}).format(remain));
        }

        function select_user() {
            let item = $("select[name=car]");
            balance = $("option:selected", item).data('balance');

            if (item.val() > 0) {
                $(".car_pluck").hide();
                $("#user_balance").html(Intl.NumberFormat("en-US", {maximumFractionDigits: 6}).format(balance));
            } else {
                $(".car_pluck").show();
                $("#user_balance").html("");
            }
        }

        function select_sand() {
            let item = $("select[name=sand]");
            let price = $("option:selected", item).data('price');
            $("input[name=price]").val(price);
        }
    </script>
@endsection
