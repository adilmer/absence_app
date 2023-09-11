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


            <li class="nav-item dropdown mx-5">
                <a class="nav-link nav-icon-hover" id="liveToastBtn" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
                  aria-expanded="false">
                  <i class="ti ti-bell"></i>
                  <div class="badge bg-warning p-1  rounded-circle"  style="font-size: 10pt;width: 17px;height: 20px; position:absolute;right:10px;top:10px">{{App\Models\Notification::where('status_notif',0)->count()}}</div>
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
                  <a href="{{route('home.change_password')}}"  class="btn btn-outline-info btn-sm  mt-2 d-block border-0 mx-2"><i class="ti ti-unlock fs-6"></i> تغيير كلمة المرور</a>
                  <a href="{{route('logout')}}"  class="btn btn-outline-danger btn-sm  mt-2 d-block border-0 mx-2"><i class="ti ti-lock fs-6"></i> تسجيل الخروج</a>
                </div>
              </div>
            </li>
          </ul>
        </form>
      </div>
    </nav>
  </header>
  <div class="toast-container position-fixed top-0 start-0 p-3 " style="margin-top: 4%;margin-left:15%">
    @foreach (App\Models\Notification::where('status_notif',0)->get() as $notif)
    <div id="liveToast" class="toast liveToast m-0"  role="alert" aria-live="assertive" aria-atomic="true">
        <form action="{{route('home.read_notification')}}" method="post">
            @csrf
        <input type="hidden" name="id_notif" value="{{$notif->id_notif}}">
        <div class="toast-header title">{{$notif->titre_notif}}</div>
        <div class="toast-body">
          {{$notif->message_notif}}
          <div class="mt-2 pt-2 border-top">
            <button type="submit" class="btn btn-primary btn-sm">تحديد كمقروء</button>
            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="toast">اخفاء </button>
          </div>
        </div>
    </form>
      </div>

    @endforeach
</div>

  <script>
    const toastTrigger = document.getElementById('liveToastBtn')
const toastLiveExample = document.getElementsByClassName('liveToast')
if (toastTrigger) {
  toastTrigger.addEventListener('click', () => {
    for (let index = 0; index < toastLiveExample.length; index++) {
        const toast = new bootstrap.Toast(toastLiveExample[index])
        toast.show()
    }



  })
}
  </script>

