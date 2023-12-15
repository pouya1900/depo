@extends('layouts.main')

@section('content')

    <div class="col-md-10">
        <div class="content_container">

            <div class="content_box">
                <div class="row justify-center">
                    <div class="col-md-6 col-12">
                        <form method="post" action="{{route('update_user',$user->id)}}">
                            {{csrf_field()}}
                            <div class="car_pluck">
                                <span class="">شماره پلاک : {{$user->car}}</span>
                                <div class="input-group">
                                    <label for="pluck1" class="input-group-text">ایران</label>
                                    <input type="text" maxlength="2" class="form-control" id="pluck1" name="pluck1"
                                           value="{{$pluck[1]}}">

                                    <input type="text" maxlength="2" class="form-control" id="pluck2" name="pluck2"
                                           value="{{$pluck[2]}}">

                                    <select name="pluck3">
                                        @foreach($chars as $char)
                                            <option
                                                {{$pluck[1] == $char ? "selected" : ""}} value="{{$char}}">{{$char}}</option>
                                        @endforeach
                                    </select>

                                    <input type="text" maxlength="3" class="form-control" id="pluck4" name="pluck4"
                                           value="{{$pluck[4]}}">


                                </div>
                            </div>

                            <div class="input-group">
                                <label for="name" class="input-group-text">نام راننده</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{$user->name}}">
                            </div>

                            <div class="input-group">
                                <label for="balance" class="input-group-text">اعتبار</label>
                                <input type="number" class="form-control" id="balance" name="balance"
                                       value="{{$user->balance}}">
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


