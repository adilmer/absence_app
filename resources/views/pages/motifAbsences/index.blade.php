@extends('templates.site')
@section('content')

<div class="inputsearch row" style="justify-content: flex-end;">

  <div class="col-sm-6 pl-0 mb-2  ">
    <input type="text" class="form-control " id="txt_cherch" placeholder="بحث ..." aria-label="Recipient's username" aria-describedby="button-addon2">
  </div>
  <div class="col-sm-2 ">
    <button  data-bs-toggle="modal" data-bs-target="#addmotifAbsenceModal" class="btn btn-primary"><i class="ti ti-plus"></i> إضافة مبرر</button>

  </div>
      <div class="row" >
        <div class="col-lg-12 d-flex align-items-stretch">
          <div class="card w-100">

            <div class="card-body p-4">

              <h5 class="card-title  fw-semibold mb-4">لائحة المبررات</h5>

              </div>

              <div class="table text-center">
                <table class="table  mb-0 align-middle">
                  <thead class="text-dark fs-4 ">
                    <tr>
                      <th class="border-bottom-0 text-center">
                        <h6 class="fw-semibold mb-0">#</h6>
                      </th>
                      <th class="border-bottom-0">
                        <h6 class="fw-semibold mb-0">إسم المبرر بالعربية </h6>
                      </th>
                      <th class="border-bottom-0">
                        <h6 class="fw-semibold mb-0">إعدادات</h6>
                      </th>
                    </tr>
                  </thead>
                  <tbody id="table_motifAbsences">
                      {{-- liste motifAbsences --}}
                      @foreach ($motifAbsences as $motifAbsences)
                    <tr>

                      <td class="border-bottom-0">
                        <h6 class="fw-semibold mb-0">{{$motifAbsences->id_motif}}</h6>
                      </td>
                      <td class="border-bottom-0">
                          <h6 class="fw-semibold mb-1 ">{{$motifAbsences->nom_motif}}</h6>
                      </td>
                      <td class="border-bottom-0">
                        <div class="">
                          <a href="{{route('motifAbsence.delete',$motifAbsences->id_motif)}}" onclick="return confirm('هل تريد إزالة هذا المبرر من قاعدة البيانات ؟')" class="badge bg-danger rounded-3 fw-semibold"><i class="ti ti-trash"></i></a>
                        </div>
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

 <div class="modal fade" id="addmotifAbsenceModal" tabindex="-1" aria-labelledby="addmotifAbsenceModal"
 aria-hidden="true">
 <div class="modal-dialog">
     <div class="modal-content">
         <form action="{{ route('motifAbsence.save') }}" method="post" enctype="multipart/form-data">
             @csrf
             <div class="modal-header">
                 <h5 class="modal-title" id=""> إضافة مبرر جديد</h5>
             </div>
             <div class="modal-body">
                 <div class="col-md-12">
                     <label for="nom_motif" class="form-label">إسم المبرر بالعربية</label>
                     <input type="text" name="nom_motif" class="form-control" id="nom_motif">
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
$("#txt_cherch").on("input", function(){
    $text = this.value
    $url = "{{ route('motifAbsence.filter') }}"
    $("#table_motifAbsences").html("");
    get_table_ajax_find($text,$url,"#table_motifAbsences")

    });
@endsection
