<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Mail\SipMail;
use App\Models\Consultation;
use App\Models\Head;
use App\Models\Links;
use App\Models\Meet;
use App\Models\News;
use App\Models\Role;
use App\Models\Schedule;
use App\Models\Signed;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Mail;
use PDF;
use QrCode;
use setasign\Fpdi\Fpdi;
use DB;

class ConsultationController extends Controller
{

    public function __construct()
    {
        $this->middleware('IsPermission:master_formulir');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $da = Consultation::latest()->get();
        $data = "Panugasan & Penjadwalan TPT/TPA";
        return view('konsultasi.index', compact('da', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = "Panugasan & Penjadwalan TPT TPA";
        $doc = head::doesnthave('kons')->where('grant', 1)->latest()->get();
        $user = Role::whereIn('kode', ['TPT', 'TPA'])->get();
        return view('konsultasi.create', compact('data', 'user', 'doc'));
    }

    public function store(Request $request)
    {

        $pile = $request->file('pile');

        $rule = [
            'doc' => 'required',
            'notulen' => 'required',
            'konsultan' => 'required',
            'tanggal' => 'required',
            'timeStart' => 'required',
            'timeEnd' => 'required',
            'date' => 'required',
            'jenis' => 'required',
            'place' => 'required',            
        ];

        if($pile)
        {
            $rule = array_merge(['pile' => 'file|mimes:pdf|max:2048'],$rule);
        }

        $message = [
            'required' => 'Field ini harus diisi',
            'mimes' => 'Extension File invalid',
            'max' => 'File size max 2Mb',
        ];
        $request->validate($rule, $message);

        $intersection = array_intersect($request->notulen, $request->konsultan);

        if (count($intersection) > 0) {
            toastr()->error('Ada Ketua/Notulen di dalam input anggota konsultasi', ['timeOut' => 5000]);
            return back()->withInput();
        }

        if (count($request->notulen) > 2) {
            toastr()->error('Notulen maksimal 2', ['timeOut' => 5000]);
            return back()->withInput();
        }

        $path = null;
        $kons = new Consultation;
        $kons->head = $request->doc;
        $kons->notulen = implode(",", $request->notulen);      
        if ($pile) {
            $ext = $pile->getClientOriginalExtension();
            $path = $pile->storeAs(
                'assets/konsultasi/' . time() . '_konsultasi.' . $ext, ['disk' => 'public']
            );
        }

        $kons->konsultan = implode(",", $request->konsultan);
        $kons->files = $path;
        $kons->save();

        $ch = new Schedule;
        $ch->head = $request->doc;
        $ch->jenis = $request->jenis;
        $ch->tanggal = $request->tanggal;
        $ch->waktu = $request->timeStart . '#' . $request->timeEnd . '#' . $request->date;
        $ch->tempat = $request->place . '#' . $request->place_des;
        $ch->keterangan = $request->content;
        $ch->save();

        foreach ($request->konsultan as $par) {
            $sign = new Signed;
            $sign->head = $request->doc;
            $sign->user = $par;
            $sign->task = $kons->id;
            $sign->type = 'member';
            $sign->save();
        }

        foreach ($request->notulen as $var) {
            $sign = new Signed;
            $sign->head = $request->doc;
            $sign->user = $var;
            $sign->task = $kons->id;
            $sign->type = 'lead';
            $sign->save();
        }

        if (env('MAIL')) {
            $this->mail($request->konsultan, $kons->head);
        }

        shortLink($request->doc,'surat_undangan');

        toastr()->success('Tambah Data berhasil', ['timeOut' => 5000]);
        return redirect()->route('consultation.index');
    }

    private function mail($var, $head)
    {
        $doc = head::where('id', $head)->first();

        $header = json_decode($doc->header);

        foreach ($var as $value) {
            $user = User::where('id', $value)->first();

            $mailData = [
                'title' => 'Yth. ' . $user->name,
                'body' => 'Anda mendapatkan tugas untuk melakukan verifikasi terhadap permohonan PBG/SLF dengan Nomor Registrasi :' . $header[0],
                'par' => 'Terimakasih',
            ];

            Mail::to($user->email)->send(new SipMail($mailData));
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Consultation $consultation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Consultation $consultation)
    {
        $schedule = Schedule::where('head', $consultation->head)->first();
        $data = "Edit Konsultasi";
        $doc = head::where('grant', 1)->latest()->get();
        $user = Role::whereIn('kode', ['TPT', 'TPA'])->get();
        return view('konsultasi.create', compact('data', 'user', 'doc', 'consultation', 'schedule'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Consultation $consultation)
    {
        $rule = [
            'doc' => 'required',
            'notulen' => 'required',
            'konsultan' => 'required',
            'tanggal' => 'required',
            'timeStart' => 'required',
            'timeEnd' => 'required',
            'date' => 'required',
            'jenis' => 'required',
            'place' => 'required',
            'pile' => 'nullable|file|mimes:pdf|max:2048',
        ];

        $message = [
            'required' => 'Field ini harus diisi',
            'mimes' => 'Extension File invalid',
            'max' => 'File size max 2Mb',
        ];
        $request->validate($rule, $message);

        $intersection = array_intersect($request->notulen, $request->konsultan);

        if (count($intersection) > 0) {
            toastr()->error('Ada Ketua/Notulen di dalam input anggota konsultasi', ['timeOut' => 5000]);
            return back()->withInput();
        }

        if (count($request->notulen) > 2) {
            toastr()->error('Notulen maksimal 2', ['timeOut' => 5000]);
            return back()->withInput();
        }

        $kons = $consultation;
        $path = null;
        $pile = $request->file('pile');

        if ($pile) {
            $ext = $pile->getClientOriginalExtension();
            $path = $pile->storeAs(
                'assets/konsultasi/' . time() . '_konsultasi.' . $ext, ['disk' => 'public']
            );
        }
        $kons->notulen = implode(",", $request->notulen);
        $kons->head = $request->doc;
        $kons->konsultan = implode(",", $request->konsultan);
        $kons->files = $path;
        $kons->save();

        $ch = Schedule::where('head', $consultation->head)->first();
        $ch->head = $request->doc;
        $ch->nomor = $request->nomor;
        $ch->jenis = $request->jenis;
        $ch->tanggal = $request->tanggal;
        $ch->waktu = $request->timeStart . '#' . $request->timeEnd . '#' . $request->date;
        $ch->tempat = $request->place . '#' . $request->place_des;
        $ch->keterangan = $request->content;
        $ch->save();

        Signed::where('task', $consultation->id)->where('type', 'member')->delete();

        foreach ($request->konsultan as $par) {
            $sign = new Signed;
            $sign->head = $request->doc;
            $sign->user = $par;
            $sign->task = $kons->id;
            $sign->type = 'member';
            $sign->save();
        }

        Signed::where('task', $consultation->id)->where('type', 'lead')->delete();

        foreach ($request->notulen as $var) {

            $sign = new Signed;
            $sign->head = $request->doc;
            $sign->user = $var;
            $sign->task = $kons->id;
            $sign->type = 'lead';
            $sign->save();
        }

        shortLink($request->doc,'surat_undangan');

        toastr()->success('Update Data berhasil', ['timeOut' => 5000]);
        return redirect()->route('consultation.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Consultation $consultation)
    {
        $consultation->delete();
        Schedule::where('head', $consultation->head)->delete();
        Signed::where('head', $consultation->head)->delete();
        News::where('head', $consultation->head)->delete();
        Meet::where('head', $consultation->head)->delete();
        return back();
    }
}
