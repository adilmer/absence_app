@extends('templates.site')
@section('content')
<div class="" >

    <div class="row" style="justify-content: flex-start;">

        <div class="col-sm-3 pl-0 mb-2">
            <span>من تاريخ :</span>
            <input type="date" class="form-control"  id="txt_date_absence1" value="{{$absence->min('date')}}" >
          </div>
      <div class="col-sm-3 pl-0 mb-2">
        <span>الى تاريخ :</span>
        <input type="date" class="form-control"  id="txt_date_absence2" value="{{$absence->max('date')}}" >
      </div>
      <div class="col-sm-3 pl-0 mb-2  ">
        <span> فلترة حسب المبرر :</span>
        <select id="id_motif" class="form-select">
          <option value="0" selected> - مبرر الغياب  ...  </option>
          @foreach($motif_absences as $motif_absence)
          <option value="{{$motif_absence->id_motif}}">{{$motif_absence->nom_motif}}</option>
          @endforeach
        </select>
        <input type="hidden" name="id_eleve" id="id_eleve" value="{{$absences[0]->id_eleve ?? ''}}">
      </div>

        <div class="row">



          <div class="col-lg-12 d-flex align-items-stretch">

            <div class="card w-100 mt-2">
              <div class="card-body p-4  ">
                <div class="col-12 row">
                    <span class="card-title fw-semibold col-11">أرشيف الغياب </span>
                    <a href="{{route('absence.index')}}" class="btn btn-outline-secondary col-1"><i class=""> عودة</i></a>
                </div>
                <div class="table col-lg-12 w-100">
                  <table class="table table-striped text-nowrap mb-0 align-middle  text-center">
                    <thead class="text-dark fs-4">
                      <tr class="">

                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">التاريخ </h6>
                        </th>
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">مجموع الساعات </h6>
                          </th>
                          <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">مجموع الأيام </h6>
                          </th>

                          <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">مبرر الغياب </h6>
                          </th>
                          <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0"> تأكيد </h6>
                          </th>
                      </tr>
                    </thead>
                    <tbody id="table_absences">
                        @foreach ($absences as $absences)

                        <tr class="text-center">

                            <td>{{$absences->date->format('Y-m-d')}}</td>
                            <td>{{str_pad($absences->total_seances, 2, '0', STR_PAD_LEFT) ?? '00'}}  </td>
                            <td>{{str_pad($absences->total_jours, 2, '0', STR_PAD_LEFT) ?? '00'}} </td>

                            <td>
                                <div class=" pl-0 mb-2  ">
                                    <select id="status_absence" class="form-select bg-white status-absence">
                                      @foreach($motif_absences as $motif_absence)
                                      <option value="{{$motif_absence->id_motif}}" {{$motif_absence->id_motif == $absences->status_absence ? 'selected' : '' }}>{{$motif_absence->nom_motif}}</option>
                                      @endforeach
                                    </select>
                                  </div>
                            </td>
                            <td> <button type="button"  name="{{$absences->status_absence}}" id="{{$absences->id_absence}}" class="btn btn-sm btn-success button-with-status" > <i class="ti ti-check"></i></button></td>
                        </tr>
                        @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            {{-- info eleve --}}
            <div class="col-2 card bg-light  mx-3 p-3 alert alert-info mt-2">
                <p class=" text-muted h6 text-center">معلومات التلميذ :</p>
                <hr class="m-0 mb-1">
               <p class="text-bold"> <span>الإسم الكامل :</span> {{$absences->eleve->nom_ar}} {{$absences->eleve->prenom_ar}}</p>
               <p class="text-bold"> <span>الرقم الترتيبي :</span> {{$absences->eleve->num_eleve}}</p>
               <p class="text-bold"> <span>رقم مسار :</span> {{$absences->eleve->mat}}</p>
               <hr class="m-0 mb-1">
               <p class=" text-muted h6 text-center">مجموع ساعات الغياب  :</p>
               <hr class="m-0 mb-1">
               <table>
               <tr class="table " >
                <td><p class="text-bold"><span> مبرر :</span>{{str_pad($absences->eleve->absences->where('status_absence','>',1)->sum('total_seances'), 2, '0', STR_PAD_LEFT)}}</p></td>
                <td><p class="text-bold"> <span> غير مبرر :</span>{{str_pad($absences->eleve->absences->where('status_absence',1)->sum('total_seances'), 2, '0', STR_PAD_LEFT)}}</p></td>
               </tr>
            </table>
            <hr class="m-0 mb-1">
            <p class=" text-muted h6 text-center">مجموع أيام الغياب  :</p>
            <hr class="m-0 mb-1">
               <table>
               <tr class="table" >
                <td><p class="text-bold"><span> مبرر :</span>{{str_pad($absences->eleve->absences->where('status_absence','>',1)->sum('total_jours'), 2, '0', STR_PAD_LEFT)}}</p></td>
                <td><p class="text-bold"> <span> غير مبرر :</span>{{str_pad($absences->eleve->absences->where('status_absence',1)->sum('total_jours'), 2, '0', STR_PAD_LEFT)}}</p></td>
               </tr>
            </table>
            </div>
          </div>
        </div>


      </div>



  </div>
@endsection

@section('script')
$(document).on("change", ".status-absence", function() {
        var selectedValue = $(this).val();
        $(this).closest("tr").find(".button-with-status").attr("name", selectedValue);
    });
    $(document).on("click", ".button-with-status", function() {
        var status_absence = $(this).attr("name");
        var id_absence = $(this).attr("id");
        var redirectUrl = "{{ route('absence.save') }}" + "?status_absence=" + status_absence + "&id_absence=" +id_absence;

        window.location.href = redirectUrl; // Redirect to the specified URL
    });



    function send_request(){
        $date_absence1 = $("#txt_date_absence1").val();
        $date_absence2 = $("#txt_date_absence2").val();
        $id_motif = $("#id_motif").val();
        $id_eleve = $("#id_eleve").val();
        $url = "{{ route('motifAbsence.filterBymotifAbsence') }}"
        $("#table_absences").html("");
         get_table_ajax_find(""+"&date_absence1="+$date_absence1+"&date_absence2="+$date_absence2+"&id_eleve="+$id_eleve+"&id_motif="+$id_motif,$url,"#table_absences")
    }
    $("#txt_date_absence1").on("input", function(){
        send_request();
        });

    $("#txt_date_absence2").on("input", function(){
            send_request()
        });

    $("#id_motif").on("change", function(){
            send_request()
        });

@endsection
