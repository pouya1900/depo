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
                        <form method="post" action="{{route('store_deposit')}}">
                            {{csrf_field()}}


                            <div class="input-group">
                                <label for="member" class="input-group-text">گیرنده</label>

                                <select name="member" id="member">
                                    <option value="0">انتخاب گیرنده ...</option>
                                    @foreach($members as $member)
                                        <option value="{{$member->id}}">{{$member->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="input-group">
                                <label for="amount" class="input-group-text">مبلغ</label>
                                <input type="number" class="form-control" id="amount" name="amount">
                            </div>

                            <div class="input-group">
                                <label for="date" class="input-group-text">تاریخ</label>
                                <input type="text" class="form-control locale-en" id="date" name="date">
                            </div>

                            <div class="input-group">
                                <label for="reason" class="input-group-text">بابت</label>
                                <input type="text" class="form-control" id="reason" name="reason">
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
@endsection
