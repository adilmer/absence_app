@extends('templates.site')
@section('content')
    <form action="{{ route('eleve.save') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">معلومات التلميذ</h5>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6 ">
                                <label for="nom_ar">الإسم العائلي بالعربية</label>
                                <input type="text" class="form-control" id="nom_ar" name="nom_ar" placeholder="" required>
                            </div>
                            <div class="col-6 ">
                                <label for="prenom_ar">الإسم الشخصي بالعربية</label>
                                <input type="text" class="form-control" id="prenom_ar" name="prenom_ar" placeholder="" required>
                            </div>
                            <div class="col-6 ">
                                <label for="nom_fr">الإسم العائلي بالفرنسية</label>
                                <input name="nom_fr" type="text" class="form-control text-uppercase" id="nom_fr"
                                    placeholder="">
                            </div>
                            <div class="col-6 ">
                                <label for="prenom_fr">الإسم الشخصي بالفرنسية</label>
                                <input name="prenom_fr" type="text" class="form-control text-uppercase" id="prenom_fr"
                                    placeholder="">
                            </div>
                            <div class="col-2 mt-3">
                                <label for="sexe">الجنس</label>
                                <select name="sexe" class="form-control custom-select custom-select-lg mb-3" required>
                                    <option value="ذكر" selected>ذكر</option>
                                    <option value="أنثى">أنثى</option>
                                </select>
                            </div>
                            <div class="col-2 mt-3">
                                <label for="date_naiss">تاريخ الإزدياد</label>
                                <input name="date_naiss" type="date" class="form-control" id="date_naiss" placeholder="" required>
                            </div>
                            <div class="col-4 mt-3">
                                <label for="lieu_naiss_ar">مكان الإزدياد بالعربية</label>
                                <input name="lieu_naiss_ar" type="text" class="form-control" id="lieu_naiss_ar"
                                    placeholder="" required>
                            </div>
                            <div class="col-4 mt-3">
                                <label for="lieu_naiss_fr">مكان الإزدياد بالفرنسية</label>
                                <input name="lieu_naiss_fr" type="text" class="form-control text-uppercase"
                                    id="lieu_naiss_fr" placeholder="">
                            </div>
                            <div class="col-4 mt-3">
                                <label for="num_eleve"> الرقم الترتيبي</label>
                                <input name="num_eleve" type="number" class="form-control" id="num_eleve" placeholder="" required>
                            </div>

                            <div class="col-4 mt-3">
                                <label for="mat">رقم مسار</label>
                                <input name="mat" type="text" class="form-control" id="mat" placeholder="" required>
                            </div>
                            <div class="col-4 mt-3">
                                <label for="id_classe">المستوى والقسم</label>
                                <select id="id_classe" name="id_classe"
                                    class="custom-select custom-select-lg mb-3 form-control" required>
                                    <option value=""></option>
                                    @foreach ($classes as $classes)
                                        <option value="{{ $classes->id_classe }}">{{ $classes->nom_classe_ar }}
                                            ({{ $classes->nom_classe_fr }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="btnsimple text-start m-4 ">
                    <button type="submit" class="btn btn-primary">حفظ المعلومــات</button>
                </div>
            </div>

    </form>
    </div>
@endsection
