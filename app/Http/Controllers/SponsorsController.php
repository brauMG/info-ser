<?php


namespace App\Http\Controllers;

use App\Models\Companias;
use App\Models\Sponsors;
use App\Models\SponsorsCompanies;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SponsorsController extends Controller
{

    public function index(Request $request)
    {
        if (Auth::user()->id_rol == 1) {
            $compania= Companias::where('id',Auth::user()->id_compania)->first();
            $sponsors = Sponsors::all();
            return view('pages.patrocinadores.index', compact('sponsors', 'compania'));
        }
    }

    public function new(){
        $companies = Companias::all();
        return view('pages.patrocinadores.new', compact('companies'));
    }

    public function store(Request $request)
    {
        if (Auth::user()->id_rol == 1) {
            $companies = $request->input('companies');
            $show = $request->input('show');
            $request->validate([
                'name' => ['required', 'string'],
                'description' => ['required', 'string', 'max:5000'],
                'link' => ['required', 'string', 'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/'],
                'image' => ['required', 'image', 'mimes:png'],
            ]);

            $image = $request->file('image');
            $new_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('sponsors'), $new_name);

            $sponsor_data = array(
                'nombre' => $request->name,
                'description' => $request->description,
                'enlace' => $request->link,
                'imagen' => $new_name,
                'mostrar' => 0
            );

            $addSponsors = Sponsors::create($sponsor_data);

            foreach ($companies as $company) {
                $addSponsors->companies()->attach($company);
            }

            return redirect('/patrocinadores')->with('mensaje', 'El patrocinador fue agregado exitosamente');
        }
    }

    public function edit(Request $request, $id)
    {
        if (Auth::user()->id_rol == 1) {
            $compania=Companias::where('id',Auth::user()->id_compania)->first();
            $sponsor = Sponsors::where('id', $id)->firstOrFail();
            $companies = Companias::all();
            $sponsors_companies = Companias::join('patrocinadores_companias', 'patrocinadores_companias.id_compania', 'companias.id')
                ->where('patrocinadores_companias.id_patrocinador', $id)
                ->get();

            $valid = false;
            $array_companies = array();
            foreach ($companies as $company) {
                foreach ($sponsors_companies as $SC) {
                    if ($company->id == $SC->id_compania) {
                        $valid = true;
                    }
                }
                $array_companies[] = array('valid' => $valid, 'name' => $company->descripcion, 'id_compania' => $company->id);
                $valid = false;
            }

            return view('pages.patrocinadores.edit', compact('compania','sponsor', 'companies', 'array_companies'));
        }
    }

    public function update(Request $request, $sponsorId)
    {
        if (Auth::user()->id_rol == 1) {
            $companies = $request->input('companies');
            $show = $request->input('show');

            $image_name = $request->hidden_image;
            $image = $request->file('image');
            if ($image != '') {
                $request->validate([
                    'name' => ['required', 'string'],
                    'description' => ['required', 'string', 'max:5000'],
                    'link' => ['required', 'string', 'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/'],
                    'image' => ['image', 'mimes:png'],
                ]);

                $image_name = rand() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('sponsors'), $image_name);
            } else {
                $request->validate([
                    'name' => ['required', 'string'],
                    'description' => ['required', 'string'],
                    'link' => ['required', 'string', 'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/']
                ]);
            }

            $sponsor_data = array(
                'nombre' => $request->name,
                'description' => $request->description,
                'enlace' => $request->link,
                'imagen' => $image_name,
                'mostrar' => 0
            );

            $addSponsors = Sponsors::where('id', $sponsorId)->update($sponsor_data);

            SponsorsCompanies::where('id_patrocinador', $sponsorId)->delete();

            foreach ($companies as $company) {
                SponsorsCompanies::insert([
                    'id_patrocinador' => $sponsorId,
                    'id_compania' => $company
                ]);
            }

            return back()->with('mensaje', 'El patrocinador fue actualizado exitosamente.');
        }
    }

    public function prepare($id){
        $patrocinador = Sponsors::where('id', $id)->get()->toArray();
        $patrocinador = $patrocinador[0];
        return view('pages.patrocinadores.delete', compact('patrocinador'));
    }

    public function delete(Request $request, $id)
    {
        if (Auth::user()->id_rol == 1) {
            SponsorsCompanies::where('id_patrocinador', $id)->delete();
            Sponsors::where('id', $id)->delete();
            return redirect('/patrocinadores')->with('mensaje', 'El patrocinador fue eliminado exitosamente.');
        }
    }
}
