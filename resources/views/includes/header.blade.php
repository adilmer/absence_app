<header class="app-header " style="position: relative">
<nav class="navbar navbar-light container bg-white">
      <div class="container">
        <a href="{{route('home.index')}}" class="text-nowrap logo-img">
          <img src="{{asset('assets/images/logos/ministry-logo-ar.png')}}" width="80%" class="p-1" alt="" />
        </a>
        <p class="p-2 text-muted m-2">
            <span>الأكاديمية الجهوية: <span>{{App\Models\Information::where('status_info',1)->first()->academie ?? ''}}</span></span><br>
            <span>المديرية الإقليمية : <span>{{App\Models\Information::where('status_info',1)->first()->direction ?? ''}}</span></span><br>
        </p>
        <p class="p-2 text-muted m-2 h5">
            <span>المؤسسة : <span>{{App\Models\Information::where('status_info',1)->first()->etablissement ?? ''}}</span></span><br>
        </p>
        <p class="p-2 text-muted m-2">
            <span>السنة الدراسية : <span>{{App\Models\Session::where('status_session',1)->first()->nom_session ?? ''}}</span></span><br>
        </p>
        <form class="d-flex">
          <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
            <li class="nav-item">
              <a class="nav-link nav-icon-hover" href="javascript:void(0)">
                <i class="ti ti-bell-ringing"></i>
                <div class="notification bg-primary rounded-circle"></div>
              </a>

            </li>
            <li class="nav-item dropdown mx-5">
              <a class="nav-link nav-icon-hover"  href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
                aria-expanded="false">
                <img src="{{asset('assets/images/profile/user-1.png')}}" alt="" width="50" height="auto" class="rounded-circle">

              </a>
              <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                <div class="message-body ">
                  <a href="javascript:void(0)"  class="d-flex align-items-center gap-2 dropdown-item disabled">
                    <i class="ti ti-user fs-6"></i>
                    <p class="mb-0 fs-3 text-uppercase">{{Auth::user()->name ?? ''}}</p>
                  </a>


<hr>

                  <a  data-bs-toggle="modal" data-bs-target="#modal-profile"  class="btn btn-outline-dark btn-sm  mt-2 d-block border-0 mx-2"><i class="ti ti-settings fs-6"></i> الإعدادات العامة</a>
                  <a href="{{route('logout')}}"  class="btn btn-outline-danger btn-sm  mt-2 d-block border-0 mx-2"><i class="ti ti-lock fs-6"></i> تسجيل الخروج</a>
                </div>
              </div>
            </li>
          </ul>
        </form>
      </div>
    </nav>
  </header>


