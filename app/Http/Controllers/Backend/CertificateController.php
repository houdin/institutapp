<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Backend\BackendBaseController;
use App\Models\Certificate;
use App\Models\Formation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class CertificateController extends BackendBaseController
{
    public function __construct()
    {
    }

    /**
     * Get certificates lost for purchased formations.
     */
    public function getCertificates()
    {
        $certificates = auth()->user()->certificates;
        return view('backend.certificates.index', compact('certificates'));
    }


    /**
     * Generate certificate for completed formation
     */
    public function generateCertificate(Request $request)
    {
        $formation = Formation::whereHas('students', function ($query) {
            $query->where('id', \Auth::id());
        })
            ->where('id', '=', $request->formation_id)->first();
        if (($formation != null) && ($formation->progress() == 100)) {
            $certificate = Certificate::firstOrCreate([
                'user_id' => auth()->user()->id,
                'formation_id' => $request->formation_id
            ]);

            $data = [
                'name' => auth()->user()->name,
                'formation_name' => $formation->title,
                'date' => Carbon::now()->format('d M, Y'),
            ];
            $certificate_name = 'Certificate-' . $formation->id . '-' . auth()->user()->id . '.pdf';
            $certificate->name = auth()->user()->id;
            $certificate->url = $certificate_name;
            $certificate->save();

            $pdf = \PDF::loadView('certificate.index', compact('data'))->setPaper('', 'landscape');

            $pdf->save(public_path('storage/certificates/' . $certificate_name));

            return back()->with('success', trans('alerts.frontend.formation.completed'));
        }
        return abort(404);
    }

    /**
     * Download certificate for completed formation
     */
    public function download(Request $request)
    {
        $certificate = Certificate::findOrFail($request->certificate_id);
        if ($certificate != null) {
            $file = public_path() . "/storage/certificates/" . $certificate->url;
            return Response::download($file);
        }
        return back()->with('danger', 'No Certificate found');
    }


    /**
     * Get Verify Certificate form
     */
    public function getVerificationForm()
    {
        return view('frontend.certificate-verification');
    }


    /**
     * Verify Certificate
     */
    public function verifyCertificate(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'date' => 'required'
        ]);

        $certificates = Certificate::where('name', '=', $request->name)
            ->where(DB::raw("(DATE_FORMAT(created_at,'%Y-%m-%d'))"), "=", $request->date)
            ->get();
        $data['certificates'] = $certificates;
        $data['name'] = $request->name;
        $data['date'] = $request->date;
        session()->forget('certificates');
        return back()->with(['data' => $data]);
    }
}
