<!DOCTYPE html>
<html>
<head>
    <title>ورقة الإذن بالدخول </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/favicon.png') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@500&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.3/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>

    <style>
        @media print {
            .noPrint {
                display: none;
            }

            @php
                       $settings = DB::table('settings')->first();
                        $colors = explode(",",$settings->colors);
            @endphp

            @page {

                size: {{$settings->w_paper ?? 105}} mm {{$settings->h_paper ?? 74}} mm;
                margin: 0px;
            }
            
            body {
                margin: 0px;
            }
            p,li{
                font-size: 2vh;
                margin-bottom: 1px;
            }
            h5{
                font-size: 5vh;
            }
            h6{
                font-size: 4vh;
                line-height: 20px;
        }
    </style>
    <script>
        @if ($print)

            window.print();

        @endif
        window.addEventListener('afterprint', function() {
                history.back();
                 });
    </script>
</head>
<body style="direction: rtl " >
    <div class="container mt-4 " id="print_zone">

        <div class="row p-1 m-auto col-12 border">
            <div class="col-12">
                <p>الأكاديمية : {{$information->academie}}
                    <span style="float: left ">السنة الدراسية : {{$information->session->nom_session}}</span>
                </p>
                <p>المؤسسة : {{$information->etablissement}}</p>

                <h5 class="text-center col-12 p-2 mt-3 bg-light text-bold border border-cercle">ورقة السماح بالدخول</h5>
                <div class="mx-auto my-3 text-bolder">
                <p>يسمح للتلميذ(ة) : <span class="text-bold mx-2"> {{$eleve->nom_ar}} {{$eleve->prenom_ar}} </span></p>
                <p>مـن قــســم : <span class="text-bold mx-4"> مستوى {{$eleve->classe->nom_classe_ar}} ({{$eleve->classe->nom_classe_fr}}) </span> </p>
                <p>باستئناف الدراسة  : <span class="text-bold mx-2">يوم : {{$dateB}} ، <span></span> على الساعة : <span class="text-bold"> {{$timeB}} </span></span></p>
                <p> بـعـد تـبـريــر : <span class="text-bold mx-4"> {{$motif}} </span> </p>
                <div class="border p-2 col-12">
                <p>سجل الغياب :</p>
                    <ul>
                        <li  style="list-style-type: square;" class="mx-5">مجموع ساعات الغياب  : <span class="text-bold mx-5"><span> مبررة : </span>{{str_pad($absences->where('status_absence','>',1)->sum('total_seances'), 2, '0', STR_PAD_LEFT)}}</span>
                    <span class="text-bold "> <span>غير مبررة : </span>{{str_pad($absences->where('status_absence',1)->sum('total_seances'), 2, '0', STR_PAD_LEFT)}}</span></li>
                        <li style="list-style-type: square;" class="mx-5">مجمـــوع أيــــــام الغيــــاب  : <span class="text-bold mx-5"><span> مبررة : </span>{{str_pad($absences->where('status_absence','>',1)->sum('total_jours'), 2, '0', STR_PAD_LEFT)}}</span>
                    <span class="text-bold "> <span>غير مبررة : </span>{{str_pad($absences->where('status_absence',1)->sum('total_jours'), 2, '0', STR_PAD_LEFT)}}</span></li>
                    </ul>




                </div>
            </div>
        </div>
        @if (!$print)
        <button class="btn btn-danger noPrint col-2 mx-auto" onclick="window.print()">طباعة</button>
        @endif
    </div>
</body>
</html>
