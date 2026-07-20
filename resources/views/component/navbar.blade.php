<!-- Navbar -->
<header class="navbar navbar-expand-md navbar-overlap d-print-none" data-bs-theme="dark">
  <div class="container-xl">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu"
      aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
    <img width="100"src="{{ URL::asset('/assets/static/logo-uninet.svg') }}" class="logo-static" alt="" decoding="async" fetchpriority="high">
    </h1>
    <div class="navbar-nav flex-row order-md-last">
        @if(session('from') == 'limputra')
        <div class="mt-1">
          <a href="{{ url('/console/reseller/backtolimputra') }}" class="btn btn-danger btnlogin" title="Edit">Back to Limputra</a>
        </div>
        @endif
      <div class="d-none d-md-flex">
        <a href="?theme=dark" class="nav-link px-0 hide-theme-dark" title="Enable dark mode" data-bs-toggle="tooltip"
          data-bs-placement="bottom">
          <!-- Download SVG icon from http://tabler-icons.io/i/moon -->
          <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
            stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z" />
          </svg>
        </a>
        <a href="?theme=light" class="nav-link px-0 hide-theme-light" title="Enable light mode" data-bs-toggle="tooltip"
          data-bs-placement="bottom">
          <!-- Download SVG icon from http://tabler-icons.io/i/sun -->
          <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
            stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
            <path d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7" />
          </svg>
        </a>


        @inject("Admin", "App\Http\Controllers\AdminController")

        <?php

              function timeAgo($time_ago)
              {
                  $time_ago = strtotime($time_ago);
                  $cur_time   = time();
                  $time_elapsed   = $cur_time - $time_ago;
                  $seconds    = $time_elapsed ;
                  $minutes    = round($time_elapsed / 60 );
                  $hours      = round($time_elapsed / 3600);
                  $days       = round($time_elapsed / 86400 );
                  $weeks      = round($time_elapsed / 604800);
                  $months     = round($time_elapsed / 2600640 );
                  $years      = round($time_elapsed / 31207680 );
                  // Seconds
                  if($seconds <= 60){
                      return "just now";
                  }
                  //Minutes
                  else if($minutes <=60){
                      if($minutes==1){
                          return "one minute ago";
                      }
                      else{
                          return "$minutes minutes ago";
                      }
                  }
                  //Hours
                  else if($hours <=24){
                      if($hours==1){
                          return "an hour ago";
                      }else{
                          return "$hours hrs ago";
                      }
                  }
                  //Days
                  else if($days <= 7){
                      if($days==1){
                          return "yesterday";
                      }else{
                          return "$days days ago";
                      }
                  }
                  //Weeks
                  else if($weeks <= 4.3){
                      if($weeks==1){
                          return "a week ago";
                      }else{
                          return "$weeks weeks ago";
                      }
                  }
                  //Months
                  else if($months <=12){
                      if($months==1){
                          return "a month ago";
                      }else{
                          return "$months months ago";
                      }
                  }
                  //Years
                  else{
                      if($years==1){
                          return "one year ago";
                      }else{
                          return "$years years ago";
                      }
                  }
              }

        ?>

        <div class="nav-item dropdown d-none d-md-flex me-3">
                <a href="#" class="nav-link px-0" data-bs-toggle="dropdown" tabindex="-1" aria-label="Show notifications" aria-expanded="false">
                  <!-- Download SVG icon from http://tabler-icons.io/i/bell -->
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icn-notif" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M10 5a2 2 0 1 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6"></path><path d="M9 17v1a3 3 0 0 0 6 0v-1"></path></svg>
                  @if($Admin::Count_notifications() != 0)
                  <span class="badge bg-red text-red-fg ms-2">{{$Admin::Count_notifications()}}</span>
                  @else
                  @endif
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-end dropdown-menu-card">
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Notification Admin</h3>
                    </div>
                    <div style="max-height:500px;overflow:scroll;" class="list-group list-group-flush list-group-hoverable">
                      @forelse($Admin::List_notifications() as $notf)
                      <div class="list-group-item">
                        <div class="row align-items-center" style="min-width:300px;">
                          <div class="col-auto">
                            @if($notf->readable == 0)
                              <span class="status-dot status-dot-animated bg-green d-block"></span>
                            @else
                              <span class="status-dot d-block"></span>
                            @endif
                          </div>
                          <div class="col">
                            <div href="#" class="text-body d-block">{{$notf->subject}}</div>
                            <div class="badge bg-blue text-blue-fg">{{timeAgo($notf->createdAt, true)}}</div>
                            <div class="text-secondary">
                              {{$notf->message}}
                            </div>
                          </div>
                        </div>
                      </div>
                      @empty

                        <div class="list-group-item">
                          <div class="row align-items-center" style="min-width:300px;">
                            <div class="col-auto">
                              <svg xmlns="http://www.w3.org/2000/svg" class="icon icn-notif" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M10 5a2 2 0 1 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6"></path><path d="M9 17v1a3 3 0 0 0 6 0v-1"></path></svg>
                            </div>
                            <div class="col">
                              <div class="text-secondary">
                                Belum terdapat notifikasi
                              </div>
                            </div>
                          </div>
                        </div>

                      @endforelse
                    </div>
                  </div>
                </div>
              </div>

      </div>
      <div class="nav-item dropdown">
        <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
          <!-- <span class="avatar avatar-sm" style="background-image: url(./static/avatars/000m.jpg)"></span> -->
          <div class="d-xl-none">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z"></path><path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path></svg>
          </div>
          <div class="d-none d-xl-block ps-2">
            <div>{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</div>
            <div class="mt-1 small text-secondary">{{ auth()->user()->user_email }}</div>
          </div>
        </a>
        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" data-bs-theme="light">
          @if(session('role_id') == 3 && session('company_id') != 1)
          <a href="{{ url('/console/admin') }}" class="dropdown-item">User Management</a>
          <a href="{{ url('/console/product') }}" class="dropdown-item">Product Management</a>
          @endif

          @if(session('role_id') == 3 && session('company_id') == 1)
          <a href="{{ url('/console/admin') }}" class="dropdown-item">User Management</a>
          <a href="{{ url('/console/reseller') }}" class="dropdown-item">Reseller Management</a>
          <a href="{{ url('/console/product') }}" class="dropdown-item">Product Management</a>
          <a href="{{ url('/console/promo') }}" class="dropdown-item">Promo Management</a>
          <a href="{{ url('/console/reward') }}" class="dropdown-item">Reward Management</a>
          <a href="{{ url('/console/banner') }}" class="dropdown-item">Banner Management</a>
          <a href="{{ url('/console/documentation') }}" class="dropdown-item">Documentation Management</a>
          @else
          @endif

          @if((session('role_id') == 3 || session('role_id') == 6 || session('role_id') == 2) && session('company_id') == 1) 
          <a href="{{ url('/console/project') }}" class="dropdown-item">Project Area Management</a>
          @else
          @endif
          @if((session('role_id') == 3 || session('role_id') == 4 || session('role_id') == 6 || session('role_id') == 7) && session('company_id') == 1)
          <a href="{{ url('/console/report') }}" class="dropdown-item">Report</a>
          <a href="{{ url('/console/salesorder/list/commission') }}" class="dropdown-item">Commission</a>
          @endif
          @if((session('role_id') == 3 || session('role_id') == 4 || session('role_id') == 6 || session('role_id') == 7) && session('company_id') != 1)
          <a href="{{ url('/console/report') }}" class="dropdown-item">Report</a>
          @endif
          <hr class="my-2" />
          <a href="{{ url('/console/panduan') }}" class="dropdown-item">User Documentation</a>
          <a href="{{ url('/console/auth/logout') }}" class="dropdown-item">Logout</a>
        </div>
      </div>
    </div>
    <div class="collapse navbar-collapse" id="navbar-menu">
      <div class="d-flex flex-column flex-md-row flex-fill align-items-stretch align-items-md-center">
        <ul class="navbar-nav">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#navbar-help" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
              <span
                class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                  stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                  <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                  <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                  <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                </svg>
              </span>
              <span class="nav-link-title">
                Sales Order
              </span>
            </a>

            <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ url('/console/salesorder') }}" rel="noopener">
                      My Sales Order
                    </a>
                    <a class="dropdown-item" href="{{ url('/console/salesorder/incoming') }}">
                      Incoming Sales Order
                    </a>
            </div>
          </li>



