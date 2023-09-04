<nav class="sidebar-nav scroll-sidebar container " style="z-index: 555;position:relative;">
    <ul id="sidebarnav" class="py-2">
        <li class="nav-small-cap">
            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
        </li>
        <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('home.index') }}" aria-expanded="false">
                <span>
                    <i class="ti ti-layout-dashboard"></i>
                </span>
                <span class="hide-menu"> الرئيسية</span>
            </a>
        </li>
        <li class="nav-small-cap">
            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
        </li>
        <li class="sidebar-item">
            <a class="sidebar-link" href="#1" data-bs-toggle="dropdown">"
                <span>
                    <i class="ti ti-school"></i>
                </span>
                <span class="hide-menu">تتبع التلاميذ</span>
            </a>
            <ul class="dropdown-menu text-end">
                <li> <a class="dropdown-item" href="{{ route('eleve.index') }}">لائحة التلاميذ </a></li>
            </ul>
        </li>
        <li class="nav-small-cap">
            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
        </li>
        <li class="sidebar-item">
            <a class="sidebar-link" href="#1" data-bs-toggle="dropdown">"
                <span>
                    <i class="ti ti-user"></i>
                </span>
                <span class="hide-menu">تتبع زيارات الولي </span>
            </a>
            <ul class="dropdown-menu text-end">
                <li> <a class="dropdown-item disabled" href="#11"> لائحة زيارات الولي (في طور الإعداد) </a></li>
            </ul>
        </li>
        <li class="nav-small-cap">
            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
        </li>
        <li class="sidebar-item">
            <a class="sidebar-link" href="#2" data-bs-toggle="dropdown">
                <span>
                    <i class="ti ti-user-check"></i>
                </span>
                <span class="hide-menu">تتبع الغـيــــاب</span>
            </a>
            <ul class="dropdown-menu text-end">
                <li> <a class="dropdown-item" href="{{ route('absence.index') }}"> تسجيل الغـيـاب </a></li>
                <li> <a class="dropdown-item" href="{{ route('absence.absence_collective') }}"> ورقة الدخول الجماعية
                    </a></li>
                    <li> <a class="dropdown-item" href="{{ route('absence.liste_absence') }}">تحميل ورقة الغياب  </a></li>
                    <li> <a class="dropdown-item disabled" href="#11">   تحميل الغياب الشهري (في طور الإعداد) </a></li>
            </ul>
        </li>
        <li class="nav-small-cap">
            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
        </li>
        <li class="sidebar-item  ">
            <a class="sidebar-link " href="#3" data-bs-toggle="dropdown">
                <span>
                    <i class="ti ti-heart"></i>
                </span>
                <span class="hide-menu">تتبع الوضع الصحي</span>
            </a>
            <ul class="dropdown-menu text-end">
                <li> <a class="dropdown-item disabled" href="#4"> لائحة الحالات الصحية (في طور الإعداد) </a></li>
                <li> <a class="dropdown-item disabled" href="#5">لائحة المعفيين من التربية البدنية (في طور الإعداد)
                    </a></li>
                <li> <a class="dropdown-item disabled" href="#6"> الشواهد الطبية (في طور الإعداد) </a></li>
            </ul>
        </li>
        <li class="nav-small-cap">
            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
        </li>
        <li class="sidebar-item ">
            <a class="sidebar-link " href="#7" data-bs-toggle="dropdown">
                <span>
                    <i class="ti ti-id-badge" ></i>
                </span>
                <span class="hide-menu">تتبع السلوك</span>
            </a>
            <ul class="dropdown-menu text-end">
                <li> <a class="dropdown-item disabled" href="#9"> لائحة المخالفات (في طور الإعداد) </a></li>
                <li> <a class="dropdown-item disabled" href="#0"> تقارير الأساتذة (في طور الإعداد) </a></li>
            </ul>
        </li>
        <li class="sidebar-item">
            <a class="sidebar-link" href="#8" data-bs-toggle="dropdown">
                <span>
                    <i class="ti ti-settings"></i>
                </span>
                <span class="hide-menu">الإعدادات </span>
            </a>
            <ul class="dropdown-menu text-end">
                <li> <a class="dropdown-item" href="{{ route('classe.index') }}"> اعداد الأقسام</a></li>
                <li> <a class="dropdown-item" href="{{ route('seance.index') }}"> اعداد الحصص الدراسية </a> </li>
                <li> <a class="dropdown-item" href="{{ route('motifAbsence.index') }}"> اعداد مبرر الغيـاب </a></li>
            </ul>
        </li>

        <li class="nav-small-cap">
            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
        </li>

    </ul>




</nav>
