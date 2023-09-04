@extends('templates.site')
@section('content')

<div class="inputsearch row" style="justify-content: flex-end;">



      <div class="row" >
        <div class="col-lg-12 d-flex align-items-stretch">
          <div class="card w-100">

            <div class="card-body p-4">

              <h5 class="card-title  fw-semibold mb-4">لائحة الحصص الدراسية </h5>
              <div class="col-sm-3 pl-0  ">
                <select id="id_classe" class="form-select">
                    @foreach($classes as $classes)
                    <option value="{{$classes->id_classe}}">{{$classes->nom_classe_ar}} ({{$classes->nom_classe_fr}})</option>
                    @endforeach
                </select>
              </div>
              </div>

              <div class="table ">
                <table class="table  mb-0 align-middle">
                  <thead class="text-dark fs-4 ">
                    <tr>
                      <th class="border-bottom-0 text-center">
                        <h6 class="fw-semibold mb-0">أيام الأسبوع</h6>
                      </th>
                      <th class="border-bottom-0">
                        <h6 class="fw-semibold mb-0"> القسم  </h6>
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

                    </tr>
                  </thead>
                  <tbody id="table_checkbox_seance">
                      {{-- liste seances --}}
                      @php

                      $weekdayNames = [
                         'الأحد',
                          'الاثنين',
                          'الثلاثاء',
                          'الأربعاء',
                          'الخميس',
                          'الجمعة',
                          'السبت',
                      ];
              @endphp
                      @foreach ($seances as $seances)
                    <tr>

                      <td class="border-bottom-0 text-center">
                        <h6 class="fw-semibold mb-0 ">{{$weekdayNames[$seances->code_jours]}}</h6>
                      </td>
                      <td class="border-bottom-0">
                          <h6 class="fw-semibold mb-1 ">{{$seances->classe->nom_classe_fr ?? ''}}</h6>
                      </td>
                      <td>
                        <input class="checkbox_seance"  data-id_seance="{{$seances->id_seance}}" type="checkbox" name="s1" id="{{$seances->s1}}" {{$seances->s1==1 ? 'checked' : ''}}>
                        </td>
                        <td>
                        <input class="checkbox_seance"  data-id_seance="{{$seances->id_seance}}" type="checkbox" name="s2" id="{{$seances->s2}}" {{$seances->s2==1 ? 'checked' : ''}}>
                        </td>
                        <td>
                        <input class="checkbox_seance"  data-id_seance="{{$seances->id_seance}}" type="checkbox" name="s3" id="{{$seances->s3}}" {{$seances->s3==1 ? 'checked' : ''}}>
                        </td>
                        <td>
                        <input class="checkbox_seance"  data-id_seance="{{$seances->id_seance}}" type="checkbox" name="s4" id="{{$seances->s4}}" {{$seances->s4==1 ? 'checked' : ''}}>
                        </td>
                        <td></td>
                        <td>
                        <input class="checkbox_seance"  data-id_seance="{{$seances->id_seance}}" type="checkbox" name="s5" id="{{$seances->s5}}" {{$seances->s5==1 ? 'checked' : ''}}>
                        </td>
                        <td>
                        <input class="checkbox_seance"  data-id_seance="{{$seances->id_seance}}" type="checkbox" name="s6" id="{{$seances->s6}}" {{$seances->s6==1 ? 'checked' : ''}}>
                        </td>
                        <td>
                        <input class="checkbox_seance"  data-id_seance="{{$seances->id_seance}}" type="checkbox" name="s7" id="{{$seances->s7}}" {{$seances->s7==1 ? 'checked' : ''}}>
                        </td>
                        <td>
                        <input class="checkbox_seance"  data-id_seance="{{$seances->id_seance}}" type="checkbox" name="s8" id="{{$seances->s8}}" {{$seances->s8==1 ? 'checked' : ''}}>
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
 <!-- modul add file-->

 <div class="modal fade" id="addseanceModal" tabindex="-1" aria-labelledby="addseanceModal"
 aria-hidden="true">
 <div class="modal-dialog">
     <div class="modal-content">
         <form action="{{ route('seance.save') }}" method="post" enctype="multipart/form-data">
             @csrf
             <div class="modal-header">
                 <h5 class="modal-title" id=""> إضافة قسم جديد</h5>
             </div>
             <div class="modal-body">
                 <div class="col-md-12">
                     <label for="nom_seance_ar" class="form-label">إسم القسم بالعربية</label>
                     <input type="text" name="nom_seance_ar" class="form-control" id="nom_seance_ar">
                 </div>
                 <div class="col-md-12">
                    <label for="nom_seance_fr" class="form-label">إسم القسم بالفرنسية</label>
                     <input type="text" name="nom_seance_fr" class="form-control" id="nom_seance_fr">
                 </div>
             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                 <button type="submit" class="btn btn-primary">حفظ المعلومات </button>
             </div>
         </form>
     </div>
 </div>


@endsection
@section('script')
$("#id_classe").on("change", function(){
    $text = this.value
    $url = "{{ route('seance.filter') }}"
    $("#table_checkbox_seance").html("");
    get_table_ajax_find($text,$url,"#table_checkbox_seance")

    });
    $(document).on("change", ".checkbox_seance", function() {
        $seance = this.name;
        $seance_value = this.id;
        $id_seance = this.getAttribute("data-id_seance");
        $url = "{{ route('seance.update') }}"
        get_table_ajax_find(''+"&seance_nom="+$seance+"&"+$seance+"="+$seance_value+"&id_seance="+$id_seance,$url,"#table_checkbox_seance")

        });
@endsection
