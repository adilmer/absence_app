<?php

namespace App\Http\Controllers;

use App\Models\Eleve;
use App\Models\Information;
use App\Models\Parente;
use App\Models\Seance;
use App\Models\Session;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Excel;

class ImportController extends Controller
{
    use UploadTrait;

    public function importElevesData(Request $request)
    {
        $FilePath = $request->file('fileCsv');

        $Data = \Excel::toArray([], $FilePath);
        $mydata=[];
        // Filter out empty arrays
        foreach ($Data as $key => $value) {
            $mydata[$key] = array_filter($value, function ($row) {
                return !empty(array_filter($row));
            });
        }
        $eleves = [];
        //dd($mydata,$Data);
        foreach ($mydata as $key => $filteredData) {


        $academie = $filteredData[5][19];
        $direction = $filteredData[7][20];
        $commune = $filteredData[5][7];
        $etablissement = $filteredData[7][7];
        $session = $filteredData[5][2];
        $annee_session = str_split($session,4)[0];
        $id_session = $this->getId([$session,$annee_session],["nom_session","annee_session"],"sessions");
        $id_user = Auth()->id();
        $info = compact('academie', 'direction', 'commune','etablissement', 'id_session');
       // dd($info);
        $information = Information::where('etablissement',$etablissement)->where('id_session',$id_session)->first();
       // dd($information);
        if ($information) {
            $information->update($info);
        }
        else {
           $information = Information::create($info);
        }

            Information::where('id_info','<>',$information->id_info)
            ->update([
                'status_info'=>0
            ]);


        $nom_classe_ar = $filteredData[9][19];
        $nom_classe_fr = $filteredData[10][8];
        $filteredData_c = $filteredData;
        end($filteredData_c);
        $last_key = key($filteredData_c);

       // dd($filteredData);

         for ($i=15; $i<=$last_key; $i++) {

                $eleves[$key][$i-9]['num_eleve']= $filteredData[$i][26];
                $eleves[$key][$i-9]['mat']= $filteredData[$i][23];
                $eleves[$key][$i-9]['nom_ar']= $filteredData[$i][16];
                $eleves[$key][$i-9]['prenom_ar']= $filteredData[$i][12];
                $eleves[$key][$i-9]['sexe']= $filteredData[$i][11];
                $date = $filteredData[$i][5];
                $real_date = ($date-25569)*86400;
	            $real_date = date("Y-m-d", $real_date);
                $eleves[$key][$i-9]['date_naiss']= $real_date;
                $eleves[$key][$i-9]['lieu_naiss_ar']= $filteredData[$i][2];
                $eleves[$key][$i-9]['id_classe']= $this->getId([$nom_classe_ar,$nom_classe_fr],["nom_classe_ar","nom_classe_fr"],"classes");
                $eleves[$key][$i-9]['id_session']= $this->getId([$session,$annee_session],["nom_session","annee_session"],"sessions");
                $eleves[$key][$i-9]['id_user']= $id_user;
               // dd($eleves[$key][$i-9]);
                $eleve = Eleve::where('mat', $eleves[$key][$i-9]['mat'])->first();
               // dd($eleve);
                if ($eleve) {
                    $eleve->update($eleves[$key][$i-9]);
                }
                else {
                   $eleve = Eleve::create($eleves[$key][$i-9]);
                }

               // dd($eleve);

        }
    }





      return redirect(route('eleve.index'));
    }

