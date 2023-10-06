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

                @if ($filter["date"])
                    <div class="table_head_line">
                        <h5>خرید های تاریخ : {{jdate($filter["date"])->format("Y-m-d")}}</h5>
                    </div>
                @elseif ($filter["mine"])
                    <div class="table_head_line">
                        <h5>خرید های معدن : {{$filter["mine"]->name}}</h5>
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
                            <td>
                                <a href="{{route('buys',['date'=>strtotime($buy->date)])}}">{{jdate(strtotime($buy->date))->format("Y-m-d")}}</a>
                            </td>
                            <td><a href="{{route('buys',['sand'=>$buy->sand_id])}}">{{$buy->sand->name}}</a></td>
                            <td><a href="{{route('buys',['mine'=>$buy->mine_id])}}">{{$buy->mine->name}}</a></td>
                            <td>{{$buy->car}}</td>
                            <td>{{$buy->real_weight}}</td>
                            <td>{{$buy->mine_weight}}</td>
                            <td>{{$buy->price}}</td>
                            <td>{{$buy->total}}</td>
                            <td>{{$buy->type=="cash" ? "نقدی" : "حواله"}}</td>
                            <td><p><a class="table_action_green" href="{{route('edit_buy',$buy->id)}}">ویرایش</a></p>
                                <p><a class="table_action_red delete_button"
                                      href="{{route('delete_buy',$buy->id)}}">حدف</a></p>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <div class="information">
                    <p>قیمت : {{number_format($buys->sum('total'))}}</p>
                    <p>وزن واقعی : {{number_format($buys->sum('real_weight'))}}</p>
                    <p>وزن تخفیف : {{number_format($buys->sum('mine_weight'))}}</p>
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
