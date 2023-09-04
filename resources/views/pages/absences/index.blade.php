@extends('templates.site')
@section('content')
    <div class="">

        <div class="row" style="justify-content: flex-end;">
            <div class="col-sm-3 pl-0 mb-2">
                <input type="text" class="form-control" id="txt_cherch" placeholder="بحث ..."
                    aria-label="Recipient's username" aria-describedby="button-addon2">
            </div>
            <div class="col-sm-3 pl-0 mb-2">
                <input type="date" class="form-control" id="txt_date_absence" value="{{ date('Y-m-d') }}">
            </div>
            <div class="col-sm-3 pl-0 mb-2  ">
                <select id="id_classe" class="form-select">
                    @foreach ($classes as $classes)
                        <option value="{{ $classes->id_classe }}">{{ $classes->nom_classe_ar }}
                            ({{ $classes->nom_classe_fr }})</option>
                    @endforeach
                </select>
            </div>

            <div class="row">
                <div class="col-lg-12 d-flex align-items-stretch">
                    <div class="card w-100">
                        <div class="card-body p-4">
                            <p class="card-title  text-center text-left" id="date_text"></p>
                            <h5 class="card-title fw-semibold mb-4">لائحة الغياب </h5>
                          {{--   <!--  pagination links -->
                            <div id="paginate" class="d-flex justify-content-center">
                                <span class="custom-pagination">
                                    {{ $eleves->links() }}
                                </span>
                            </div> --}}

                            <div class=" col-lg-12 w-100">
                                <table class="table table-striped table-sm  table-responsive mb-0 align-middle text-center">
                                    <thead class="text-dark fs-4">
                                        <tr>
                                            <th class="border-bottom-0" >
                                                <h6 class="fw-semibold mb-0">الرقم <br>الترتيبي</h6>
                                            </th>
                                            <th class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0">الإسم <br> الكامل</h6>
                                            </th>
                                            <th class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0">القسم </h6>
                                            </th>

                                            <th class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0">ح 1</h6>
                                            </th>
                                            <th class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0">ح 2</h6>
                                            </th>
                                            <th class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0">ح 3</h6>
                                            </th>
                                            <th class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0">ح 4</h6>
                                            </th>
                                            <th>
                                                <span>|</span>
                                            </th>
                                            <th class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0">ح 5</h6>
                                            </th>
                                            <th class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0">ح 6</h6>
                                            </th>
                                            <th class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0">ح 7</h6>
                                            </th>
                                            <th class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0">ح 8</h6>
                                            </th>
                                            <th class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0">مجموع  <br>الساعات </h6>
                                            </th>
                                            <th class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0">مجموع <br> الأيام </h6>
                                            </th>

                                            <th class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0">تبرير <br> الغيابات</h6>
                                            </th>
                                            <th class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0"> طباعة <br> ورقة السماح</h6>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="table_absences">
                                        @foreach ($eleves as $eleves)
                                            <tr class="text-center">
                                                <td>{{ $eleves->num_eleve }}</td>
                                                <td><a href="{{ route('eleve.details', $eleves->id_eleve) }}">{{ $eleves->nom_ar }}
                                                        {{ $eleves->prenom_ar }}</a></td>
                                                <td>{{ $eleves->classe->nom_classe_fr }}</td>
                                                @php
                                                    $total_seances = 0;
                                                    $total_jours = 0;
                                                    $absence = $eleves->absences->first();
                                                    //$absence = $absence[$loop->iteration-1];
                                                    $dayOfWeek = Carbon\Carbon::now()->dayOfWeek;

                                                    $seance = DB::table('seances')
                                                        ->where('id_classe', $eleves->id_classe)
                                                        ->where('code_jours', $dayOfWeek)
                                                        ->first();
                                                    //dd($seance);
                                                    $total_jours_eleve = DB::table('absences')
                                                        ->where('id_eleve', $eleves->code_eleve)
                                                        ->sum('total_jours');
                                                    $total_seances_eleve = DB::table('absences')
                                                        ->where('id_eleve', $eleves->code_eleve)
                                                        ->sum('total_seances');
                                                    if ($absence) {
                                                        $total_seances = $absence->total_seances;
                                                        $total_jours = $absence->total_jours;
                                                    }

                                                    // dd($total_jours_eleve);

                                                @endphp

                                                @if ($absence)
                                                    <td>
                                                        <input class="checkbox_eleve"
                                                            data-id_eleve="{{ $eleves->code_eleve }}" type="checkbox"
                                                            name="h1" id="{{ $absence->h1 }}"
                                                            {{ $absence->h1 == 1 ? 'checked' : '' }}
                                                            {{ $seance->s1 == 0 ? 'disabled' : '' }}>
                                                    </td>
                                                    <td>
                                                        <input class="checkbox_eleve"
                                                            data-id_eleve="{{ $eleves->code_eleve }}" type="checkbox"
                                                            name="h2" id="{{ $absence->h2 }}"
                                                            {{ $absence->h2 == 1 ? 'checked' : '' }}
                                                            {{ $seance->s2 == 0 ? 'disabled' : '' }}>
                                                    </td>
                                                    <td>
                                                        <input class="checkbox_eleve"
                                                            data-id_eleve="{{ $eleves->code_eleve }}" type="checkbox"
                                                            name="h3" id="{{ $absence->h3 }}"
                                                            {{ $absence->h3 == 1 ? 'checked' : '' }}
                                                            {{ $seance->s3 == 0 ? 'disabled' : '' }}>
                                                    </td>
                                                    <td>
                                                        <input class="checkbox_eleve"
                                                            data-id_eleve="{{ $eleves->code_eleve }}" type="checkbox"
                                                            name="h4" id="{{ $absence->h4 }}"
                                                            {{ $absence->h4 == 1 ? 'checked' : '' }}
                                                            {{ $seance->s4 == 0 ? 'disabled' : '' }}>
                                                    </td>
                                                    <td></td>
                                                    <td>
                                                        <input class="checkbox_eleve"
                                                            data-id_eleve="{{ $eleves->code_eleve }}" type="checkbox"
                                                            name="h5" id="{{ $absence->h5 }}"
                                                            {{ $absence->h5 == 1 ? 'checked' : '' }}
                                                            {{ $seance->s5 == 0 ? 'disabled' : '' }}>
                                                    </td>
                                                    <td>
                                                        <input class="checkbox_eleve"
                                                            data-id_eleve="{{ $eleves->code_eleve }}" type="checkbox"
                                                            name="h6" id="{{ $absence->h6 }}"
                                                            {{ $absence->h6 == 1 ? 'checked' : '' }}
                                                            {{ $seance->s6 == 0 ? 'disabled' : '' }}>
                                                    </td>
                                                    <td>
                                                        <input class="checkbox_eleve"
                                                            data-id_eleve="{{ $eleves->code_eleve }}" type="checkbox"
                                                            name="h7" id="{{ $absence->h7 }}"
                                                            {{ $absence->h7 == 1 ? 'checked' : '' }}
                                                            {{ $seance->s7 == 0 ? 'disabled' : '' }}>
                                                    </td>
                                                    <td>
                                                        <input class="checkbox_eleve"
                                                            data-id_eleve="{{ $eleves->code_eleve }}" type="checkbox"
                                                            name="h8" id="{{ $absence->h8 }}"
                                                            {{ $absence->h8 == 1 ? 'checked' : '' }}
                                                            {{ $seance->s8 == 0 ? 'disabled' : '' }}>
                                                    </td>
                                                @else
                                                    <td>

                                                        <input class="checkbox_eleve"
                                                            data-id_eleve="{{ $eleves->code_eleve }}" type="checkbox"
                                                            name="h1" id="0"
                                                            {{ $seance->s1 == 0 ? 'disabled' : '' }}>
                                                    </td>
                                                    <td>
                                                        <input class="checkbox_eleve"
                                                            data-id_eleve="{{ $eleves->code_eleve }}" type="checkbox"
                                                            name="h2" id="0"
                                                            {{ $seance->s2 == 0 ? 'disabled' : '' }}>
                                                    </td>
                                                    <td>
                                                        <input class="checkbox_eleve"
                                                            data-id_eleve="{{ $eleves->code_eleve }}" type="checkbox"
                                                            name="h3" id="0"
                                                            {{ $seance->s3 == 0 ? 'disabled' : '' }}>
                                                    </td>
                                                    <td>
                                                        <input class="checkbox_eleve"
                                                            data-id_eleve="{{ $eleves->code_eleve }}" type="checkbox"
                                                            name="h4" id="0"
                                                            {{ $seance->s4 == 0 ? 'disabled' : '' }}>
                                                    </td>
                                                    <td></td>
                                                    <td>
                                                        <input class="checkbox_eleve"
                                                            data-id_eleve="{{ $eleves->code_eleve }}" type="checkbox"
                                                            name="h5" id="0"
                                                            {{ $seance->s5 == 0 ? 'disabled' : '' }}>
                                                    </td>
                                                    <td>
                                                        <input class="checkbox_eleve"
                                                            data-id_eleve="{{ $eleves->code_eleve }}" type="checkbox"
                                                            name="h6" id="0"
                                                            {{ $seance->s6 == 0 ? 'disabled' : '' }}>
                                                    </td>
                                                    <td>
                                                        <input class="checkbox_eleve"
                                                            data-id_eleve="{{ $eleves->code_eleve }}" type="checkbox"
                                                            name="h7" id="0"
                                                            {{ $seance->s7 == 0 ? 'disabled' : '' }}>
                                                    </td>
                                                    <td>
                                                        <input class="checkbox_eleve"
                                                            data-id_eleve="{{ $eleves->code_eleve }}" type="checkbox"
                                                            name="h8" id="0"
                                                            {{ $seance->s8 == 0 ? 'disabled' : '' }}>
                                                    </td>
                                                @endif


                                                <td>{{ str_pad($total_seances, 2, '0', STR_PAD_LEFT) ?? '00' }} (<span
                                                        class="text-danger text-bold">{{ str_pad($total_seances_eleve, 2, '0', STR_PAD_LEFT) }}</span>)
                                                </td>
                                                <td>{{ str_pad($total_jours, 2, '0', STR_PAD_LEFT) ?? '00' }} (<span
                                                        class="text-danger text-bold">{{ str_pad($total_jours_eleve, 2, '0', STR_PAD_LEFT) }}</span>)
                                                </td>
                                                <td>
                                                    <a href="{{ route('absence.edit') }}?id_eleve={{ $eleves->code_eleve }}"
                                                        class="btn btn-sm btn-outline-secondary w-100"><i class="ti ti-"></i>
                                                        {{ $absence->motif_absence->nom_motif ?? 'بدون مبرر' }}</a>
                                                </td>
                                                <td>
                                                    <button data-id_eleve="{{ $eleves->code_eleve }}"
                                                        data-bs-toggle="modal" data-bs-target="#billetModal"
                                                        class="btn btn-sm btn-warning"><i
                                                            class="ti ti-printer"></i></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>



    </div>

    <!-- modul add file-->

    <div class="modal fade" id="billetModal" tabindex="-1" aria-labelledby="billetModalModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('absence.generate') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id=""> ورقة الإذن بالدخول</h5>
                        <input type="hidden" id="modal-id_eleve" name="id_eleve">
                    </div>
                    <div class="modal-body row">
                        <div class="col-md-6">
                            <label for="dateB" class="form-label">اختيار التاريخ </label>
                            <input type="date" name="dateB" class="form-control" id="dateB"
                                value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="timeB" class="form-label">اختيار الساعة </label>
                            <input type="time" name="timeB" class="form-control" id="timeB"
                            value="{{ date('i')<=59 && date('i') >30 ? date('H') : now()->format('H')  }}:30">
                        </div>
                        <div class="col-md-10 px-5 border m-auto mt-3">
                            <label for="timeB" class="form-label text-left mt-2">اختيار السبب </label>
                            <div class="form-check my-2">
                                <input class="form-check-input" type="radio" name="motif" id="exampleRadios1"
                                    value="الغياب">
                                <label class="form-check-label" for="exampleRadios1">
                                    الغياب
                                </label>
                            </div>
                            <div class="form-check my-2">
                                <input class="form-check-input" type="radio" name="motif" id="exampleRadios1"
                                    value="التأخر" checked>
                                <label class="form-check-label" for="exampleRadios1">
                                    التأخر
                                </label>
                            </div>
                            <div class="form-check my-2">
                                <input class="form-check-input" type="radio" name="motif" id="exampleRadios2"
                                    value="المخالفة">
                                <label class="form-check-label" for="exampleRadios2">
                                    المخالفة
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                        <button type="submit" name="print" class="btn btn-info"> معاينة</button>
                        <button type="submit" name="print" value="yes" class="btn btn-primary"> طباعة</button>
                    </div>
                </form>
            </div>
        </div>
    @endsection

    @section('script')
        $('#billetModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var id_eleve = button.data('id_eleve');

        var modal = $(this);
        modal.find('#modal-id_eleve').val(id_eleve);
        });

        $("#txt_cherch").on("input", function(){
        $text = this.value
        $date_absence = $("#txt_date_absence").val();
        $id_classe = $("#id_classe").val();
        $url = "{{ route('absence.filter') }}"
        $("#table_absences").html("");
        get_table_ajax_find(""+"&texte="+$text+"&date_absence="+$date_absence+"&id_classe="+$id_classe,$url,"#table_absences")

        });
        const dateInput = document.getElementById('txt_date_absence');
        const formattedDateElement = document.getElementById('date_text');
        const selectedDate = new Date(dateInput.value);
        const options = { year: 'numeric', month: 'long', day: 'numeric', weekday: 'long' };
        const arabicFormattedDate = selectedDate.toLocaleDateString('ar-MA', options);
        formattedDateElement.textContent = arabicFormattedDate.replace('،', '');
        dateInput.addEventListener('change', () => {
        const selectedDate = new Date(dateInput.value);
        const options = { year: 'numeric', month: 'long', day: 'numeric', weekday: 'long' };
        const arabicFormattedDate = selectedDate.toLocaleDateString('ar-MA', options);
        formattedDateElement.textContent = arabicFormattedDate.replace('،', '');
        });
        $("#txt_date_absence").on("input", function(){
        $text = $("#txt_cherch").val();
        $date_absence = $("#txt_date_absence").val();
        $id_classe = $("#id_classe").val();
        $url = "{{ route('absence.filter') }}"
        $("#table_absences").html("");
        get_table_ajax_find(""+"&texte="+$text+"&date_absence="+$date_absence+"&id_classe="+$id_classe,$url,"#table_absences")

        });
        $("#id_classe").on("input", function(){
        $text = $("#txt_cherch").val();
        $date_absence = $("#txt_date_absence").val();
        $id_classe = $("#id_classe").val();
        $url = "{{ route('absence.filter') }}"
        $("#table_absences").html("");
        get_table_ajax_find(""+"&texte="+$text+"&date_absence="+$date_absence+"&id_classe="+$id_classe,$url,"#table_absences")

        });
        $(document).on("change", ".checkbox_eleve", function() {
        $eleve = this.name;
        $eleve_value = this.id;
        $date_value = $("#txt_date_absence").val();
        $text = $("#txt_cherch").val();
        $id_classe = $("#id_classe").val();
        $id_eleve = this.getAttribute("data-id_eleve");
        $url = "{{ route('absence.update') }}"
        get_table_ajax_find(''+"&texte="+$text+"&date_absence="+$date_value+"&id_classe="+$id_classe+"&date="+$date_value+"&eleve_nom="+$eleve+"&"+$eleve+"="+$eleve_value+"&id_eleve="+$id_eleve,$url,"#table_absences")

        });
    @endsection