    public function importparentsData(Request $request)
    {
        $files  = $request->file('fileCsv');

        foreach ($files as $FilePath) {
        $Data = \Excel::toArray([], $FilePath);

        $mydata=[];
        // Filter out empty arrays
        foreach ($Data as $key => $value) {
            $mydata[$key] = array_filter($value, function ($row) {
               return !empty(array_filter($row));
            });
        }
        $eleves = [];
        $filteredData =$mydata[0];


       /*  $academie = $filteredData[3][3];
        $direction = $filteredData[3][6];
        $etablissement = $filteredData[4][3];

        $session = $filteredData[4][6];
        $annee_session = str_split($session,4)[0];
        $nom_classe_ar = $filteredData[5][3];
        $nom_classe_fr = $filteredData[5][6]; */

        $filteredData_c = $filteredData;
        end($filteredData_c);
        $last_key = key($filteredData_c);

    //  dd($filteredData);

         for ($i=9; $i<=$last_key; $i++) {


                $mat = $filteredData[$i][2];
                $eleve = Eleve::where('mat', $mat)->first();

                if ($eleve) {

                $id_eleve = $eleve->id_eleve;
                $type_parent = $filteredData[$i][5];
                $nom_parent_ar = $filteredData[$i][8];

                if ($nom_parent_ar!=null){
                $prenom_parent_ar = $filteredData[$i][7];
                $cin = $filteredData[$i][6];
                $nom_parent_ar = $filteredData[$i][8];
                $prenom_parent_fr = $filteredData[$i][9];
                $nom_parent_fr = $filteredData[$i][10];
                $profession = $filteredData[$i][11];
                $tel = $filteredData[$i][12];
                $adresse = $filteredData[$i][13];

                $parent = compact('id_eleve','nom_parent_ar','prenom_parent_ar','nom_parent_fr','prenom_parent_fr','cin','profession','tel','adresse','type_parent');
                $parents = Parente::where('id_eleve',$id_eleve)->where('cin',$cin)->first();

                if ($parents){
                    $parents->update($parent);
                }
                else{
                    Parente::create($parent);
                }
                }
                $type_parent2 = "أب";
                $cin2 = $filteredData[$i][14];
                $nom_parent_ar = $filteredData[$i][16];

                if ($type_parent2 != $type_parent && $nom_parent_ar!=null){
                    $type_parent = $type_parent2;
                    $cin = $cin2;
                    $prenom_parent_ar = $filteredData[$i][15];
                    $nom_parent_ar = $filteredData[$i][16];
                    $prenom_parent_fr = $filteredData[$i][17];
                    $nom_parent_fr = $filteredData[$i][18];
                    $profession = $filteredData[$i][19];
                    $tel = $filteredData[$i][20];
                    $adresse = $filteredData[$i][21];

                    $parent = compact('id_eleve','nom_parent_ar','prenom_parent_ar','nom_parent_fr','prenom_parent_fr','cin','profession','tel','adresse','type_parent');
                    $parents = Parente::where('id_eleve',$id_eleve)->where('cin',$cin)->first();
                if ($parents){
                    $parents->update($parent);
                }
                else{
                    Parente::create($parent);
                }
                }


                $type_parent3 = "أم";
                $cin3 = $filteredData[$i][22];
                $nom_parent_ar = $filteredData[$i][24];

                if ($type_parent3 != $type_parent && $nom_parent_ar!=null){
                $type_parent = $type_parent3;
                $cin = $cin3;
                $prenom_parent_ar = $filteredData[$i][23];
                $nom_parent_ar = $filteredData[$i][24];
                $prenom_parent_fr = $filteredData[$i][25];
                $nom_parent_fr = $filteredData[$i][26];
                $profession = $filteredData[$i][27];
                $tel = $filteredData[$i][28];
                $adresse = $filteredData[$i][29];

                $parent = compact('id_eleve','nom_parent_ar','prenom_parent_ar','nom_parent_fr','prenom_parent_fr','cin','profession','tel','adresse','type_parent');
                $parents = Parente::where('id_eleve',$id_eleve)->where('cin',$cin)->first();
                if ($parents){
                    $parents->update($parent);
                }
                else{
                    Parente::create($parent);
                }
                }


            }

            }


        }

      return redirect(route('eleve.index'));
    }
    private function getId($text,$nom_column, $tables)
    {

        $table = DB::table($tables);
        $classe = 'App\\Models\\' . str_replace('_', '', ucfirst($tables));
        $classe =  substr($classe, 0, strlen($classe) - 1);;

        $data=[];
            if(is_array($nom_column)){
                for ($i=0; $i <count($nom_column) ; $i++) {
                    $table->where($nom_column[$i],$text[$i]);
                    $data[$nom_column[$i]] = $text[$i];
                }

                $table_count = $table->count();
                $table = $table->first();
               //dd($table);
                if ($table_count==0) {
                   $table =  $classe::create($data);
                   if($tables=="classes"){
                    for ($i=0; $i <= 6; $i++) {
                        Seance::create([
                            'id_classe'=>$table->id_classe,
                            'code_jours'=>$i
                        ]
                        );
                    }
                   }

                   if($tables=="sessions"){
                        Session::where('id_session','<>',$table->id_session)
                        ->update([
                            'status_session'=>0
                        ]);
                   }
                }

            }
            else {
                $table->where($nom_column,$text);
                $table_count = $table->count();
                $table = $table->first();
                $data[$nom_column] = $text;
            if ($table_count==0) {
                $table =  $classe::create($data);
            }

            }

            $primaryKey = app($classe)->getKeyName();
            $id = $table->$primaryKey;

            return $id;
    }


}
