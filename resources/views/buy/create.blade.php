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
                        <form method="post" action="{{route('store_buy')}}">
                            {{csrf_field()}}

                            <div class="input-group">
                                <label for="date" class="input-group-text">تاریخ</label>
                                <input type="text" class="form-control locale-en" id="date" name="date">
                            </div>

                            <div class="input-group">
                                <label for="sand" class="input-group-text">نوع شن</label>
                                <select class="form-control" id="sand" name="sand" required>
                                    <option>انتخاب</option>
                                    @foreach($sands as $sand)
                                        <option value="{{$sand->id}}">{{$sand->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="input-group">
                                <label for="mine" class="input-group-text">معدن</label>
                                <select class="form-control" id="mine" name="mine" required>
                                    <option>انتخاب</option>
                                    @foreach($mines as $mine)
                                        <option value="{{$mine->id}}">{{$mine->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="input-group">
                                <label for="car" class="input-group-text">راننده</label>
                                <input type="text" class="form-control locale-en" id="car" name="car">
                            </div>
                            <div class="input-group">
                                <label for="real_weight" class="input-group-text">وزن واقعی</label>
                                <input type="number" class="form-control" id="real_weight" name="real_weight">
                            </div>

                            <div class="input-group">
                                <label for="mine_weight" class="input-group-text">وزن تخفیف</label>
                                <input type="number" class="form-control" id="mine_weight" name="mine_weight"
                                       onkeyup="calculate()">
                            </div>

                            <div class="input-group">
                                <label for="price" class="input-group-text">فی</label>
                                <input type="number" class="form-control" id="price" name="price" onkeyup="calculate()">
                            </div>

                            <div class="total_price_container">
                                <span>قیمت کل : </span>
                                <span id="total_price"></span>
                            </div>

                            <div class="form-check">
                                <label for="cash" class="form-check-label">نقدی</label>
                                <input type="radio" value="cash" class="form-check-input" id="cash" name="type">
                            </div>
                            <div class="form-check">
                                <label for="order" class="form-check-label">حواله</label>
                                <input type="radio" value="order" class="form-check-input" id="order" name="type">
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
        let total;

        function calculate() {
            let weight = $("input[name=mine_weight]").val();
            let price = $("input[name=price]").val();

            total = weight * price / 1000;

            $("#total_price").html(Intl.NumberFormat("en-US", {maximumFractionDigits: 6}).format(total));
        }
    </script>
@endsection
