<?php

namespace App\Http\Controllers;

use App\Models\Absence;
use App\Models\MotifAbsence;
use App\Models\Seance;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

/**
 * Summary of motifAbsenceController
 */
class MotifAbsenceController extends Controller
{
    use UploadTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $motifAbsences = MotifAbsence::where('id_motif','>',1)->orderby('id_motif')->get();

        return view('pages.motifAbsences.index',compact('motifAbsences'));
    }


    public function filter(Request $request)
    {
        //dd($request);
        $motifAbsences = MotifAbsence::where('id_motif','>',1)->orderby('id_motif');

        if ($request->text != '') {

            $motifAbsences = $motifAbsences
                ->where(function ($query) use ($request) {
                    $query->where('nom_motif', 'like', '%' . $request->text . '%');
                });
        }


        $motifAbsences = $motifAbsences->get();
       // dd($motifAbsences->first());
        $data = '';

        foreach ($motifAbsences as $key => $motifAbsences) {

            $route_delete = route('motifAbsence.delete',$motifAbsences->id_motif);

            $data .="<tr>
            <td class='border-bottom-0'>
                        <h6 class='fw-semibold mb-0'>$motifAbsences->id_motif</h6>
                      </td>
                      <td class='border-bottom-0'>
                          <h6 class='fw-semibold mb-1 '>$motifAbsences->nom_motif</h6>
                      </td>";

            $data .="<td class='border-bottom-0'>
              <div class='d-flex  align-items-center gap-2'>
                <a href='$route_delete' onclick='return confirm(`هل تريد إزالة هذا المبرر من قاعدة البيانات ؟`)' class='badge bg-danger rounded-3 fw-semibold'><i class='ti ti-trash'></i></a>
              </div>
            </td>
          </tr>";
        }
        //dd($data);
        return Response(['data' => $data]);

    }

    public function filterBymotifAbsence(Request $request)
    {


        $absences = Absence::where('id_eleve', $request->id_eleve)->orderbyDesc('date');

        if ($request->id_motif != '0') {

            $absences = $absences
                ->where('status_absence', $request->id_motif);
        }



        $absences = $absences->whereBetween('date', [$request->date_absence1, $request->date_absence2])->get();
       // dd($absences);
        $motif_absences = MotifAbsence::all();
       // dd($motifAbsences->first());
        $data = '';
        $total_seances = str_pad(0, 2, '0', STR_PAD_LEFT);
        $total_jours = str_pad(0, 2, '0', STR_PAD_LEFT);
        foreach ($absences as $key => $absences) {

            $total_seances = str_pad($absences->total_seances, 2, '0', STR_PAD_LEFT);
            $total_jours = str_pad($absences->total_jours, 2, '0', STR_PAD_LEFT);
            $data .="<tr class='text-center'>
            <td>{$absences->date->format('Y-m-d')}</td>
            <td>$total_seances </td>
            <td>$total_jours </td>
            <td>
                <div class=' pl-0 mb-2  '>
                    <select id='status_absence' class='form-select bg-white status-absence'>";
                      foreach($motif_absences as $motif_absence){
                      $motif = $motif_absence->id_motif == $absences->status_absence ? 'selected' : '';
                      $data .="<option value='$motif_absence->id_motif'  $motif >$motif_absence->nom_motif</option>";
                        }
                      $data .="</select>
                  </div>
            </td>

            <td> <button type='button'  name='$absences->status_absence' id='$absences->id_absence' class='btn btn-sm btn-success button-with-status' > <i class='ti ti-check'></i></button></td>
        </tr>";
        }
        //dd($data);
        return Response(['data' => $data]);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $requestData = $request->all();
        MotifAbsence::create($requestData);

        return redirect(route('motifAbsence.index'));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\motifAbsence  $motifAbsence
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $motifAbsences = MotifAbsence::all();
        $motifAbsence = MotifAbsence::findOrFail($request->id_motifAbsence);

        return \view('pages.motifAbsences.edit',compact(['motifAbsences','motifAbsence']));
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\motifAbsence  $motifAbsence
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $motifAbsence = MotifAbsence::findOrFail($request->id_motif);
        if($request->id_motif != 1)
        $motifAbsence->delete();

        return redirect(route('motifAbsence.index'));
    }
}
