@extends('templates.site')
@section('content')

<div class="inputsearch row" style="justify-content: flex-end;">

  <div class="col-sm-6 pl-0 mb-2  ">
    <input type="text" class="form-control " id="txt_cherch" placeholder="بحث ..." aria-label="Recipient's username" aria-describedby="button-addon2">
  </div>
  <div class="col-sm-2 ">
    <button  data-bs-toggle="modal" data-bs-target="#addClasseModal" class="btn btn-primary"><i class="ti ti-plus"></i> إضافة قسم</button>

  </div>
      <div class="row" >
        <div class="col-lg-12 d-flex align-items-stretch">
          <div class="card w-100">

            <div class="card-body p-4">

              <h5 class="card-title  fw-semibold mb-4">لائحة الأقسام</h5>

              </div>

              <div class="table ">
                <table class="table  mb-0 align-middle">
                  <thead class="text-dark fs-4 ">
                    <tr>
                      <th class="border-bottom-0 text-center">
                        <h6 class="fw-semibold mb-0">#</h6>
                      </th>
                      <th class="border-bottom-0">
                        <h6 class="fw-semibold mb-0"> المستوى  </h6>
                      </th>
                      <th class="border-bottom-0">
                        <h6 class="fw-semibold mb-0"> القسم  </h6>
                      </th>
                      <th class="border-bottom-0">
                        <h6 class="fw-semibold mb-0">إعدادات</h6>
                      </th>
                    </tr>
                  </thead>
                  <tbody id="table_classes">
                      {{-- liste classes --}}
                      @foreach ($classes as $classes)
                    <tr>

                      <td class="border-bottom-0">
                        <h6 class="fw-semibold mb-0">{{$classes->id_classe}}</h6>
                      </td>
                      <td class="border-bottom-0">
                          <h6 class="fw-semibold mb-1 ">{{$classes->nom_classe_ar}}</h6>
                      </td>
                      <td class="border-bottom-0">
                        <h6 class="fw-semibold mb-1">{{$classes->nom_classe_fr}}</h6>
                      </td>

                      <td class="border-bottom-0">
                        <div class="d-flex  align-items-center gap-2">
                          <a href="{{route('classe.delete',$classes->id_classe)}}" onclick="return confirm('هل تريد إزالة هذا القسم من قاعدة البيانات ؟')" class="badge bg-danger rounded-3 fw-semibold"><i class="ti ti-trash"></i></a>
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

 <div class="modal fade" id="addClasseModal" tabindex="-1" aria-labelledby="addClasseModal"
 aria-hidden="true">
 <div class="modal-dialog">
     <div class="modal-content">
         <form action="{{ route('classe.save') }}" method="post" enctype="multipart/form-data">
             @csrf
             <div class="modal-header">
                 <h5 class="modal-title" id=""> إضافة قسم جديد</h5>
             </div>
             <div class="modal-body">
                 <div class="col-md-12">
                     <label for="nom_classe_ar" class="form-label"> المستوى </label>
                     <input type="text" name="nom_classe_ar" class="form-control" id="nom_classe_ar">
                 </div>
                 <div class="col-md-12">
                    <label for="nom_classe_fr" class="form-label"> القسم </label>
                     <input type="text" name="nom_classe_fr" class="form-control" id="nom_classe_fr">
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
    $url = "{{ route('classe.filter') }}"
    $("#table_classes").html("");
    get_table_ajax_find($text,$url,"#table_classes")

    });
@endsection
