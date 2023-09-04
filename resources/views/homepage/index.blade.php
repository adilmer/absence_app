@extends('templates.site')
@section('content')
    @php
        $settings = DB::table('settings')->where('id_user',Auth::user()->id)->first();
    @endphp
    <div class="row ">
        <div class="container">
            <div class="row col-12 mx-auto">
                <div class="col-md-6">
                    <div class="card ">
                        <div class="card-header bg-primary text-white">توزيع التلاميذ حسب المستوى</div>

                        <div class="card-body col-6 mx-auto bg-white px-1 py-3">


                            {!! $chart1->renderHtml() !!}

                        </div>

                    </div>
                </div>
                @php
                    $num_ar = ['الأول','الثاني','الثالث','الرابع','الخامس','السادس']
                @endphp
                @foreach ($chart2 as $key=>$chart)
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-primary text-white">توزيع التلاميذ حسب القسم بالنسبة للمستوى {{$num_ar[$key]}} </div>

                        <div class="card-body bg-white p-16">


                            {!! $chart->renderHtml() !!}

                        </div>

                    </div>
                </div>
                 @endforeach

            </div>
            <div class="row col-12 mx-auto">
                <div class="col-md-6">
                    <div class="card ">
                        <div class="card-header bg-success text-white"> التلاميذ الأكثر تغيبا (أيام غير مبررة) </div>

                        <div class="card-body col-11 mx-auto bg-white px-1 py-3">
                            <div class="table-responsive">
                                <table class="table table-bordered  text-center text-nowrap mb-0 align-middle col-11 mx-auto">
                                    <thead class="text-dark fs-4 table-info">
                                        <tr>
                                            <th class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0">إسم التلميذ</h6>
                                            </th>
                                            <th class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0">المستوى والقسم</h6>
                                            </th>
                                            <th class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0">عدد الأيام غير المبررة</h6>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($top_absent_eleves->count() != 0)
                                        @foreach ($top_absent_eleves as $eleve)
                                            <tr>
                                                <td class="border-bottom-0">
                                                    <h6 class="fw-semibold mb-1"><a
                                                            href="{{ route('eleve.details', $eleve->id_eleve) }}">
                                                            {{ $eleve->nom_ar }} {{ $eleve->prenom_ar }} </a></h6>
                                                    <span class="fw-normal"> {{ $eleve->nom_fr }} {{ $eleve->prenom_fr }}
                                                    </span>
                                                </td>
                                                @php
                                                $classe = DB::table('classes')->where('id_classe',$eleve->id_classe)->first();
                                            @endphp
                                            <td class="border-bottom-0">
                                                <h6 class="fw-semibold mb-1">
                                                    {{ $classe->nom_classe_ar ?? ''}} ({{$classe->nom_classe_fr ?? ''}})</h6>
                                            </td>
                                                <td class="border-bottom-0">
                                                    <p
                                                        class="mb-0 h3 top-0 start-100 badge rounded-pill {{ $eleve->total_days > 2 ? 'bg-danger' : 'bg-warning' }} ">
                                                        {{ $eleve->total_days }}</p>
                                                </td>
                                            </tr>
                                            @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="2">
                                                        <p class="fw-semibold mb-1 text-muted"> لا يوجد من التلاميذ من تجاوز
                                                            عتبة {{$settings->nbr_jour_limit}} من الأيام <br> من الغياب غير مبرر على الأقل</p>
                                                    </td>
                                                </tr>
                                            @endif
                                    </tbody>
                                </table>
                            </div>
                            <!--  pagination links -->
                            <div id="paginate" class="d-flex justify-content-center">
                                <span class="custom-pagination">
                                    {{ $top_absent_eleves->links() }}
                                </span>
                            </div>


                        </div>

                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-success text-white"> التلاميذ الأكثر تغيبا (ساعات غير مبررة باحتساب الحصص المكملة لليوم) </div>

                        <div class="card-body col-11 mx-auto bg-white px-1 py-3">
                            <div class="table-responsive">
                                <table class="table table-bordered  text-center text-nowrap mb-0 align-middle col-11 mx-auto">
                                    <thead class="text-dark fs-4 table-info">
                                        <tr>
                                            <th class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0">إسم التلميذ</h6>
                                            </th>
                                            <th class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0">المستوى والقسم</h6>
                                            </th>
                                            <th class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0">عدد الساعات غير المبررة</h6>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($top_absent_eleves_seance->count() != 0)
                                            @foreach ($top_absent_eleves_seance as $eleve)
                                                <tr>
                                                    <td class="border-bottom-0">
                                                        <h6 class="fw-semibold mb-1"><a
                                                                href="{{ route('eleve.details', $eleve->id_eleve) }}">
                                                                {{ $eleve->nom_ar }} {{ $eleve->prenom_ar }} </a></h6>
                                                        <span class="fw-normal"> {{ $eleve->nom_fr }}
                                                            {{ $eleve->prenom_fr }}
                                                        </span>
                                                    </td>
                                                    @php
                                                        $classe = DB::table('classes')->where('id_classe',$eleve->id_classe)->first();
                                                    @endphp
                                                    <td class="border-bottom-0">
                                                        <h6 class="fw-semibold mb-1">
                                                            {{ $classe->nom_classe_ar ?? ''}} ({{$classe->nom_classe_fr ?? ''}})</h6>
                                                    </td>
                                                    <td class="border-bottom-0">
                                                        <p
                                                            class="mb-0 h3 top-0 start-100 badge rounded-pill {{ $eleve->total_seances > 5 ? 'bg-danger' : 'bg-warning' }} ">
                                                            {{ $eleve->total_seances }}</p>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="3">
                                                    <p class="fw-semibold mb-1 text-muted"> لا يوجد من التلاميذ من تجاوز
                                                        عتبة {{$settings->nbr_seance_limit}} من الحصص <br> من الغياب  غير مبرر على الأقل</p>
                                                </td>
                                            </tr>
                                        @endif

                                    </tbody>
                                </table>
                            </div>
                            <!--  pagination links -->
                            <div id="paginate" class="d-flex justify-content-center">
                                <span class="custom-pagination">
                                    {{ $top_absent_eleves->links() }}
                                </span>
                            </div>


                        </div>

                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header bg-success text-white"> (ساعات مبررة و غير مبررة باحتساب الحصص المكملة لليوم) نسبة الغياب حسب القسم  </div>

                        <div class="card-body col-11 mx-auto bg-white px-1 py-3">
                            <div class="table-responsive">
                                <table class="table table-bordered  text-center text-nowrap mb-0 align-middle col-11 mx-auto">
                                @foreach ($absence_data_array as $key => $absences)
                                    <tbody>
                                    <tr class="table table-light">
                                            <th class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0">{{ $key}}</h6>
                                            </th>
                                            <th class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0">عدد الحصص </h6>
                                            </th>

                                        </tr>
                                        @foreach ($absences as $absence)

                                                <tr>
                                                    <td class="border-bottom-0">
                                                        <h6 class="fw-semibold mb-1">
                                                                {{ $absence['nom_classe_fr']}} </h6>
                                                    </td>
                                                    <td class="border-bottom-0">
                                                        <p
                                                            class="mb-0 h3 top-0 start-100 badge rounded-pill bg-warning">
                                                            {{ $absence['nombre_seances']}}</p>
                                                    </td>
                                                </tr>

                                                @endforeach
                                    </tbody>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card ">
                        <div class="card-header bg-success text-white">توزيع الغياب حسب المبرر</div>

                        <div class="card-body col-8 mx-auto bg-white px-1 py-3">


                            {!! $chart3->renderHtml() !!}

                        </div>

                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-success text-white">تطور الغياب حسب {{$settings->periode_jours}} يوم</div>

                        <div class="card-body bg-white p-1">


                            {!! $chart4->renderHtml() !!}

                        </div>

                    </div>
                </div>


            </div>
            </div>
        </div>
        {!! $chart1->renderChartJsLibrary() !!}
        {!! $chart1->renderJs() !!}
        @foreach ($chart2 as $chart)
        {!! $chart->renderChartJsLibrary() !!}
        {!! $chart->renderJs() !!}
        @endforeach
        {!! $chart3->renderChartJsLibrary() !!}
        {!! $chart3->renderJs() !!}

        {!! $chart4->renderChartJsLibrary() !!}
        {!! $chart4->renderJs() !!}

        <!--  Row 1 -->
        <div class="row  col-md-12 mx-3">
            <div class="card-header bg-success text-white h5 text-center"> تواريخ مهمة </div>
            <div class="col-lg-4 card-body d-flex align-items-strech ">
                <div class="  align-items-center ">
                    <div class="">
                        <div class="">
                            <header>
                                <p class="current-date text-center"></p>
                                <div class="icons">
                                </div>
                            </header>
                            <div class="calendar p-0 m-0">
                                <ul class="weeks">
                                    <li>أح</li>
                                    <li>إث</li>
                                    <li>ث</li>
                                    <li>أر</li>
                                    <li>خ</li>
                                    <li>ج</li>
                                    <li>س</li>
                                </ul>
                                <ul class="days"></ul>
                            </div>
                        </div>

                    </div>
                </div>
            </div>


            <div class="col-lg-4">
                <div class="">
                    <div class="card-body">
                        <div class="mb-3 mb-sm-0">
                            <h5 class="card-title fw-semibold">قائمة العطل الوطنية لموسم {{App\Models\Session::where('status_session',1)->first()->nom_session ?? ''}}</h5>
                        </div>
                        <div class="table">
                            <table class="table table-sm text-nowrap mb-0 align-middle">
                                <thead class="text-dark fs-4 table-primary">
                                </thead>
                                <tbody>
                                    <tr
                                        class="{{ now()->addDay()->format('d/m/Y') =='01/01/' . date('Y')? 'bg-success': '' }}">
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-1">رأس السنة الميلادية</h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            @php
                                                $date1 = Carbon\Carbon::createFromFormat('d-m-Y', now()->format('d-m-Y'));
                                                $date2 = Carbon\Carbon::createFromFormat('d-m-Y', '01-01-' . now()->format('Y'));

                                            @endphp
                                            <p class="mb-0 fw-normal">{{ $date2 ->gte($date1) ? $date2->format('d/m/Y') : $date2->addYear()->format('d/m/Y') }}</p>
                                        </td>
                                        <td class="border-bottom-0">
                                            <p class="mb-0 fw-normal">يوم واحد</p>
                                        </td>
                                    </tr>
                                    <tr
                                        class="{{ now()->addDay()->format('d/m/Y') =='11/01/' . date('Y')? 'bg-success': '' }}">
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-1">تقديم وثيقة الاستقلال</h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            @php
                                                $date1 = Carbon\Carbon::createFromFormat('d-m-Y', now()->format('d-m-Y'));
                                                $date2 = Carbon\Carbon::createFromFormat('d-m-Y', '11-01-' . now()->format('Y'));

                                            @endphp
                                            <p class="mb-0 fw-normal">{{ $date2 ->gte($date1) ? $date2->format('d/m/Y') : $date2->addYear()->format('d/m/Y') }}</p>
                                        </td>
                                        <td class="border-bottom-0">
                                            <p class="mb-0 fw-normal">يوم واحد</p>
                                        </td>
                                    </tr>
                                    <tr
                                        class="{{ now()->addDay()->format('d/m/Y') =='01/05/' . date('Y')? 'bg-success': '' }}">
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-1">عيد الشغل</h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            @php
                                                $date1 = Carbon\Carbon::createFromFormat('d-m-Y', now()->format('d-m-Y'));
                                                $date2 = Carbon\Carbon::createFromFormat('d-m-Y', '01-05-' . now()->format('Y'));

                                            @endphp
                                            <p class="mb-0 fw-normal">{{ $date2 ->gte($date1) ? $date2->format('d/m/Y') : $date2->addYear()->format('d/m/Y') }}</p>
                                        </td>
                                        <td class="border-bottom-0">
                                            <p class="mb-0 fw-normal">يوم واحد</p>
                                        </td>
                                    </tr>
                                    <tr
                                        class="{{ now()->addDay()->format('d/m/Y') =='30/07/' . date('Y')? 'bg-success': '' }}">
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-1">عيد العرش</h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            @php
                                                $date1 = Carbon\Carbon::createFromFormat('d-m-Y', now()->format('d-m-Y'));
                                                $date2 = Carbon\Carbon::createFromFormat('d-m-Y', '30-07-' . now()->format('Y'));

                                            @endphp
                                            <p class="mb-0 fw-normal">{{ $date2 ->gte($date1) ? $date2->format('d/m/Y') : $date2->addYear()->format('d/m/Y') }}</p>
                                        </td>
                                        <td class="border-bottom-0">
                                            <p class="mb-0 fw-normal">يوم واحد</p>
                                        </td>
                                    </tr>
                                    <tr
                                        class="{{ now()->addDay()->format('d/m/Y') =='14/08/' . date('Y')? 'bg-success': '' }}">
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-1">ذكرى استرجاع وادي الذهب</h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            @php
                                                $date1 = Carbon\Carbon::createFromFormat('d-m-Y', now()->format('d-m-Y'));
                                                $date2 = Carbon\Carbon::createFromFormat('d-m-Y', '14-08-' . now()->format('Y'));

                                            @endphp
                                            <p class="mb-0 fw-normal">{{ $date2 ->gte($date1) ? $date2->format('d/m/Y') : $date2->addYear()->format('d/m/Y') }}</p>
                                        </td>
                                        <td class="border-bottom-0">
                                            <p class="mb-0 fw-normal">يوم واحد</p>
                                        </td>
                                    </tr>
                                    <tr
                                        class="{{ now()->addDay()->format('d/m/Y') =='20/08/' . date('Y')? 'bg-success': '' }}">
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-1">ذكرى ثورة الملك والشعب</h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            @php
                                                $date1 = Carbon\Carbon::createFromFormat('d-m-Y', now()->format('d-m-Y'));
                                                $date2 = Carbon\Carbon::createFromFormat('d-m-Y', '20-08-' . now()->format('Y'));

                                            @endphp
                                            <p class="mb-0 fw-normal">{{ $date2 ->gte($date1) ? $date2->format('d/m/Y') : $date2->addYear()->format('d/m/Y') }}</p>
                                        </td>
                                        <td class="border-bottom-0">
                                            <p class="mb-0 fw-normal">يوم واحد</p>
                                        </td>
                                    </tr>
                                    <tr
                                        class="{{ now()->addDay()->format('d/m/Y') =='21/08/' . date('Y')? 'bg-success': '' }}">
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-1">عيد الشباب</h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            @php
                                                $date1 = Carbon\Carbon::createFromFormat('d-m-Y', now()->format('d-m-Y'));
                                                $date2 = Carbon\Carbon::createFromFormat('d-m-Y', '21-08-' . now()->format('Y'));

                                            @endphp
                                            <p class="mb-0 fw-normal">{{ $date2 ->gte($date1) ? $date2->format('d/m/Y') : $date2->addYear()->format('d/m/Y') }}</p>
                                        </td>
                                        <td class="border-bottom-0">
                                            <p class="mb-0 fw-normal">يوم واحد</p>
                                        </td>
                                    </tr>
                                    <tr
                                        class="{{ now()->addDay()->format('d/m/Y') =='06/11/' . date('Y')? 'bg-success': '' }}">
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-1">ذكرى المسيرة الخضراء</h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            @php
                                                $date1 = Carbon\Carbon::createFromFormat('d-m-Y', now()->format('d-m-Y'));
                                                $date2 = Carbon\Carbon::createFromFormat('d-m-Y', '06-11-' . now()->format('Y'));

                                            @endphp
                                            <p class="mb-0 fw-normal">{{ $date2 ->gte($date1) ? $date2->format('d/m/Y') : $date2->addYear()->format('d/m/Y') }}</p>
                                        </td>
                                        <td class="border-bottom-0">
                                            <p class="mb-0 fw-normal">يوم واحد</p>
                                        </td>
                                    </tr>
                                    <tr
                                        class="{{ now()->addDay()->format('d/m/Y') =='18/11/' . date('Y')? 'bg-success': '' }}">
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-1">عيد الاستقلال</h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            @php
                                                $date1 = Carbon\Carbon::createFromFormat('d-m-Y', now()->format('d-m-Y'));
                                                $date2 = Carbon\Carbon::createFromFormat('d-m-Y', '18-11-' . now()->format('Y'));

                                            @endphp
                                            <p class="mb-0 fw-normal">{{ $date2 ->gte($date1) ? $date2->format('d/m/Y') : $date2->addYear()->format('d/m/Y') }}</p>
                                        </td>
                                        <td class="border-bottom-0">
                                            <p class="mb-0 fw-normal">يوم واحد</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="">
                    <div class="card-body">
                        <div class="mb-3 mb-sm-0">
                            <h5 class="card-title fw-semibold">قائمة العطل الدينية  </h5>
                        </div>
                        <div class="table">
                            <table class="table table-sm text-nowrap mb-0 align-middle">
                                <thead class="text-dark fs-4 table-primary">
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-1">رأس السنة الهجرية</h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <p class="mb-0 fw-normal">فاتح محرم</p>
                                        </td>
                                        <td class="border-bottom-0">
                                            <p class="mb-0 fw-normal">يوم واحد</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-1">  عيد المولد النبوي</h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <p class="mb-0 fw-normal"> 12 ربيع الأول</p>
                                        </td>
                                        <td class="border-bottom-0">
                                            <p class="mb-0 fw-normal">يومين </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-1"> عيد الفطر </h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <p class="mb-0 fw-normal"> فاتح شوال</p>
                                        </td>
                                        <td class="border-bottom-0">
                                            <p class="mb-0 fw-normal">يوم واحد</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-1"> عيد الأضحى </h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <p class="mb-0 fw-normal">  10 ذو الحجة</p>
                                        </td>
                                        <td class="border-bottom-0">
                                            <p class="mb-0 fw-normal">4 أيام </p>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('script')
        const daysTag = document.querySelector(".days"),
        currentDate = document.querySelector(".current-date"),
        prevNextIcon = document.querySelectorAll(".icons span");

        let date = new Date(),
        currYear = date.getFullYear(),
        currMonth = date.getMonth();

        const months = ["يناير", "فبراير", "مارس", "ابريل", "ماي", "يونيو", "يوليوز",
        "غشت", "شتنبر", "أكتوبر", "نونبر", "دجنبر"];

        const renderCalendar = () => {
        let firstDayofMonth = new Date(currYear, currMonth, 1).getDay(),
        lastDateofMonth = new Date(currYear, currMonth + 1, 0).getDate(),
        lastDayofMonth = new Date(currYear, currMonth, lastDateofMonth).getDay(),
        lastDateofLastMonth = new Date(currYear, currMonth, 0).getDate();
        let liTag = "";

        for (let i = firstDayofMonth; i > 0; i--) {
        liTag += `<li class="inactive">${lastDateofLastMonth - i + 1}</li>`;
        }

        for (let i = 1; i <= lastDateofMonth; i++) { let isToday=i===date.getDate() && currMonth===new Date().getMonth() &&
            currYear===new Date().getFullYear() ? "active" : "" ; liTag +=`<li class="${isToday}">${i}</li>`;
            }

            for (let i = lastDayofMonth; i < 6; i++) { liTag +=`<li class="inactive">${i - lastDayofMonth + 1}</li>`
                }
                currentDate.innerText = `${months[currMonth]} ${currYear}`;
                daysTag.innerHTML = liTag;
                }
                renderCalendar();

                prevNextIcon.forEach(icon => {
                icon.addEventListener("click", () => {
                currMonth = icon.id === "prev" ? currMonth - 1 : currMonth + 1;

                if(currMonth < 0 || currMonth> 11) {
                    date = new Date(currYear, currMonth);
                    currYear = date.getFullYear();
                    currMonth = date.getMonth();
                    } else {
                    date = new Date();
                    }
                    renderCalendar();
                    });
                    });
                @endsection
