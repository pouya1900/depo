@extends('layouts.main')

@section('content')

    <div class="col-md-10">
        <div class="content_container">

            <div class="content_box">
                @if (count($errors))
                    <div class="alert alert-danger alert-dismissible login_form--alert" role="alert">
                        <strong>{{ $errors->first() }}</strong>
                    </div>
                @endif
                @if (session('message'))
                    <div class="alert alert-success alert-dismissible " role="alert">
                        <strong>{{ session('message') }}</strong>
                    </div>
                @endif
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="calculation_item">
                            <span>کل فروش امروز : </span>
                            <span>{{number_format($calculation['today'])}}</span>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="calculation_item">
                            <span>کل فروش هفته : </span>
                            <span>{{number_format($calculation['week'])}}</span>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="calculation_item">
                            <span>کل فروش ماه : </span>
                            <span>{{number_format($calculation['month'])}}</span>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="calculation_item">
                            <span>پرفروش ترین شن ماه : </span>
                            <span>{{$calculation['best_sand'] ? $calculation['best_sand']->sand->name ." : ". number_format($calculation['best_sand']->sum) : ""}}</span>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="calculation_item">
                            <span>کاربر فعال ماه : </span>
                            <span>{{$calculation['best_user'] ? $calculation['best_user']->user->name ." : ". number_format($calculation['best_user']->sum) : ""}}</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
