@extends('templates.site')
@section('content')

<div class="inputsearch row" style="justify-content: flex-end;">

      <div class="row" >
        <div class="col-10 d-flex align-items-stretch">
          <div class="card col-10 mx-auto ">

            <div class="card-body p-4">

              <h5 class="card-title  fw-semibold mb-4">طباعة ورقة الغياب الأسبوعية</h5>

              </div>

              <div class="table ">
                <table class="table table-bordered text-center table-hover mb-0 align-middle" style="border: 1px solid">
                  <thead class="text-dark fs-4 ">
                    <tr>

                      <th class="border-bottom-0">
                        <h6 class="fw-semibold mb-0"> المستوى   </h6>
                      </th>
                      <th class="border-bottom-0">
                        <h6 class="fw-semibold mb-0">  القسم </h6>
                      </th>
                      <th class="border-bottom-0">
                        <h6 class="fw-semibold mb-0">طباعة</h6>
                      </th>
                    </tr>
                  </thead>
                  <tbody id="table_classes">
                      {{-- liste classes --}}
                      @foreach ($absence_data_array as $key => $classes)
                      @foreach ($classes as $classes)
                    <tr>
                        @if ($loop->iteration==1)
                        <td class="" style="border-bottom:1px solid" rowspan="{{$loop->count}}">
                            <h6 class="fw-semibold mb-1 ">{{$key}}</h6>
                        </td>

                        @endif


                        <td class="border-bottom-0">
                            <h6 class="fw-semibold mb-1 ">{{$classes['nom_classe_fr']}}</h6>
                        </td>

                      <td class="border-bottom-0">
                        <div class="">
                          <a href="{{route('absence.generateListes',$classes['id_classe'])}}?print=ok" class="badge bg-danger rounded-3 fw-semibold text-center"><i class="ti ti-printer"></i></a>
                        </div>
                      </td>


                    </tr>
                    @endforeach
                    @endforeach

                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

      @endsection
