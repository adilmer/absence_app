@extends('templates.site')
@section('content')

<form action="{{route('eleve.update')}}" method="post" enctype="multipart/form-data">
    @csrf
<div class="card">
    <div class="card-body">
      <h5 class="card-title fw-semibold mb-4">معلومات التلميذ</h5>
      <div class="card">
        <div class="card-body">
          <div class="row">
            <input type="hidden" class="form-control" id="id_eleve" name="id_eleve" placeholder="" value="{{$eleve->id_eleve}}">
            <div class="col-6">
                <label for="nom_ar" >الإسم العائلي بالعربية</label>
                <input type="text" class="form-control" id="nom_ar" name="nom_ar" placeholder="" value="{{$eleve->nom_ar}}">
              </div>
              <div class="col-6 ">
                  <label for="prenom_ar" >الإسم الشخصي بالعربية</label>
                  <input type="text" class="form-control" id="prenom_ar" name="prenom_ar" placeholder="" value="{{$eleve->prenom_ar}}">
                </div>
              <div class="col-6 ">
                <label for="nom_fr">الإسم العائلي بالفرنسية</label>
                <input value="{{$eleve->nom_fr}}" name="nom_fr" type="text" class="form-control text-uppercase" id="nom_fr" placeholder="">
              </div>
              <div class="col-6 ">
                  <label for="prenom_fr">الإسم الشخصي بالفرنسية</label>
                  <input value="{{$eleve->prenom_fr}}" name="prenom_fr" type="text" class="form-control text-uppercase" id="prenom_fr" placeholder="">
                </div>
              <div class="col-2 mt-3">
                <label for="sexe" >الجنس</label>
                <select name="sexe" class="form-control custom-select custom-select-lg mb-3">
                  <option value="ذكر" {{$eleve->sexe == 'ذكر' ? 'selected' : '' }} >ذكر</option>
                  <option value="أنثى" {{$eleve->sexe == 'أنثى' ? 'selected' : '' }}>أنثى</option>
                </select>
              </div>
              <div class="col-2 mt-3">
                <label for="date_naiss">تاريخ الإزدياد</label>
                <input value="{{$eleve->date_naiss->format('Y-m-d')}}" name="date_naiss" type="date" class="form-control" id="date_naiss" placeholder="">
              </div>
              <div class="col-4 mt-3">
                <label for="lieu_naiss_ar" >مكان الإزدياد بالعربية</label>
                <input value="{{$eleve->lieu_naiss_ar}}" name="lieu_naiss_ar" type="text" class="form-control" id="lieu_naiss_ar" placeholder="">
              </div>
              <div class="col-4 mt-3">
                  <label for="lieu_naiss_fr" >مكان الإزدياد بالفرنسية</label>
                  <input value="{{$eleve->lieu_naiss_fr}}" name="lieu_naiss_fr" type="text" class="form-control text-uppercase" id="lieu_naiss_fr" placeholder="">
                </div>
              <div class="col-4 mt-3">
                  <label for="mat">رقم مسار</label>
                  <input value="{{$eleve->mat}}" name="mat" type="text" class="form-control text-uppercase" id="mat" placeholder="">
                </div>
                <div class="col-2 mt-3">
                    <label for="num_eleve">الرقم الترتيبي</label>
                    <input value="{{$eleve->num_eleve}}" name="num_eleve" type="number" class="form-control" id="num_eleve" placeholder="">
                  </div>
                <div class="col-4 mt-3">
                  <label for="id_classe" >المستوى والقسم</label>
                  <select id="id_classe" name="id_classe" class="custom-select custom-select-lg mb-3 form-control">
                    @foreach($classes as $classes)
                    <option value="{{$classes->id_classe}}"  {{$eleve->id_classe == $classes->id_classe ? 'selected' : '' }} >{{$classes->nom_classe_ar}} ({{$classes->nom_classe_fr}})</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-2 mt-3">
                    <label for="status_eleve" >وضعية التلميذ الحالية</label>
                    <select name="status_eleve" class="form-control custom-select custom-select-lg mb-3">
                      <option value="1" {{$eleve->status_eleve == '1' ? 'selected' : '' }} > متمدرس</option>
                      <option value="2" {{$eleve->status_eleve == '2' ? 'selected' : '' }}> مغادر</option>
                      <option value="3" {{$eleve->status_eleve == '3' ? 'selected' : '' }}> منقطع</option>
                      <option value="4" {{$eleve->status_eleve == '4' ? 'selected' : '' }}> غير ملتحق</option>
                    </select>
                  </div>
          </div>
        </div>
      </div>
      <h5 class="card-title fw-semibold mb-4">معلومات الولي</h5>
      <div class="card">
        <div class="card-body">
            @foreach ($eleve->parentes as $parente )

          <div class="row">
            <input type="hidden" class="form-control" id="id_parent[]" name="id_parent[]" placeholder="" value="{{$parente->id_parent}}">
            <div class="col-6">
                <label for="nom_parent_ar[]" >الإسم العائلي بالعربية</label>
                <input type="text" class="form-control" id="nom_parent_ar[]" name="nom_parent_ar[]" placeholder="" value="{{$parente->nom_parent_ar}}">
              </div>
              <div class="col-6 ">
                  <label for="prenom_parent_ar[]" >الإسم الشخصي بالعربية</label>
                  <input type="text" class="form-control" id="prenom_parent_ar[]" name="prenom_parent_ar[]" placeholder="" value="{{$parente->prenom_parent_ar}}">
                </div>
              <div class="col-6 ">
                <label for="nom_parent_fr[]">الإسم العائلي بالفرنسية</label>
                <input value="{{$parente->nom_parent_fr}}" name="nom_parent_fr[]" type="text" class="form-control text-uppercase" id="nom_parent_fr[]" placeholder="">
              </div>
              <div class="col-6 ">
                  <label for="prenom_parent_fr[]">الإسم الشخصي بالفرنسية</label>
                  <input value="{{$parente->prenom_parent_fr}}" name="prenom_parent_fr[]" type="text" class="form-control text-uppercase" id="prenom_parent_fr[]" placeholder="">
                </div>
              <div class="col-4 mt-3">
                <label for="type_parent[]" >نوع الوصاية</label>
                <input class="form-control" value="{{$parente->type_parent}}" list="type_parents_list" id="type_parent[]" name="type_parent[]"  placeholder="بحث...">
                <datalist id="type_parents_list">
                    <option data-id="أب" value="أب" >
                        <option data-id="أم" value="أم" >
                            <option data-id="وصي" value="وصي" >
                </datalist>
              </div>
              <div class="col-4 mt-3">
                <label for="cin[]">رقم البطاقة الوطنية </label>
                <input value="{{$parente->cin}}" name="cin[]" type="text" class="form-control text-uppercase" id="cin[]" placeholder="">
              </div>
              <div class="col-4 mt-3">
                <label for="profession[]" >  المهنة</label>
                <input value="{{$parente->profession}}" name="profession[]" type="text" class="form-control" id="profession[]" placeholder="">
              </div>
              <div class="col-4 mt-3">
                  <label for="tel[]" >رقم الهاتف  </label>
                  <input value="{{$parente->tel}}" name="tel[]" type="text" class="form-control {{$parente->tel == '' ? ' border-danger' : ' border-success'}}" id="tel[]" placeholder="">
                </div>
              <div class="col-4 mt-3">
                  <label for="adresse[]"> العنوان</label>
                  <input value="{{$parente->adresse}}" name="adresse[]" type="text" class="form-control text-uppercase" id="adresse[]" placeholder="">
                </div>
          </div>
          <br><hr>
          @endforeach
        </div>
      </div>
    <div class="btnsimple text-start m-4 ">
      <button type="submit" class="btn btn-primary">تحديث المعلومــات</button>
    </div>
  </div>
</form>

</div>
@endsection
