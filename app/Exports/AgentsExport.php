<?php

namespace App\Exports;

use App\Models\Agent;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ElevesExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
     /*    $eleves = DB::table('eleves')
        ->join('classes', 'classes.id_grade', '=', 'eleves.id_grade')
        ->select('num_eleve','mat','nom_ar','prenom_ar','sexe','date_naiss','lieu_naiss','nom_classe_ar','nom_classe_fr')
        ->where('status_eleve',1)
        ->get();
       // dd($eleves);
        return $eleves;*/
    }

    /* public function map($data): array
    {
        return[
        $data->mat,
		$data->ppr,
		$data->cin,
		$data->nom_fr,
		$data->nom_ar,
		$data->sexe,
		$data->date_naiss,
		$data->lieu_naiss,
		$data->date_rec,
		$data->id_grade,
		$data->date_grade,
		$data->echelle,
		$data->echellon,
		$data->date_echellon,
		$data->indice,
		$data->date_position,
		$data->lieu_position,
		$data->id_fonction,
		$data->id_bureau,
		$data->id_position,
		$data->situation_fam,
		$data->fonction_cj,
		$data->nbr_enfant,
		$data->aos,
		$data->aff_mutuelle,
		$data->immatriculation,
		$data->n_affilation,
		$data->aff_cmr,
		$data->rib,
		$data->agence,
		$data->tel,
		$data->adresse_fr,
		$data->adresse_ar,
		$data->photo
        ];
    } */

    public function headings(): array
    {
        return session()->get('header_eleves');

    }
}
