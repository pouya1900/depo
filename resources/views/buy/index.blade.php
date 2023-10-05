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

                <div class="add_button">
                    <a href="{{route('create_buy')}}">
                        افزودن خرید
                    </a>
                </div>

                <table id="myTable" class="table table-striped">
                    <thead>
                    <tr>
                        <th>تاریخ</th>
                        <th>شن</th>
                        <th>معدن</th>
                        <th>ماشین</th>
                        <th>وزن واقعی</th>
                        <th>وزن تخفیف</th>
                        <th>فی</th>
                        <th>کل</th>
                        <th>پرداخت</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($buys as $buy)
                        <tr>
                            <td>{{jdate(strtotime($buy->date))->format("Y-m-d")}}</td>
                            <td>{{$buy->sand->name}}</td>
                            <td>{{$buy->mine->name}}</td>
                            <td>{{$buy->car}}</td>
                            <td>{{$buy->real_weight}}</td>
                            <td>{{$buy->mine_weight}}</td>
                            <td>{{$buy->price}}</td>
                            <td>{{$buy->total}}</td>
                            <td>{{$buy->type=="cash" ? "نقدی" : "حواله"}}</td>
                            <td><a class="table_action_green" href="{{route('edit_buy',$buy->id)}}">ویرایش</a>
                                <a class="table_action_red" href="{{route('delete_buy',$buy->id)}}">حدف</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>

        </div>
    </div>

@endsection

@section('script')
    <script>
        $('#myTable').DataTable({
            language: {
                "paginate": {
                    "first": "اولین",
                    "last": "اخرین",
                    "next": "بعدی",
                    "previous": "قبلی",
                },
                "search": "جستجو:",
                "lengthMenu": "نمایش _MENU_ ردیف",
                "info": "نمایش _START_ تا _END_ از _TOTAL_ ردیف",
                "infoEmpty": "نمایش 0 تا 0 از 0 ردیف",
                "emptyTable": "هیچ مقداری وجود ندارد.",
                "zeroRecords": "هیچ مقداری یافت نشد.",
            }
        });
    </script>
@endsection
