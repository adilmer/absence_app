@extends('templates.site')
@section('content')

<div class="row " style="justify-content: flex-end;">
      <div class="col-sm-3 pl-0 mb-2">
        <select name="id_bureau" id="id_bureau" class="custom-select custom-select-lg mb-3 form-control">

            <option value="0" selected>اختر ...</option>
            @foreach ($bureaus as $bureaus)
            <option value="{{$bureaus->id_bureau}}">{{$bureaus->nom_bureau_ar}}</option>
            @endforeach
        </select>
      </div>
      <div class="col-sm-3 ">
        <a id="print_list" target="_blank" href="{{route('absence.generate')}}" class="btn btn-primary"><i class="ti ti-printer"></i> طباعة الكل</a>
      </div>
        <div class="row">

          <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
              <div class="card-body p-4">
                <h5 class="card-title fw-semibold mb-4">لائحة الموظفين</h5>
                <div class="table-responsive">
                  <table class="table table-striped text-nowrap mb-0 align-middle">
                    <thead class="text-dark fs-4">
                      <tr>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">MAT</h6>
                        </th>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">PPR</h6>
                        </th>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0"> الإسم الكامل </h6>
                        </th>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">الدرجة</h6>
                        </th>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">السلم</h6>
                        </th>
                         <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">الرتبة</h6>
                        </th>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">مشاهدة</h6>
                        </th>
                      </tr>
                    </thead>
                    <tbody id="table_agents">
                        @foreach ($agents as $agents)

                      <tr>
                        <td class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">{{$agents->mat}}</h6>
                        </td>
                        <td class="border-bottom-0">
                          <p class="mb-0 fw-normal">{{$agents->ppr}}</p>
                        </td>
                        <td class="border-bottom-0">
                            <h6 class="fw-semibold mb-1">{{$agents->nom_ar}}</h6>
                            <span class="fw-normal">{{$agents->nom_fr}}</span>
                        </td>
                        <td class="border-bottom-0">
                          <p class="mb-0 fw-normal">{{$agents->grade->nom_grade_ar}}</p>
                        </td>
                        <td class="border-bottom-0">
                          <p class="mb-0 fw-normal">{{$agents->echelle}}</p>
                        </td>
                        <td class="border-bottom-0">
                          <p class="mb-0 fw-normal">{{$agents->echellon}}</p>
                        </td>
                        <td class="border-bottom-0">
                          <div class="d-flex align-items-center gap-2">
                            <a href="{{route('agent.details',$agents->id_agent)}}">
                            <span class="badge bg-primary rounded-3 fw-semibold"><i class="ti ti-eye"></i></span>
                            </a>
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


      </div>



@endsection

@section('script')
$("#id_bureau").on("change", function(){
    $id = this.value
    if($id==0)
        $("#print_list").html('<i class="ti ti-printer"></i> طباعة الكل');
    else
        $("#print_list").html('<i class="ti ti-printer"></i> طباعة ');

    $url = "{{ route('absence.filter') }}"
    $url2 = "{{route('absence.generate')}}?bureau="+$id;
    $("#table_agents").html("");
    $("#print_list").attr('href',$url2);
    get_table_ajax_find($id,$url,"#table_agents")


    });

@endsection
