 <!-- Modal -->
 <div class="modal fade " id="modal-export_agent"  tabindex="-1" role="dialog" aria-labelledby="modal-export_agent"
     aria-hidden="true">
     <div class="modal-dialog modal-lg  modal-dialog-centered"  role="document">
         <div class="modal-content">
             <form action="{{ route('eleve.export') }}" method="get" >
                @csrf
                 <div class="modal-header bg-primary">
                     <h6 class="modal-title text-uppercase text-white"><i class="la la-hospital-o"></i> تصدير البيانات بصيغة Excel </h6>
                     <button type="button" class="close btn btn-outline-light" data-bs-dismiss="modal" aria-bs-label="Close">
                         <span aria-bs-hidden="true">&times;</span>
                     </button>
                 </div>
                 <div class="modal-body">
                    <div class="modal-body">
                        <label class="form-chek-label m-2 btn btn-outline-light text-dark">
                            <input class="form btn " type="checkbox" id="select_all" onclick="select_all(this)">
                            <span class="form-chck-sign"> اختر الكل </span>
                        </label>
                        <hr>
                        <label class="form-check-label m-2">
                            <input class="form-check-input" type="checkbox" name="names[]" value="mat as MAT" required>
                            <span class="form-check-sign">MAT</span>
                        </label>
                        <label class="form-check-label m-2">
                            <input class="form-check-input" type="checkbox" name="names[]" value="ppr as PPR">
                            <span class="form-check-sign">PPR</span>
                        </label>
                        <label class="form-check-label m-2">
                            <input class="form-check-input" type="checkbox" name="names[]" value="cin as رقم البطاقة الوطنية">
                            <span class="form-check-sign">رقم البطاقة الوطنية</span>
                        </label>
                        <label class="form-check-label m-2">
                            <input class="form-check-input" type="checkbox" name="names[]" value="nom_fr as الإسم الكامل بالفرنسية">
                            <span class="form-check-sign">الإسم الكامل بالفرنسية</span>
                        </label>
                        <label class="form-check-label m-2">
                            <input class="form-check-input" type="checkbox" name="names[]" value="nom_ar as الإسم الكامل بالعربية">
                            <span class="form-check-sign">الإسم الكامل بالعربية</span>
                        </label>
                        <label class="form-check-label m-2">
                            <input class="form-check-input" type="checkbox" name="names[]" value="sexe as الجنس">
                            <span class="form-check-sign">الجنس</span>
                        </label>
                        <label class="form-check-label m-2">
                            <input class="form-check-input" type="checkbox" name="names[]" value="date_naiss as تاريخ الإزدياد">
                            <span class="form-check-sign">تاريخ الإزدياد</span>
                        </label>
                        <label class="form-check-label m-2">
                            <input class="form-check-input" type="checkbox" name="names[]" value="lieu_naiss as مكان الإزدياد">
                            <span class="form-check-sign">مكان الإزدياد</span>
                        </label>
                        <label class="form-check-label m-2">
                            <input class="form-check-input" type="checkbox" name="names[]" value="situation_fam as الحالة العائلية">
                            <span class="form-check-sign">الحالة العائلية</span>
                        </label>
                        {{-- <label class="form-check-label m-2">
                            <input class="form-check-input" type="checkbox" name="names[]" value="fonction_cj">
                            <span class="form-check-sign">Fonction CJ</span>
                        </label> --}}
                        <label class="form-check-label m-2">
                            <input class="form-check-input" type="checkbox" name="names[]" value="nbr_enfant as عدد الأبناء">
                            <span class="form-check-sign">عدد الأبناء</span>
                        </label>
                        <hr>
                        <label class="form-check-label m-2">
                            <input class="form-check-input" type="checkbox" name="names[]" value="date_rec as تاريخ الترسيم">
                            <span class="form-check-sign">تاريخ الترسيم</span>
                        </label>
                        <label class="form-check-label m-2">
                            <input class="form-check-input" type="checkbox" name="names[]" value="nom_grade_ar as الدرجة">
                            <span class="form-check-sign">الدرجة</span>
                        </label>
                        <label class="form-check-label m-2">
                            <input class="form-check-input" type="checkbox" name="names[]" value="date_grade as تاريخ التعيين في الدرجة">
                            <span class="form-check-sign">تاريخ التعيين في الدرجة</span>
                        </label>
                        <label class="form-check-label m-2">
                            <input class="form-check-input" type="checkbox" name="names[]" value="echelle as السلم">
                            <span class="form-check-sign">السلم</span>
                        </label>
                        <label class="form-check-label m-2">
                            <input class="form-check-input" type="checkbox" name="names[]" value="echellon as الرتبة">
                            <span class="form-check-sign">الرتبة</span>
                        </label>
                        <label class="form-check-label m-2">
                            <input class="form-check-input" type="checkbox" name="names[]" value="date_echellon as تاريخ التعيين في الرتبة">
                            <span class="form-check-sign">تاريخ التعيين في الرتبة</span>
                        </label>
                        <label class="form-check-label m-2">
                            <input class="form-check-input" type="checkbox" name="names[]" value="indice as الرقم الاستدلالي">
                            <span class="form-check-sign">الرقم الاستدلالي</span>
                        </label>
                        <label class="form-check-label m-2">
                            <input class="form-check-input" type="checkbox" name="names[]" value="nom_fonction_ar as المنصب الإداري">
                            <span class="form-check-sign">المنصب الإداري</span>
                        </label>
                        <label class="form-check-label m-2">
                            <input class="form-check-input" type="checkbox" name="names[]" value="nom_departement_ar as القسم">
                            <span class="form-check-sign">القسم</span>
                        </label>
                        <label class="form-check-label m-2">
                            <input class="form-check-input" type="checkbox" name="names[]" value="nom_service_ar as المصلحة">
                            <span class="form-check-sign">المصلحة</span>
                        </label>
                        <label class="form-check-label m-2">
                            <input class="form-check-input" type="checkbox" name="names[]" value="nom_bureau_ar as المكتب">
                            <span class="form-check-sign">المكتب</span>
                        </label>
                        <hr>
                        <label class="form-check-label m-2">
                            <input class="form-check-input" type="checkbox" name="names[]" value="nom_position_ar as نوع الإحالة">
                            <span class="form-check-sign">نوع الإحالة</span>
                        </label>
                        <label class="form-check-label m-2">
                            <input class="form-check-input" type="checkbox" name="names[]" value="date_position as تاريخ الإحالة">
                            <span class="form-check-sign">تاريخ الإحالة</span>
                        </label>
                        <label class="form-check-label m-2">
                            <input class="form-check-input" type="checkbox" name="names[]" value="lieu_position as مكان الإحالة">
                            <span class="form-check-sign">مكان الإحالة</span>
                        </label>
                        {{-- <label class="form-check-label m-2">
                            <input class="form-check-input" type="checkbox" name="names[]" value="aos">
                            <span class="form-check-sign">AOS</span>
                        </label> --}}
                        <label class="form-check-label m-2">
                            <input class="form-check-input" type="checkbox" name="names[]" value="aff_mutuelle as نوع الإنخراط">
                            <span class="form-check-sign">نوع الإنخراط</span>
                        </label>
                        <label class="form-check-label m-2">
                            <input class="form-check-input" type="checkbox" name="names[]" value="n_affilation as رقم التعاضدية ">
                            <span class="form-check-sign">رقم التعاضدية </span>
                        </label>
                        <label class="form-check-label m-2">
                            <input class="form-check-input" type="checkbox" name="names[]" value="aff_cmr as CMR رقم الإنخراط ">
                            <span class="form-check-sign">CMR رقم الإنخراط </span>
                        </label>
                        <label class="form-check-label m-2">
                            <input class="form-check-input" type="checkbox" name="names[]" value="rib as رقم الحساب البنكي ">
                            <span class="form-check-sign">رقم الحساب البنكي </span>
                        </label>
                        <label class="form-check-label m-2">
                            <input class="form-check-input" type="checkbox" name="names[]" value="agence as الوكالة البنكية">
                            <span class="form-check-sign"> الوكالة البنكية</span>
                        </label>
                        <hr>
                        <label class="form-check-label m-2">
                            <input class="form-check-input" type="checkbox" name="names[]" value="tel as الهاتف">
                            <span class="form-check-sign">الهاتف</span>
                        </label>
                        <label class="form-check-label m-2">
                            <input class="form-check-input" type="checkbox" name="names[]" value="adresse_fr as العنوان بالفرنسية">
                            <span class="form-check-sign">العنوان بالفرنسية</span>
                        </label>
                        <label class="form-check-label m-2">
                            <input class="form-check-input" type="checkbox" name="names[]" value="adresse_ar as العنوان بالعربية">
                            <span class="form-check-sign">العنوان بالعربية</span>
                        </label>


                    </div>

                     </div>
                     <div class="modal-footer">
                         <button type="submit" class="btn btn-success btn-round">تحميل </button>
                         <button type="button" class="btn btn-danger btn-round" data-bs-dismiss="modal">اغلاق</button>
                     </div>
				 </div>
             </form>
         </div>
     </div>
 </div>

 <script>
    let vari  = document.getElementById('select_all');
    let names =  document.getElementsByName('names[]');

    vari.addEventListener('change',function(){

       if (this.checked==true) {
        for (let i = 0; i < names.length; i++) {
           names[i].checked = true;
        }
       } else {
        for (let i = 0; i < names.length; i++) {
           names[i].checked = false;
        }

       }


    })



 </script>