<!--           <li class="nav-item">
            <a class="nav-link" href="{{ url('/console/order') }}">
              <span
                class="nav-link-icon d-md-none d-lg-inline-block">
                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-news"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M16 6h3a1 1 0 0 1 1 1v11a2 2 0 0 1 -4 0v-13a1 1 0 0 0 -1 -1h-10a1 1 0 0 0 -1 1v12a3 3 0 0 0 3 3h11" /><path d="M8 8l4 0" /><path d="M8 12l4 0" /><path d="M8 16l4 0" /></svg>
              </span>
              <span class="nav-link-title">
                Order
              </span>
            </a>
          </li>
 -->
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/console/subscription') }}">
              <span
                class="nav-link-icon d-md-none d-lg-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-world">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path>
                    <path d="M3.6 9h16.8"></path>
                    <path d="M3.6 15h16.8"></path>
                    <path d="M11.5 3a17 17 0 0 0 0 18"></path>
                    <path d="M12.5 3a17 17 0 0 1 0 18"></path>
                </svg>
              </span>
              <span class="nav-link-title">
                Subscription
              </span>
            </a>
          </li>

          @if(session('role_id') == 3 || session('role_id') == 5 || session('role_id') == 6 || session('role_id') == 1)
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/console/pipeline') }}">
              <span
                class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrows-down-up" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 3l0 18" /><path d="M10 18l-3 3l-3 -3" /><path d="M7 21l0 -18" /><path d="M20 6l-3 -3l-3 3" /></svg>
              </span>
              <span class="nav-link-title">
                Pipeline
              </span>
            </a>
          </li>
          @endif

          @if(session('role_id') == 3 || session('role_id') == 4 || session('role_id') == 7)
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/console/invoices/list/draft') }}">
              <span
                class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-checklist" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9.615 20h-2.615a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8" /><path d="M14 19l2 2l4 -4" /><path d="M9 8h4" /><path d="M9 12h2" /></svg>
              </span>
              <span class="nav-link-title">
                Invoices
              </span>
            </a>
          </li>
          @endif

          <li class="nav-item">
            <a class="nav-link" href="{{ url('/console/ticket/list/open') }}">
              <span
                class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-ticket" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 5l0 2" /><path d="M15 11l0 2" /><path d="M15 17l0 2" /><path d="M5 5h14a2 2 0 0 1 2 2v3a2 2 0 0 0 0 4v3a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-3a2 2 0 0 0 0 -4v-3a2 2 0 0 1 2 -2" /></svg>
              </span>
              <span class="nav-link-title">
                Ticket
              </span>
            </a>
          </li>

          @if((session('role_id') == 3 || session('role_id') == 7) && session('company_id') == 1)
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/console/redem/queue') }}">
              <span
                class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-hexagonal-prism"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20.792 6.996l-3.775 2.643a2.005 2.005 0 0 1 -1.147 .361h-7.74c-.41 0 -.81 -.126 -1.146 -.362l-3.774 -2.641" /><path d="M8 10v11" /><path d="M16 10v11" /><path d="M3.853 18.274l3.367 2.363a2 2 0 0 0 1.147 .363h7.265c.41 0 .811 -.126 1.147 -.363l3.367 -2.363c.536 -.375 .854 -.99 .854 -1.643v-9.262c0 -.655 -.318 -1.268 -.853 -1.643l-3.367 -2.363a2 2 0 0 0 -1.147 -.363h-7.266c-.41 0 -.811 .126 -1.147 .363l-3.367 2.363a2.006 2.006 0 0 0 -.853 1.644v9.261c0 .655 .318 1.269 .853 1.644z" /></svg>
              </span>
              <span class="nav-link-title">
                Redem
              </span>
            </a>
          </li>
          @endif


          @if(session('role_id') == 3 || session('role_id') == 1 || session('role_id') == 6 || session('role_id') == 7)
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/console/customer/active') }}">
              <span
                class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-user-square-rounded"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 13a3 3 0 1 0 0 -6a3 3 0 0 0 0 6z" /><path d="M12 3c7.2 0 9 1.8 9 9s-1.8 9 -9 9s-9 -1.8 -9 -9s1.8 -9 9 -9z" /><path d="M6 20.05v-.05a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v.05" /></svg>
              </span>
              <span class="nav-link-title">
                Customer
              </span>
            </a>
          </li>
          @endif

          @if(session('role_id') == 3 || session('role_id') == 4 || session('role_id') == 7)
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/console/request-deposit') }}">
              <span
                class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-checklist" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9.615 20h-2.615a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8" /><path d="M14 19l2 2l4 -4" /><path d="M9 8h4" /><path d="M9 12h2" /></svg>
              </span>
              <span class="nav-link-title">
                Deposit
              </span>
            </a>
          </li>
          @endif

          <!--
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/console/customer') }}">
              <span
                class="nav-link-icon d-md-none d-lg-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /><path d="M16 3.13a4 4 0 0 1 0 7.75" /><path d="M21 21v-2a4 4 0 0 0 -3 -3.85" /></svg>
              </span>
              <span class="nav-link-title">
                Customer
              </span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/console/subscription') }}">
              <span
                class="nav-link-icon d-md-none d-lg-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-list-details" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M13 5h8" /><path d="M13 9h5" /><path d="M13 15h8" /><path d="M13 19h5" /><path d="M3 4m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" /><path d="M3 14m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" /></svg>
              </span>
              <span class="nav-link-title">
                Subscription
              </span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/console/product') }}">
              <span
                class="nav-link-icon d-md-none d-lg-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-frustum" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18.402 5.508l2.538 10.158a1.99 1.99 0 0 1 -1.064 2.278l-7.036 3.366a1.945 1.945 0 0 1 -1.682 0l-7.035 -3.365a1.99 1.99 0 0 1 -1.064 -2.278l2.539 -10.159a1.98 1.98 0 0 1 1.11 -1.328l4.496 -2.01a1.95 1.95 0 0 1 1.59 0l4.496 2.01c.554 .246 .963 .736 1.112 1.328z" /><path d="M18 4.82l-5.198 2.324a1.963 1.963 0 0 1 -1.602 0l-5.2 -2.325" /><path d="M12 7.32v14.18" /></svg>
              </span>
              <span class="nav-link-title">
                Products
              </span>
            </a>
          </li>
          -->
        </ul>
      </div>
    </div>
  </div>
</header>


<script type="text/javascript">

    $(document).ready(function() {

      $('.icn-notif').click(function() {
        $.get("{{ route('read_notif') }}");
      })

    })

</script>
