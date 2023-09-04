@extends('templates.site')
@section('content')

<div class="card">
    <div class="card-body">
        <h2 class="card-title fw-semibold mb-4">تفاصيل الطالب</h2>
        <hr>
        <div class="row text-bold text-muted">
            <div class="col-md-4">
                <h4 class="m-2">معلومات التلميذ<hr></h4>
                <ul class="list-group">
                    <li class="list-group-item"> الرقم الترتيبي داخل الفصل :  {{ $eleve->num_eleve }}</li>
                    <li class="list-group-item">رقم مسار :  {{ $eleve->mat }}</li>
                    <li class="list-group-item">الإسم الكامل بالعربية :  {{ $eleve->nom_ar }} {{ $eleve->prenom_ar }}</li>
                    <li class="list-group-item">الإسم الكامل بالفرنسية :  {{ $eleve->nom_fr }} {{ $eleve->prenom_fr }}</li>
                    <li class="list-group-item">الجنس :  {{ $eleve->sexe }}</li>
                    <li class="list-group-item">تاريخ الإزدياد :  {{ $eleve->date_naiss->format('Y-m-d') }}</li>
                    <li class="list-group-item">مكان الإزدياد بالعربية :  {{ $eleve->lieu_naiss_ar }}</li>
                    <li class="list-group-item">المستوى والقسم :  {{ $eleve->classe->nom_classe_ar }} ( {{ $eleve->classe->nom_classe_fr }} )</li>
                </ul>
            </div>
            <div class="col-md-7">
                <h4 class="m-2">بيانات ولي الأمر <a href="{{route('eleve.edit',$eleve->id_eleve)}}" class="btn btn-sm btn-warning mx-2" style="float: left"><i class="ti ti-edit"></i> تعديل </a><hr></h4>
                <table class="table">
                    <thead>
                        <th>الإسم الكامل</th>
                        <th>نوع الوصاية</th>
                        <th>المهنة</th>
                        <th>رقم البطاقة الوطنية</th>
                        <th>رقم الهاتف</th>
                        <th> العنوان</th>
                    </thead>
                    <tbody>
                        @foreach ($parents as $parents)
                            <tr>
                                <td>{{ $parents->nom_parent_ar }} {{ $parents->prenom_parent_ar }}</td>
                                <td>{{ $parents->type_parent }}</td>
                                <td>{{ $parents->profession }}</td>
                                <td>{{ $parents->cin }}</td>
                                @php
                                    $etab = App\Models\Information::where('status_info',1)->first()->etablissement ;
                                    $nom_eleve =  $parents->eleve->nom_ar ." ". $parents->eleve->prenom_ar ;
                                    $text = "السلام عليكم نعلمكم نحن مكتب الحراسة العامة بمؤسسة $etab بالحضور قصد تسوية وضعية التلميذ $nom_eleve في أقرب وقت وشكرا"
                                @endphp
                                <td><a target="_blank" href="https://api.whatsapp.com/send/?phone=212{{ substr($parents->tel,1) }}&text={{$text}}">{{ $parents->tel }}</a></td>
                                <td>{{ $parents->adresse }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="col-md-12 m-4">
                <p class="m-2"></span><span class="h4">بيانات الغياب<a href="{{route('absence.edit',$eleve->id_eleve)}}" class="btn btn-sm btn-secondary mx-2" style="float: left"><i class="ti ti-edit"></i> تعديل </a><hr></span><span class="text-small text-center">
                    <table class="table table-info table-bordered">
                    <tr class="">
                     <th class="mx-2"> مجموع ساعات الغياب المبررة  : </th>
                     <th class="mx-2">{{$absences->where('status_absence','<>',1)->sum('total_seances')}}  </th>
                     <th class="mx-2"> مجموع أيام الغياب المبررة  : </th>
                     <th class="mx-2">{{$absences->where('status_absence','<>',1)->sum('total_jours')}}  </th>
                     <th class="mx-1"> مجموع ساعات الغياب الغير المبررة  : </th>
                     <th class="mx-1">{{$absences->where('status_absence','=',1)->sum('total_seances')}}  </th>
                     <th class="mx-1"> مجموع أيام الغياب الغير المبررة  : </th>
                     <th class="mx-1">{{$absences->where('status_absence','=',1)->sum('total_jours')}}  </th>
                </tr>
            </table>
                </span></p>
                <table class="table text-center">
                    <thead>
                        <th> التاريخ</th>
                        <th>ساعات الغياب </th>
                        <th>أيام الغياب </th>
                        <th>التبرير</th>
                    </thead>
                    <tbody>
                        @foreach ($absences as $absences)
                        <tr>
                            <td>{{ $absences->date->format('Y-m-d') }}</td>
                            <td>{{ $absences->total_seances }}</td>
                            <td>{{ $absences->total_jours }}</td>
                            <td>{{ $absences->motif_absence->nom_motif }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
