<!-- Modal -->
<div class="modal fade" id="modal-profile" tabindex="-1" aria-labelledby="modal-profile"
aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
        <form action="{{ route('home.save') }}" method="post" enctype="multipart/form-data">
           {{ csrf_field() }}
           <div class="modal-header">اعدادات التطبيق</div>
            <div class="modal-body">
                   <input type="hidden" name="id_user" value="{{Auth::user()->id}}" >
               <div class="form-group">
                   <label for="nom">اختيار الموسم الدراسي  :</label>
                   @php
                       $sessions = DB::table('sessions')->get();
                       $session = DB::table('sessions')->where('status_session',1)->first();

                       $settings = DB::table('settings')->where('id_user',Auth::user()->id)->first();
                        $colors = explode(",",$settings->colors);
                   @endphp
                   <select id="id_session" name="id_session" class="custom-select custom-select-lg mb-3 form-control">
                    @foreach($sessions as $sessions)
                    <option value="{{$sessions->id_session}}"  {{$sessions->id_session == $session->id_session ? 'selected' : '' }} >{{$sessions->nom_session}}</option>
                    @endforeach
                  </select>
               </div>
               <div class="form-group mt-2">
                   <label for="nbr_seance_limit">سقف عدد ساعات الغياب</label>
                   <input type="number" class="form-control" value="{{$settings->nbr_seance_limit}}" autocomplete="off" id="nbr_seance_limit" name="nbr_seance_limit" placeholder="" >
               </div>
               <div class="form-group mt-2 ">
                <label for="nbr_jours_limit">سقف عدد أيام الغياب</label>
                <input type="number" class="form-control" value="{{$settings->nbr_jour_limit}}" autocomplete="off" id="nbr_jour_limit" name="nbr_jour_limit" placeholder="" >
            </div>
            <div class="form-group my-2">
                <label for="nbr_jours_limit"> مدة تتبع الغياب بالأيام </label>
                <input type="number" class="form-control" value="{{$settings->periode_jours}}" autocomplete="off" id="periode_jours" name="periode_jours" placeholder="" >
            </div>
            <div class="form-group my-2">
                <label for="w_paper"> طول ورقة السماح بالمليمتر</label>
                <input type="number" step="0.01" class="form-control" value="{{$settings->w_paper}}" autocomplete="off" id="w_paper" name="w_paper" placeholder="" >
                <label for="h_paper"> عرض ورقة السماح بالمليمتر</label>
                <input type="number" step="0.01" class="form-control" value="{{$settings->h_paper}}" autocomplete="off" id="h_paper" name="h_paper" placeholder="" >
            </div>


                <label for="nbr_jours_limit mt-2"> اختيار الألوان</label>
                <div class="form-group mt-2 mx-5">
                    @foreach ($colors as $color)
                    <input type="color" class="form-inline form-control-color border-0 rounded-circle m-1 " width="30" height="30" value="{{$color}}" autocomplete="off" id="periode_jours" name="color[]" placeholder="" >
                    @if ($loop->iteration % 3 ==0)
                        <br>
                    @endif
                    @endforeach

            </div>
           </div>
           <div class="modal-footer">
               <button type="submit" class="btn btn-success btn-round">تحديث</button>
               <button type="button" class="btn btn-danger btn-round" data-bs-dismiss="modal">خروج</button>
           </div>
        </form>
    </div>
</div>
   </div>
