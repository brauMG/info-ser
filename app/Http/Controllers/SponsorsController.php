<?php


namespace App\Http\Controllers;


use App\Compania;
use App\Sponsors;
use App\SponsorsCompanies;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SponsorsController extends Controller
{

    public function showList(Request $request)
    {
        if (Auth::user()->Clave_Rol == 1) {
            $compania=Compania::where('Clave',Auth::user()->Clave_Compania)->first();
            $sponsors = Sponsors::all();
            return view('Admin/viewSponsors/listSponsors', compact('sponsors', 'compania'));
        }
    }

    public function show(Request $request, $id)
    {
        if (Auth::user()->Clave_Rol == 1) {
            $compania=Compania::where('Clave',Auth::user()->Clave_Compania)->first();
            $sponsor = Sponsors::where('sponsorId', $id)->firstOrFail();

            $companies = Compania::join('sponsors_companies', 'sponsors_companies.companyId', 'Companias.Clave')
                ->where('sponsors_companies.sponsorId', $id)
                ->get()->toArray();

            return view('Admin/viewSponsors/showSponsors', compact('sponsor', 'companies', 'compania'));
        }
    }

    public function edit(Request $request, $id)
    {
        if (Auth::user()->Clave_Rol == 1) {
            $compania=Compania::where('Clave',Auth::user()->Clave_Compania)->first();
            $sponsor = Sponsors::where('sponsorId', $id)->firstOrFail();
            $companies = Compania::all();
            $sponsors_companies = Compania::join('sponsors_companies', 'sponsors_companies.companyId', 'Companias.Clave')
                ->where('sponsors_companies.sponsorId', $id)
                ->get();

            $valid = false;
            $array_companies = array();
            foreach ($companies as $company) {
                foreach ($sponsors_companies as $SC) {
                    if ($company->Clave == $SC->companyId) {
                        $valid = true;
                    }
                }
                $array_companies[] = array('valid' => $valid, 'name' => $company->Descripcion, 'companyId' => $company->Clave);
                $valid = false;
            }


            return view('Admin/viewSponsors/editSponsor', compact('compania','sponsor', 'companies', 'array_companies'));
        }
    }

    public function cancel(Request $request)
    {
        if (Auth::user()->Clave_Rol == 1) {
            return back()->with('mensajeError', 'La edición fue cancelada');
        }
    }

    public function update(Request $request, $sponsorId)
    {
        if (Auth::user()->Clave_Rol == 1) {
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

            if ($show == null) {
                $sponsor_data = array(
                    'name' => $request->name,
                    'description' => $request->description,
                    'link' => $request->link,
                    'image' => $image_name,
                    'show' => 0
                );
            } else {
                $sponsor_data = array(
                    'name' => $request->name,
                    'description' => $request->description,
                    'link' => $request->link,
                    'image' => $image_name,
                    'show' => 1
                );
            }

            $addSponsors = Sponsors::where('sponsorId', $sponsorId)->update($sponsor_data);

            SponsorsCompanies::where('sponsorId', $sponsorId)->delete();

            foreach ($companies as $company) {
                SponsorsCompanies::insert([
                    'sponsorId' => $sponsorId,
                    'companyId' => $company
                ]);
            }

            return back()->with('mensaje', 'El patrocinador fue actualizado exitosamente.');
        }
    }

    public function delete(Request $request, $id)
    {
        if (Auth::user()->Clave_Rol == 1) {
            Sponsors::where('sponsorId', $id)->delete();
            return redirect('Admin/viewSponsors/listSponsors')->with('mensaje', 'El patrocinador fue eliminado exitosamente.');
        }
    }

    public function createSponsor(Request $request)
    {
        if (Auth::user()->Clave_Rol == 1) {
            $compania=Compania::where('Clave',Auth::user()->Clave_Compania)->first();
            $companies = Compania::all();
            return view('Admin/addSponsors/create', compact('companies', 'compania'));
        }
    }

    public function storeSponsor(Request $request)
    {
        if (Auth::user()->Clave_Rol == 1) {
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

            if ($show == null) {
                $sponsor_data = array(
                    'name' => $request->name,
                    'description' => $request->description,
                    'link' => $request->link,
                    'image' => $new_name,
                    'show' => 0
                );
            } else {
                $sponsor_data = array(
                    'name' => $request->name,
                    'description' => $request->description,
                    'link' => $request->link,
                    'image' => $new_name,
                    'show' => 1
                );
            }

            $addSponsors = Sponsors::create($sponsor_data);

            foreach ($companies as $company) {
                $addSponsors->companies()->attach($company);
            }

            return redirect('Admin/viewSponsors/listSponsors')->with('mensaje', 'El patrocinador fue agregado exitosamente');
        }
    }
}
