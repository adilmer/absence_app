@extends('templates.site')
@section('content')
    <div class="">

        <div class="row" style="justify-content: flex-end;">
            <div class="col-sm-3 pl-0 mb-2">
                <input type="text" class="form-control" id="txt_cherch" placeholder="بحث ..."
                    aria-label="Recipient's username" aria-describedby="button-addon2">
            </div>
            <div class="col-sm-3 pl-0 mb-2 " style="display: none">
                <input type="date" class="form-control" id="txt_date_absence" value="{{ date('Y-m-d') }}">
            </div>
            <div class="col-sm-3 pl-0 mb-2  ">
                <select id="id_classe" class="form-select">
                    @foreach ($classes as $classes)
                        <option value="{{ $classes->id_classe }}">{{ $classes->nom_classe_ar }}
                            ({{ $classes->nom_classe_fr }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="row">
                <div class="col-lg-12 d-flex align-items-stretch">

                    <div class="card w-100">
                        <button id="btn_show" class="btn btn-sm btn-success position-fixed " style="display: none"   data-bs-toggle="modal" data-bs-target="#billetsModal" >اعداد  ورقة <br>السماح </button>
                        <div class="card-body p-4">

                            <p class="card-title  text-center text-left" id="date_text"></p>
                            <h5 class="card-title fw-semibold mb-4">لائحة التلاميذ </h5>

                            <div class=" col-lg-12 w-100">
                                <table class="table table-striped table-s table-responsive mb-0 align-middle text-center">
                                    <thead class=" fs-4">
                                        <tr class="">
                                            <th class="border-bottom-0 text-right">
                                                <h6 class="fw-semibold mb-0">تحديد التلاميذ</h6>
                                            </th>
                                            <th class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0">الرقم الترتيبي</h6>
                                            </th>
                                            <th class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0">الإسم الكامل</h6>
                                            </th>
                                            <th class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0">القسم </h6>
                                            </th>
                                            <th class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0">مجموع الساعات </h6>
                                            </th>
                                            <th class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0">مجموع الأيام </h6>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="table_absences">
                                        @foreach ($eleves as $eleves)
                                            <tr class="text-center">
                                                <td>
                                                    <div class="form-check  form-check-inline">
                                                    <input class="form-check-input border-info" data-id-eleve="{{ $eleves->id_eleve }}" type="checkbox" name="id_eleve[]" id="" value="{{ $eleves->id_eleve }}" >
                                                    <label class="form-check-label" for=""></label>
                                                </div>
                                                </td>
                                                <td>{{ $eleves->num_eleve }}</td>
                                                <td><a href="{{ route('eleve.details', $eleves->id_eleve) }}">{{ $eleves->nom_ar }}
                                                        {{ $eleves->prenom_ar }}</a></td>
                                                <td>{{ $eleves->classe->nom_classe_fr }}</td>
                                                @php
                                                    $total_seances = 0;
                                                    $total_jours = 0;
                                                    $absence = $eleves->absences->first();

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


                                                <td>
                                                    <span
                                                        class="text-bold">{{ str_pad($total_seances_eleve, 2, '0', STR_PAD_LEFT) }}</span>
                                                </td>
                                                <td><span
                                                        class="text-bold">{{ str_pad($total_jours_eleve, 2, '0', STR_PAD_LEFT) }}</span>
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

    <div class="modal fade" id="billetsModal" tabindex="-1" aria-labelledby="billetsModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('absence.generateAll') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id=""> ورقة الإذن بالدخول الجماعية</h5>
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
    $url = "{{ route('absence.filter_collective') }}"
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
    $url = "{{ route('absence.filter_collective') }}"
    $("#table_absences").html("");
    get_table_ajax_find(""+"&texte="+$text+"&date_absence="+$date_absence+"&id_classe="+$id_classe,$url,"#table_absences")

    });
    $("#id_classe").on("input", function(){
    $text = $("#txt_cherch").val();
    $date_absence = $("#txt_date_absence").val();
    $id_classe = $("#id_classe").val();
    $url = "{{ route('absence.filter_collective') }}"
    $("#table_absences").html("");
    get_table_ajax_find(""+"&texte="+$text+"&date_absence="+$date_absence+"&id_classe="+$id_classe,$url,"#table_absences")

    });

    function getSelectedIds() {
        const selectedIds = [];
        $('input[type="checkbox"]:checked').each(function() {
            const id = $(this).data('id-eleve'); // Assuming data-id attribute holds the id_eleve value
            selectedIds.push(id);
        });
        return selectedIds;
    }

    function saveSelectedIdsToSession(selectedIds) {
        $.ajax({
            url: "{{ route('absence.saveSelected') }}", // Replace with your route for saving selected ids
            method: "POST",
            data: {
                selectedIds: selectedIds,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                console.log("Selected IDs saved to session.");
            },
            error: function(error) {
                console.error("Error saving selected IDs:", error);
            }
        });
    }
    $('input[type="checkbox"]').on('click', function() {
        const selectedIds = getSelectedIds();
        if(selectedIds.length > 0) {
            $('#btn_show').css('display', 'block');
        }
        else{
            $('#btn_show').css('display', 'none');
        }
        saveSelectedIdsToSession(selectedIds);
    });

    // ... Your existing code ...

    // Modify the AJAX request function to include selected IDs when filters are applied
    function applyFilters() {
        const selectedIds = getSelectedIds();
        const text = $("#txt_cherch").val();
        const dateAbsence = $("#txt_date_absence").val();
        const idClasse = $("#id_classe").val();
        const url = "{{ route('absence.filter') }}";

        const requestData = {
            selectedIds: selectedIds,
            texte: text,
            date_absence: dateAbsence,
            id_classe: idClasse
        };

        get_table_ajax_find(requestData, url, "#table_absences");
    }

@endsection
