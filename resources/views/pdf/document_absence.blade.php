<!DOCTYPE html>
<html>

<head>
    <title>ورقة الغياب الأسبوعية</title>
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

            @page {
                size: A4 Portrait;
            }

            body {
                margin: 0px;

            }
            .table>:not(caption)>*>td {
            font-size: 8pt;

        }


    }
        .page-break {
            page-break-before: always;
        }
        .table>:not(caption)>*>* {
            padding: 0;
            vertical-align: middle;
        }

        .table>:not(caption)>*>td {
            width: 15px;
            height: auto;
            border: 1px solid;

        }

        table>:not(caption)>*>.bg-gray {
            background-color: rgb(173, 173, 173);

        }

        table>:not(caption)>*>.br-right {

            border-right: 4px solid black;

        }

        table>:not(caption)>*>.br-right-o {

            border-right: 2px solid black;

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

<body style="direction: rtl ">
    <div class="m-3 " id="print_zone">

        <div class=" mx-auto ">
            <div class="col-12 row">
                <div class="col-4 my-auto" style="vertical-align: middle;">
                    <img src="{{ asset('assets/images/entete.jpg') }}" width="100%" alt="">
                </div>
                <div class="col-5">
                    <h3 class="text-center"> </h3>
                    <h3 class="text-center p-1" style="border: 2px solid">ورقة الغياب الأسبوعية</h3>
                    <h3 class="text-center"> </h3>
                </div>
                <div class="col-3 fs-1" style="line-height: 5px">
                    <p> <span class="bg-light">المستوى :</span> {{ $classe->nom_classe_ar }}</p>
                    <p> <span class="bg-light">القسم :</span> {{ $classe->nom_classe_fr }}</p>
                    <p> <span class="bg-light">المؤسسة :</span> {{ $information->etablissement }}</p>
                </div>
            </div>
        </div>
        <div class="">
            <table class="table table-bordered text-center" style="padding: 0">
                <thead></thead>
                <tbody>
                    <tr>
                        <td colspan="2">الأيام</td>
                        @php
                            // Get the current date
                            $currentDate = new DateTime();

                            // Calculate the start date of the current week (Sunday)
                            $startDate = clone $currentDate;
                            $startDate->modify('this week');

                            // Calculate the end date of the current week (Saturday)
                            $endDate = clone $currentDate;
                            $endDate->modify('this week');
                            $endDate->modify('+6 days');

                            // Define the Arabic day names and month names for Maroc format
                            $dayNames = ['الأحد', 'الاثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة', 'السبت'];

                            $monthNames = [
                                1 => 'يناير',
                                2 => 'فبراير',
                                3 => 'مارس',
                                4 => 'إبريل',
                                5 => 'مايو',
                                6 => 'يونيو',
                                7 => 'يوليوز',
                                8 => 'غشت',
                                9 => 'شتنبر',
                                10 => 'أكتوبر',
                                11 => 'نونبر',
                                12 => 'دجنبر',
                            ];

                            // Generate an array of dates for the current week in Maroc format
                            $datesOfWeek = [];
                            $currentDate = clone $startDate;

                            while ($currentDate <= $endDate) {
                                $dayName = $dayNames[(int) $currentDate->format('w')];
                                $day = $currentDate->format('d');
                                $month = $monthNames[(int) $currentDate->format('m')];
                                $year = $currentDate->format('Y');

                                $formattedDate = "$dayName $day $month $year";

                                $datesOfWeek[] = $formattedDate;

                                $currentDate->modify('+1 day');
                            }
                            // $datesOfWeek now contains the dates of the current week
                            //   dd($datesOfWeek);
                        @endphp

                        <td class="br-right" colspan="8">
                            {{ $datesOfWeek[0] }}</td>
                            <td class="br-right" colspan="8">
                                {{ $datesOfWeek[1] }}</td>
                                <td class="br-right" colspan="8">
                                    {{ $datesOfWeek[2] }}</td>
                    </tr>
                    <tr>
                        <td colspan="2">الفترات</td>
                        <td class="br-right" colspan="4">الصباح</td>
                        <td class="br-right-o" colspan="4">المساء</td>
                        <td class="br-right" colspan="4">الصباح</td>
                        <td class="br-right-o" colspan="4">المساء</td>
                        <td class="br-right" colspan="4">الصباح</td>
                        <td class="br-right-o" colspan="4">المساء</td>
                    </tr>
                    <tr>
                        <td colspan="2">الحصص</td>
                        @php
                            $seance = DB::table('seances')
                                ->where('id_classe', $classe->id_classe)
                                ->where('code_jours', 1)
                                ->first();
                        @endphp <td class="br-right {{ $seance->s1 == 0 ? 'bg-gray' : '' }}">1</td>
                            <td class="{{ $seance->s2 == 0 ? 'bg-gray' : '' }}">2</td>
                            <td class="{{ $seance->s3 == 0 ? 'bg-gray' : '' }}">3</td>
                            <td class="{{ $seance->s4 == 0 ? 'bg-gray' : '' }}">4</td>
                            <td class="br-right-o {{ $seance->s5 == 0 ? 'bg-gray' : '' }}">4</td>
                            <td class="{{ $seance->s6 == 0 ? 'bg-gray' : '' }}">2</td>
                            <td class="{{ $seance->s7 == 0 ? 'bg-gray' : '' }}">3</td>
                            <td class="{{ $seance->s8 == 0 ? 'bg-gray' : '' }}">4</td>
                            @php
                                $seance = DB::table('seances')
                                    ->where('id_classe', $classe->id_classe)
                                    ->where('code_jours', 2)
                                    ->first();
                            @endphp
                            <td class="br-right {{ $seance->s1 == 0 ? 'bg-gray' : '' }}">1</td>
                            <td class="{{ $seance->s2 == 0 ? 'bg-gray' : '' }}">2</td>
                            <td class="{{ $seance->s3 == 0 ? 'bg-gray' : '' }}">3</td>
                            <td class="{{ $seance->s4 == 0 ? 'bg-gray' : '' }}">4</td>
                            <td class="br-right-o {{ $seance->s5 == 0 ? 'bg-gray' : '' }}">1</td>
                            <td class="{{ $seance->s6 == 0 ? 'bg-gray' : '' }}">2</td>
                            <td class="{{ $seance->s7 == 0 ? 'bg-gray' : '' }}">3</td>
                            <td class="{{ $seance->s8 == 0 ? 'bg-gray' : '' }}">4</td>
                            @php
                                $seance = DB::table('seances')
                                    ->where('id_classe', $classe->id_classe)
                                    ->where('code_jours', 3)
                                    ->first();
                            @endphp
                            <td class="br-right {{ $seance->s1 == 0 ? 'bg-gray' : '' }}">1</td>
                            <td class="{{ $seance->s2 == 0 ? 'bg-gray' : '' }}">2</td>
                            <td class="{{ $seance->s3 == 0 ? 'bg-gray' : '' }}">3</td>
                            <td class="{{ $seance->s4 == 0 ? 'bg-gray' : '' }}">4</td>
                            <td class="br-right-o {{ $seance->s5 == 0 ? 'bg-gray' : '' }}">1</td>
                            <td class="{{ $seance->s6 == 0 ? 'bg-gray' : '' }}">2</td>
                            <td class="{{ $seance->s7 == 0 ? 'bg-gray' : '' }}">3</td>
                            <td class="{{ $seance->s8 == 0 ? 'bg-gray' : '' }}">4</td>
                    </tr>
                    {{-- <tr style="height: 60px">
                        <td colspan="2">المواد والقاعات</td>
                        @php
                            $seance = DB::table('seances')
                                ->where('id_classe', $classe->id_classe)
                                ->where('code_jours', 1)
                                ->first();
                        @endphp
                        <td class="br-right {{ $seance->s1 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s2 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s3 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s4 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="br-right-o {{ $seance->s5 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s6 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s7 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s8 == 0 ? 'bg-gray' : '' }}"></td>
                        @php
                            $seance = DB::table('seances')
                                ->where('id_classe', $classe->id_classe)
                                ->where('code_jours', 2)
                                ->first();
                        @endphp
                        <td class="br-right {{ $seance->s1 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s2 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s3 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s4 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="br-right-o {{ $seance->s5 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s6 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s7 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s8 == 0 ? 'bg-gray' : '' }}"></td>
                        @php
                            $seance = DB::table('seances')
                                ->where('id_classe', $classe->id_classe)
                                ->where('code_jours', 3)
                                ->first();
                        @endphp
                        <td class="br-right {{ $seance->s1 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s2 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s3 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s4 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="br-right-o {{ $seance->s5 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s6 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s7 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s8 == 0 ? 'bg-gray' : '' }}"></td>
                    </tr> --}}

                    @foreach ($eleves as $eleve)
                        <tr>
                            <td>{{ $eleve->num_eleve }}</td>
                            <td>{{ $eleve->nom_ar }} {{ $eleve->prenom_ar }}</td>
                            @php
                                $seance = DB::table('seances')
                                    ->where('id_classe', $eleve->id_classe)
                                    ->where('code_jours', 1)
                                    ->first();
                            @endphp
                            <td class="br-right {{ $seance->s1 == 0 ? 'bg-gray' : '' }}"></td>
                            <td class="{{ $seance->s2 == 0 ? 'bg-gray' : '' }}"></td>
                            <td class="{{ $seance->s3 == 0 ? 'bg-gray' : '' }}"></td>
                            <td class="{{ $seance->s4 == 0 ? 'bg-gray' : '' }}"></td>
                            <td class="br-right-o {{ $seance->s5 == 0 ? 'bg-gray' : '' }}"></td>
                            <td class="{{ $seance->s6 == 0 ? 'bg-gray' : '' }}"></td>
                            <td class="{{ $seance->s7 == 0 ? 'bg-gray' : '' }}"></td>
                            <td class="{{ $seance->s8 == 0 ? 'bg-gray' : '' }}"></td>
                            @php
                                $seance = DB::table('seances')
                                    ->where('id_classe', $eleve->id_classe)
                                    ->where('code_jours', 2)
                                    ->first();
                            @endphp
                            <td class="br-right {{ $seance->s1 == 0 ? 'bg-gray' : '' }}"></td>
                            <td class="{{ $seance->s2 == 0 ? 'bg-gray' : '' }}"></td>
                            <td class="{{ $seance->s3 == 0 ? 'bg-gray' : '' }}"></td>
                            <td class="{{ $seance->s4 == 0 ? 'bg-gray' : '' }}"></td>
                            <td class="br-right-o {{ $seance->s5 == 0 ? 'bg-gray' : '' }}"></td>
                            <td class="{{ $seance->s6 == 0 ? 'bg-gray' : '' }}"></td>
                            <td class="{{ $seance->s7 == 0 ? 'bg-gray' : '' }}"></td>
                            <td class="{{ $seance->s8 == 0 ? 'bg-gray' : '' }}"></td>
                            @php
                                $seance = DB::table('seances')
                                    ->where('id_classe', $eleve->id_classe)
                                    ->where('code_jours', 3)
                                    ->first();
                            @endphp
                            <td class="br-right {{ $seance->s1 == 0 ? 'bg-gray' : '' }}"></td>
                            <td class="{{ $seance->s2 == 0 ? 'bg-gray' : '' }}"></td>
                            <td class="{{ $seance->s3 == 0 ? 'bg-gray' : '' }}"></td>
                            <td class="{{ $seance->s4 == 0 ? 'bg-gray' : '' }}"></td>
                            <td class="br-right-o {{ $seance->s5 == 0 ? 'bg-gray' : '' }}"></td>
                            <td class="{{ $seance->s6 == 0 ? 'bg-gray' : '' }}"></td>
                            <td class="{{ $seance->s7 == 0 ? 'bg-gray' : '' }}"></td>
                            <td class="{{ $seance->s8 == 0 ? 'bg-gray' : '' }}"></td>
                        </tr>
                    @endforeach
                    <tr style="height: 60px">
                        <td colspan="2"> توقيع الأساتذة</td>
                        @php
                            $seance = DB::table('seances')
                                ->where('id_classe', $classe->id_classe)
                                ->where('code_jours', 1)
                                ->first();
                        @endphp
                        <td class="br-right {{ $seance->s1 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s2 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s3 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s4 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="br-right-o {{ $seance->s5 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s6 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s7 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s8 == 0 ? 'bg-gray' : '' }}"></td>
                        @php
                            $seance = DB::table('seances')
                                ->where('id_classe', $classe->id_classe)
                                ->where('code_jours', 2)
                                ->first();
                        @endphp
                        <td class="br-right {{ $seance->s1 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s2 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s3 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s4 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="br-right-o {{ $seance->s5 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s6 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s7 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s8 == 0 ? 'bg-gray' : '' }}"></td>
                        @php
                            $seance = DB::table('seances')
                                ->where('id_classe', $classe->id_classe)
                                ->where('code_jours', 3)
                                ->first();
                        @endphp
                        <td class="br-right {{ $seance->s1 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s2 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s3 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s4 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="br-right-o {{ $seance->s5 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s6 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s7 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s8 == 0 ? 'bg-gray' : '' }}"></td>
                    </tr>

                    <tr style="height: 50px">
                        <td colspan="2"> الموجهون إلى الإدارة</td>
                        <td class="br-right" colspan="8"></td>
                        <td class="br-right" colspan="8"></td>
                        <td class="br-right" colspan="8"></td>
                    </tr>

                </tbody>
            </table>


        </div>
                <p>ملاحظة : كل تلميذ تم تصحيح رقمه بالمبيض يعتبر غائبا ويوجه إلى الحراسة العامة</p>

    </div>


    </div>

    <div class="page-break"></div>
    <div class="m-3 " id="print_zone">

        <div class=" mx-auto ">
            <div class="col-12 row">
                <div class="col-4 my-auto" style="vertical-align: middle;">
                    <img src="{{ asset('assets/images/entete.jpg') }}" width="100%" alt="">
                </div>
                <div class="col-5">
                    <h3 class="text-center"> </h3>
                    <h3 class="text-center p-1" style="border: 2px solid">ورقة الغياب الأسبوعية</h3>
                    <h3 class="text-center"> </h3>
                </div>
                <div class="col-3 fs-1" style="line-height: 5px">
                    <p> <span class="bg-light">المستوى :</span> {{ $classe->nom_classe_ar }}</p>
                    <p> <span class="bg-light">القسم :</span> {{ $classe->nom_classe_fr }}</p>
                    <p> <span class="bg-light">المؤسسة :</span> {{ $information->etablissement }}</p>
                </div>
            </div>
        </div>
        <div class="">
            <table class="table table-bordered text-center" style="padding: 0">
                <thead></thead>
                <tbody>
                    <tr>
                        <td colspan="2">الأيام</td>


                        <td class="br-right" colspan="8">
                            {{ $datesOfWeek[3] }}</td>
                            <td class="br-right" colspan="8">
                                {{ $datesOfWeek[4] }}</td>
                                <td class="br-right" colspan="8">
                                    {{ $datesOfWeek[5] }}</td>
                    </tr>
                    <tr>
                        <td colspan="2">الفترات</td>
                        <td class="br-right" colspan="4">الصباح</td>
                        <td class="br-right-o" colspan="4">المساء</td>
                        <td class="br-right" colspan="4">الصباح</td>
                        <td class="br-right-o" colspan="4">المساء</td>
                        <td class="br-right" colspan="4">الصباح</td>
                        <td class="br-right-o" colspan="4">المساء</td>
                    </tr>
                    <tr>
                        <td colspan="2">الحصص</td>
                        @php
                            $seance = DB::table('seances')
                                ->where('id_classe', $classe->id_classe)
                                ->where('code_jours', 4)
                                ->first();
                        @endphp <td class="br-right {{ $seance->s1 == 0 ? 'bg-gray' : '' }}">1</td>
                            <td class="{{ $seance->s2 == 0 ? 'bg-gray' : '' }}">2</td>
                            <td class="{{ $seance->s3 == 0 ? 'bg-gray' : '' }}">3</td>
                            <td class="{{ $seance->s4 == 0 ? 'bg-gray' : '' }}">4</td>
                            <td class="br-right-o {{ $seance->s5 == 0 ? 'bg-gray' : '' }}">4</td>
                            <td class="{{ $seance->s6 == 0 ? 'bg-gray' : '' }}">2</td>
                            <td class="{{ $seance->s7 == 0 ? 'bg-gray' : '' }}">3</td>
                            <td class="{{ $seance->s8 == 0 ? 'bg-gray' : '' }}">4</td>
                            @php
                                $seance = DB::table('seances')
                                    ->where('id_classe', $classe->id_classe)
                                    ->where('code_jours', 5)
                                    ->first();
                            @endphp
                            <td class="br-right {{ $seance->s1 == 0 ? 'bg-gray' : '' }}">1</td>
                            <td class="{{ $seance->s2 == 0 ? 'bg-gray' : '' }}">2</td>
                            <td class="{{ $seance->s3 == 0 ? 'bg-gray' : '' }}">3</td>
                            <td class="{{ $seance->s4 == 0 ? 'bg-gray' : '' }}">4</td>
                            <td class="br-right-o {{ $seance->s5 == 0 ? 'bg-gray' : '' }}">1</td>
                            <td class="{{ $seance->s6 == 0 ? 'bg-gray' : '' }}">2</td>
                            <td class="{{ $seance->s7 == 0 ? 'bg-gray' : '' }}">3</td>
                            <td class="{{ $seance->s8 == 0 ? 'bg-gray' : '' }}">4</td>
                            @php
                                $seance = DB::table('seances')
                                    ->where('id_classe', $classe->id_classe)
                                    ->where('code_jours', 6)
                                    ->first();
                            @endphp
                            <td class="br-right {{ $seance->s1 == 0 ? 'bg-gray' : '' }}">1</td>
                            <td class="{{ $seance->s2 == 0 ? 'bg-gray' : '' }}">2</td>
                            <td class="{{ $seance->s3 == 0 ? 'bg-gray' : '' }}">3</td>
                            <td class="{{ $seance->s4 == 0 ? 'bg-gray' : '' }}">4</td>
                            <td class="br-right-o {{ $seance->s5 == 0 ? 'bg-gray' : '' }}">1</td>
                            <td class="{{ $seance->s6 == 0 ? 'bg-gray' : '' }}">2</td>
                            <td class="{{ $seance->s7 == 0 ? 'bg-gray' : '' }}">3</td>
                            <td class="{{ $seance->s8 == 0 ? 'bg-gray' : '' }}">4</td>
                    </tr>
                   {{--  <tr style="height: 60px">
                        <td colspan="2">المواد والقاعات</td>
                        @php
                            $seance = DB::table('seances')
                                ->where('id_classe', $classe->id_classe)
                                ->where('code_jours', 4)
                                ->first();
                        @endphp
                        <td class="br-right {{ $seance->s1 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s2 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s3 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s4 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="br-right-o {{ $seance->s5 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s6 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s7 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s8 == 0 ? 'bg-gray' : '' }}"></td>
                        @php
                            $seance = DB::table('seances')
                                ->where('id_classe', $classe->id_classe)
                                ->where('code_jours', 5)
                                ->first();
                        @endphp
                        <td class="br-right {{ $seance->s1 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s2 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s3 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s4 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="br-right-o {{ $seance->s5 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s6 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s7 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s8 == 0 ? 'bg-gray' : '' }}"></td>
                        @php
                            $seance = DB::table('seances')
                                ->where('id_classe', $classe->id_classe)
                                ->where('code_jours', 6)
                                ->first();
                        @endphp
                        <td class="br-right {{ $seance->s1 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s2 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s3 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s4 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="br-right-o {{ $seance->s5 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s6 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s7 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s8 == 0 ? 'bg-gray' : '' }}"></td>
                    </tr> --}}

                    @foreach ($eleves as $eleve)
                        <tr>
                            <td>{{ $eleve->num_eleve }}</td>
                            <td>{{ $eleve->nom_ar }} {{ $eleve->prenom_ar }}</td>
                            @php
                                $seance = DB::table('seances')
                                    ->where('id_classe', $eleve->id_classe)
                                    ->where('code_jours', 4)
                                    ->first();
                            @endphp
                            <td class="br-right {{ $seance->s1 == 0 ? 'bg-gray' : '' }}"></td>
                            <td class="{{ $seance->s2 == 0 ? 'bg-gray' : '' }}"></td>
                            <td class="{{ $seance->s3 == 0 ? 'bg-gray' : '' }}"></td>
                            <td class="{{ $seance->s4 == 0 ? 'bg-gray' : '' }}"></td>
                            <td class="br-right-o {{ $seance->s5 == 0 ? 'bg-gray' : '' }}"></td>
                            <td class="{{ $seance->s6 == 0 ? 'bg-gray' : '' }}"></td>
                            <td class="{{ $seance->s7 == 0 ? 'bg-gray' : '' }}"></td>
                            <td class="{{ $seance->s8 == 0 ? 'bg-gray' : '' }}"></td>
                            @php
                                $seance = DB::table('seances')
                                    ->where('id_classe', $eleve->id_classe)
                                    ->where('code_jours', 5)
                                    ->first();
                            @endphp
                            <td class="br-right {{ $seance->s1 == 0 ? 'bg-gray' : '' }}"></td>
                            <td class="{{ $seance->s2 == 0 ? 'bg-gray' : '' }}"></td>
                            <td class="{{ $seance->s3 == 0 ? 'bg-gray' : '' }}"></td>
                            <td class="{{ $seance->s4 == 0 ? 'bg-gray' : '' }}"></td>
                            <td class="br-right-o {{ $seance->s5 == 0 ? 'bg-gray' : '' }}"></td>
                            <td class="{{ $seance->s6 == 0 ? 'bg-gray' : '' }}"></td>
                            <td class="{{ $seance->s7 == 0 ? 'bg-gray' : '' }}"></td>
                            <td class="{{ $seance->s8 == 0 ? 'bg-gray' : '' }}"></td>
                            @php
                                $seance = DB::table('seances')
                                    ->where('id_classe', $eleve->id_classe)
                                    ->where('code_jours', 6)
                                    ->first();
                            @endphp
                            <td class="br-right {{ $seance->s1 == 0 ? 'bg-gray' : '' }}"></td>
                            <td class="{{ $seance->s2 == 0 ? 'bg-gray' : '' }}"></td>
                            <td class="{{ $seance->s3 == 0 ? 'bg-gray' : '' }}"></td>
                            <td class="{{ $seance->s4 == 0 ? 'bg-gray' : '' }}"></td>
                            <td class="br-right-o {{ $seance->s5 == 0 ? 'bg-gray' : '' }}"></td>
                            <td class="{{ $seance->s6 == 0 ? 'bg-gray' : '' }}"></td>
                            <td class="{{ $seance->s7 == 0 ? 'bg-gray' : '' }}"></td>
                            <td class="{{ $seance->s8 == 0 ? 'bg-gray' : '' }}"></td>
                        </tr>
                    @endforeach
                    <tr style="height: 60px">
                        <td colspan="2"> توقيع الأساتذة</td>
                        @php
                            $seance = DB::table('seances')
                                ->where('id_classe', $classe->id_classe)
                                ->where('code_jours', 4)
                                ->first();
                        @endphp
                        <td class="br-right {{ $seance->s1 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s2 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s3 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s4 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="br-right-o {{ $seance->s5 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s6 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s7 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s8 == 0 ? 'bg-gray' : '' }}"></td>
                        @php
                            $seance = DB::table('seances')
                                ->where('id_classe', $classe->id_classe)
                                ->where('code_jours', 5)
                                ->first();
                        @endphp
                        <td class="br-right {{ $seance->s1 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s2 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s3 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s4 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="br-right-o {{ $seance->s5 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s6 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s7 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s8 == 0 ? 'bg-gray' : '' }}"></td>
                        @php
                            $seance = DB::table('seances')
                                ->where('id_classe', $classe->id_classe)
                                ->where('code_jours', 6)
                                ->first();
                        @endphp
                        <td class="br-right {{ $seance->s1 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s2 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s3 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s4 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="br-right-o {{ $seance->s5 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s6 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s7 == 0 ? 'bg-gray' : '' }}"></td>
                        <td class="{{ $seance->s8 == 0 ? 'bg-gray' : '' }}"></td>
                    </tr>

                    <tr style="height: 40px">
                        <td colspan="2"> الموجهون إلى الإدارة</td>
                        <td class="br-right" colspan="8"></td>
                        <td class="br-right" colspan="8"></td>
                        <td class="br-right" colspan="8"></td>
                    </tr>

                </tbody>
            </table>


        </div>
                <p>ملاحظة : كل تلميذ تم تصحيح رقمه بالمبيض يعتبر غائبا ويوجه إلى الحراسة العامة</p>

    </div>
    {{--  <button class="btn btn-danger noPrint col-2 mx-auto" onclick="window.print()">طباعة</button> --}}
    </div>
</body>

</html>
