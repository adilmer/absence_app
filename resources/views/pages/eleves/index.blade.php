@extends('templates.site')
@section('content')
    <div class="inputsearch row" style="justify-content: flex-end;">

        <div class="col-sm-6 pl-0 mb-2  ">
            <input type="text" class="form-control " id="txt_cherch" placeholder="بحث ..." aria-label="Recipient's username"
                aria-describedby="button-addon2">
        </div>
        <div class="col-sm-3 pl-0 mb-2  ">
            <select id="id_classe" class="form-select">
                <option value="0" selected> - كل الأقسام ... </option>
                @foreach ($classes as $classes)
                    <option value="{{ $classes->id_classe }}">{{ $classes->nom_classe_ar }} ({{ $classes->nom_classe_fr }})
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-sm-2 ">
            <a href="{{ route('eleve.create') }}" class="btn btn-primary"><i class="ti ti-user-plus"></i> إضافة تلميذ</a>

        </div>
        <div class="row">
            <div class="col-lg-12 d-flex align-items-stretch">
                <div class="card w-100">

                    <div class="card-body p-4">
                        <button type="button" style="float:left"
                            class="btn  btn-outline-success text-capitalize float-left btn-round mx-1"
                            data-bs-toggle="modal" data-bs-target="#modal-import_eleve">
                            <i class="ti ti-upload"></i> استيراد وتحيين لوائح التلاميذ
                        </button>
                        <button type="button" style="float:left"
                            class="btn  btn-outline-info text-capitalize float-left btn-round mx-1" data-bs-toggle="modal"
                            data-bs-target="#modal-import_parent">
                            <i class="ti ti-upload"></i> استيراد وتحيين معطيات الولي
                        </button>
                        <h5 class="card-title  fw-semibold mb-4">لائحة التلاميذ</h5>
                        <h6 class="my-4">
                            @php
                                $id_session = App\Models\Session::where('status_session',1)->first()->id_session;
                                $c1 = App\Models\Eleve::where('id_session',$id_session)->where('status_eleve',1)->get();
                                $c2 = App\Models\Eleve::where('id_session',$id_session)->where('status_eleve',2)->get();
                                $c3 = App\Models\Eleve::where('id_session',$id_session)->where('status_eleve',3)->get();
                                $c4 = App\Models\Eleve::where('id_session',$id_session)->where('status_eleve',4)->get();
                            @endphp
                        <span class="alert alert-success p-2">العدد الإجمالي للمتمدرسين : {{$c1->count() ?? 0}}</span>
                        <span class="alert alert-warning p-2">العدد الإجمالي للمغادرين  : {{$c2->count() ?? 0}}</span>
                        <span class="alert alert-danger p-2">العدد الإجمالي للمنقطعين  : {{$c3->count() ?? 0}}</span>
                        <span class="alert alert-info p-2">العدد الإجمالي لغير الملتحقين  : {{$c4->count() ?? 0}}</span>
                    </h6>
                        <!--  pagination links -->
                        <div id="paginate" class="d-flex justify-content-center">
                            <span class="custom-pagination">
                                {{ $eleves->links() }}
                            </span>
                        </div>
                    </div>

                    <div class="table ">
                        <table class="table table-responsive table-sm  mb-0 align-middle text-center">
                            <thead class="text-dark fs-4 ">
                                <tr>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">#</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">رقم مسار</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">الإسم الكامل</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">القسم</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">الوضعية الحالية </h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">إعدادات</h6>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="table_eleves">
                                {{-- liste eleves --}}
                                @foreach ($eleves as $eleve)
                                    <tr>
                                        <td class="border-bottom-0">
                                            <div class="img">
                                                <h6 class="fw-semibold mb-0">{{ $eleve->num_eleve }}</h6>
                                            </div>
                                        </td>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">{{ $eleve->mat }}</h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-1 ">{{ $eleve->nom_ar . ' ' . $eleve->prenom_ar }}</h6>
                                            <span
                                                class="fw-normal text-uppercase">{{ $eleve->nom_fr . ' ' . $eleve->prenom_fr }}</span>
                                        </td>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-1">{{ $eleve->classe->nom_classe_ar ?? '' }}</h6>
                                            <span class="fw-normal">{{ $eleve->classe->nom_classe_fr ?? '' }}</span>
                                        </td>
                                        <td class="border-bottom-0">
                                            <h6 class="mb-0 fw-normal">{{ $eleve->status_eleve==1 ? 'متمدرس' : ($eleve->status_eleve==2 ? 'مغادر' : 'منقطع') }}</h6>
                                        </td>
                                        <td class="border-bottom-0 text-left">
                                            <div class=" gap-2">
                                                <a href="{{ route('eleve.details', $eleve->id_eleve) }}"
                                                    class="badge bg-primary rounded-3 fw-semibold"><i
                                                        class="ti ti-eye"></i></a>
                                                <a href="{{ route('eleve.edit', $eleve->id_eleve) }}"
                                                    class="badge bg-success rounded-3 fw-semibold"><i
                                                        class="ti ti-edit"></i></a>
                                                <a href="{{ route('eleve.delete', $eleve->id_eleve) }}"
                                                    onclick="return confirm('هل تريد إزالة هذا التلميذ من قاعدة البيانات ؟')"
                                                    class="badge bg-danger rounded-3 fw-semibold"><i
                                                        class="ti ti-trash"></i></a>
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

    <!-- modal import_eleve-->

    <div class="modal fade" id="modal-import_eleve" tabindex="-1" aria-labelledby="modal-import_eleve" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('eleve.importElevesData') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id=""> استيراد وتحيين لوائح التلاميذ من مسار</h5>
                    </div>
                    <div class="modal-body">
                        <label for="fileCsv"> رفع الملف بصيغة Excel </label>
                        <input type="file" name="fileCsv" class="form-control"
                            accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                            id="fileCsv">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                        <button type="submit" class="btn btn-primary">تأكيد</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- modal import_parent-->

    <div class="modal fade" id="modal-import_parent" tabindex="-1" aria-labelledby="modal-import_parent"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('eleve.importparentsData') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id=""> استيراد وتحيين معطيات الولي من مسار</h5>
                    </div>
                    <div class="modal-body">
                        <label for="fileCsv"> رفع الملفات بصيغة Excel </label>
                        <input type="file" name="fileCsv[]" class="form-control" multiple
                            accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                            id="fileCsv">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                        <button type="submit" class="btn btn-primary">تأكيد</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    $("#txt_cherch").on("input", function(){
    $text = this.value
    $url = "{{ route('eleve.filter') }}"
    $("#table_eleves").html("");
    if ($text !== '') {
        $(".custom-pagination").hide();
    } else {
        $(".custom-pagination").show();
    }

    get_table_ajax_find($text,$url,"#table_eleves")

    });
    $("#id_classe").on("change", function(){
    $id = this.value
    $url = "{{ route('eleve.filterByclasse') }}"
    $("#table_eleves").html("");
    if($id !=0) {
        $(".custom-pagination").hide();
    } else {
        $(".custom-pagination").show();
    }

    get_table_ajax_find($id,$url,"#table_eleves")

    });
@endsection
