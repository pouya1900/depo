<div class="col-md-2">
    <div class="side_bar_container">
        <div class="mobile_menu_close_button">بستن</div>

        <ul>
            <li class="{{url()->current()==route('dashboard') ? "active" : ""}}"><a href="{{route('dashboard')}}">
                    داشبورد</a>
            </li>
            <li class="{{url()->current()==route('sells') ? "active" : ""}}"><a href="{{route('sells')}}">لیست فروش
                </a></li>
            <li class="{{url()->current()==route('users') ? "active" : ""}}"><a href="{{route('users')}}">کاربران
                </a></li>
            <li class="{{url()->current()==route('mines') ? "active" : ""}}"><a href="{{route('mines')}}">معدن ها
                </a></li>
            <li class="{{url()->current()==route('sands') ? "active" : ""}}"><a href="{{route('sands')}}">شن ها
                </a></li>
            <li class="{{url()->current()==route('buys') ? "active" : ""}}"><a href="{{route('buys')}}">لیست خرید
                </a></li>
            <li class="{{url()->current()==route('checks') ? "active" : ""}}"><a href="{{route('checks')}}">لیست چک های
                    دریافتی
                </a></li>
            <li class="{{url()->current()==route('send_checks') ? "active" : ""}}"><a href="{{route('send_checks')}}">لیست
                    چک های
                    ارسالی
                </a></li>
            <li class="{{url()->current()==route('deposits') ? "active" : ""}}"><a href="{{route('deposits')}}">لیست
                    واریزی ها
                </a></li>
            <li class="{{url()->current()==route('members') ? "active" : ""}}"><a href="{{route('members')}}">لیست
                    اعضا
                </a></li>
        </ul>

        @if (env("APP_ENV")=="local")
            <div class="side_bar_update">
                <a href="{{route("update")}}">بروزرسانی</a>
            </div>
        @endif

    </div>

</div>
