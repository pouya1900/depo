@extends('layouts.main')

@section('content')

    <div class="col-md-10">
        <div class="content_container">

            <div class="content_box">
                <div class="row justify-center">
                    <div class="col-md-6 col-12">
                        <form method="post" action="{{route('store_sand')}}">
                            {{csrf_field()}}


                            <div class="input-group">
                                <label for="name" class="input-group-text">نام</label>
                                <input type="text" class="form-control" id="name" name="name">
                            </div>

                            <div class="input-group">
                                <label for="price" class="input-group-text">قیمت</label>
                                <input type="number" class="form-control" id="price" name="price">
                            </div>

                            <div class="input-group">
                                <label for="weight" class="input-group-text">وزن موجود</label>
                                <input type="number" class="form-control" id="weight" name="weight">
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


