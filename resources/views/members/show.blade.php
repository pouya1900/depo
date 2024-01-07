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

                <form action="{{route('show_member',$member->id)}}" method="get">
                    <div class="row" style="margin: 30px 20px">
                        <div class="col-6">
                            <div class="input-group">
                                <label for="date1" class="input-group-text">از تاریخ</label>
                                <input type="text" class="form-control locale-en" id="date1" name="date1"
                                       value="{{$date1}}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="input-group">
                                <label for="date2" class="input-group-text">تا تاریخ</label>
                                <input type="text" class="form-control locale-en" id="date2" name="date2"
                                       value="{{$date2}}">
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-12 col-lg-4">
                            <div class="input-group">
                                <button class="submit_button">جست و جو</button>
                            </div>
                        </div>
                    </div>
                </form>
                <table id="myTable" class="table table-striped">
                    <thead>
                    <tr>
                        <th>گیرنده</th>
                        <th>مبلغ</th>
                        <th>بابت</th>
                        <th>تاریخ</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($deposits as $deposit)
                        <tr>
                            <td>{{$deposit->member->name}}</td>
                            <td>{{$deposit->amount}}</td>
                            <td>{{$deposit->reason}}</td>
                            <td>{{jdate(strtotime($deposit->date))->format("Y-m-d")}}</td>
                            <td><a class="table_action_green" href="{{route('edit_deposit',$deposit->id)}}">ویرایش</a>
                                <a class="table_action_red" href="{{route('delete_deposit',$deposit->id)}}">حدف</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <div style="margin-top: 40px">
                    <h5>جمع کل : {{$deposits->sum("amount")}}</h5>
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

    <script>
        $("#date1").pDatepicker({
            autoClose: true,
            format: "YYYY-MM-DD",
            calendar: {
                persian: {
                    locale: 'en'
                }
            }
        });

        $("#date2").pDatepicker({
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
