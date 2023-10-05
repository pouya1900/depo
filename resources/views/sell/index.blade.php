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

                @if ($filter["date"])
                    <div class="table_head_line">
                        <h5>خرید های تاریخ : {{jdate($filter["date"])->format("Y-m-d")}}</h5>
                    </div>
                @elseif ($filter["user"])
                    <div class="table_head_line">
                        <h5>خرید های کاربر : {{$filter["user"]->car." ".$filter["user"]->name}}</h5>
                    </div>
                @elseif ($filter["sand"])
                    <div class="table_head_line">
                        <h5>خرید های شن : {{$filter["sand"]->name}}</h5>
                    </div>
                @endif

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
                            <td>
                                <a href="{{route('sells',['date'=>strtotime($sell->date)])}}">{{jdate(strtotime($sell->date))->format("Y-m-d")}}</a>
                            </td>
                            <td><a href="{{route('sells',['sand'=>$sell->sand_id])}}">{{$sell->sand->name}}</a>
                            </td>
                            <td><a href="{{route('sells',['user'=>$sell->user_id])}}">{{$sell->user->car}}</a>
                            </td>
                            <td><a href="{{route('sells',['user'=>$sell->user_id])}}">{{$sell->user->name}}</a>
                            </td>
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

                <div class="information">
                    <p>قیمت : {{number_format($sells->sum('total'))}}</p>
                    <p>وزن : {{number_format($sells->sum('weight'))}}</p>
                    <p>پرداخت شده : {{number_format($sells->sum('paid'))}}</p>
                    <p>باقی مانده : {{number_format($sells->sum('total') - $sells->sum('paid'))}}</p>
                    <p>نقد : {{number_format($sells->sum('cash'))}}</p>
                </div>

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
