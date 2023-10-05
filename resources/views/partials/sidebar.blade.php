<div class="col-md-2">

    <div class="side_bar_container">

        <ul>
            <li class="{{url()->current()==route('index') ? "active" : ""}}"><a href="{{route('index')}}"> داشبورد</a>
            </li>
            <li class="{{url()->current()==route('users') ? "active" : ""}}"><a href="{{route('users')}}">کاربران
                    </a></li>
            <li class="{{url()->current()==route('sands') ? "active" : ""}}"><a href="{{route('sands')}}">شن ها
                    </a></li>
            <li class="{{url()->current()==route('buys') ? "active" : ""}}"><a href="{{route('buys')}}">لیست خرید
                    </a></li>
            <li class="{{url()->current()==route('sells') ? "active" : ""}}"><a href="{{route('sells')}}">لیست فروش
                    </a></li>
            <li class="{{url()->current()==route('checks') ? "active" : ""}}"><a href="{{route('checks')}}">لیست چک ها
                    </a></li>
        </ul>

    </div>

</div>
