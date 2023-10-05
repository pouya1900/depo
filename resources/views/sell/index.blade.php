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
                    <a href="{{route('create_sell')}}">
                        افزودن فاکتور فروش
                    </a>
                </div>

                <table id="myTable" class="table table-striped">
                    <thead>
                    <tr>
                        <th>تاریخ</th>
                        <th>شن</th>
                        <th>پلاک</th>
                        <th>راننده</th>
                        <th>وزن</th>
                        <th>فی</th>
                        <th>کل</th>
                        <th>پرداخت شده</th>
                        <th>باقی مانده</th>
                        <th>نقد</th>
                        <th>اعتبار</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($sells as $sell)
                        <tr>
                            <td>{{jdate(strtotime($sell->date))->format("Y-m-d")}}</td>
                            <td>{{$sell->sand->name}}</td>
                            <td>{{$sell->user->car}}</td>
                            <td>{{$sell->user->name}}</td>
                            <td>{{number_format($sell->weight)}}</td>
                            <td>{{number_format($sell->price)}}</td>
                            <td>{{number_format($sell->total)}}</td>
                            <td>{{number_format($sell->paid)}}</td>
                            <td>{{number_format($sell->total - $sell->paid)}}</td>
                            <td>{{number_format($sell->cash) }}</td>
                            <td>{{number_format($sell->balance)}}</td>
                            <td>
                                <a class="table_action_green" href="{{route('complete_sell',$sell->id)}}">تسویه</a>
                                <a class="table_action_green" href="{{route('edit_sell',$sell->id)}}">ویرایش</a>
                                <a class="table_action_red delete_sell_button"
                                   href="{{route('delete_sell',$sell->id)}}">حذف</a>
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
