@extends('layouts.main')

@section('content')

    <div class="col-md-10">
        <div class="content_container">

            <div class="content_box">
                <div class="row justify-center">
                    <div class="col-md-6 col-12">
                        <form method="post" action="{{route('update_member',$member->id)}}">
                            {{csrf_field()}}

                            <div class="input-group">
                                <label for="name" class="input-group-text">نام</label>
                                <input type="text" value="{{$member->name}}" class="form-control" id="name" name="name">
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

@endsection
