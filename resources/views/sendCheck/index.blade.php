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
                    <a href="{{route('create_send_check')}}">
                        افزودن چک
                    </a>
                </div>

                <table id="myTable" class="table table-striped">
                    <thead>
                    <tr>
                        <th>نام گیرنده</th>
                        <th>صاحب چک</th>
                        <th>مبلغ</th>
                        <th>تاریخ</th>
                        <th>شماره چک</th>
                        <th>بانک</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($checks as $check)
                        <tr>
                            <td>{{$check->user_name}}</td>
                            <td>{{$check->own_name}}</td>
                            <td>{{$check->amount}}</td>
                            <td>{{jdate(strtotime($check->date))->format("Y-m-d")}}</td>
                            <td>{{$check->number}}</td>
                            <td>{{$check->bank}}</td>
                            <td><a class="table_action_green" href="{{route('edit_send_check',$check->id)}}">ویرایش</a>
                                <a class="table_action_red" href="{{route('delete_send_check',$check->id)}}">حدف</a>
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
