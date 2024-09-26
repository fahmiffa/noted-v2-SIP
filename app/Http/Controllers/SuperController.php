<?php

namespace App\Http\Controllers;

use App\Models\Attach;
use App\Models\Head;
use App\Models\Meet;
use App\Models\News;
use App\Models\Signed;
use App\Models\Tax;
use DB;
use Illuminate\Http\Request;

class SuperController extends Controller
{
    public function __construct()
    {
        $this->middleware('IsPermission:master');
    }

    public function inputBak($id)
    {
        $news = News::where(DB::raw('md5(head)'), $id)->first();
        $head = Head::where(DB::raw('md5(id)'), $id)->first();

        if ($news) {
            $data = "Dokumen " . $news->doc->nomor;
            return view('document.bak.create', compact('data', 'news', 'head'));
        } else {
            $his = $head->bakTemp->whereNotNull('deleted_at');
            $data = "Dokumen " . $head->nomor;
            if ($his->count() > 0) {
                $news = $his[0];
                return view('document.bak.create', compact('data', 'head', 'news'));
            } else {
                return view('document.bak.create', compact('data', 'head'));
            }
        }
    }

    public function destroyBak(Request $request, $id)
    {
        $item = News::where(DB::raw('md5(id)'), $id)->first();
        Signed::where('head', $item->head)->update(['bak' => null, 'barp' => null]);
        Head::where('head', $item->head)->update(['do' => 0]);
        Meet::where('head', $item->head)->forceDelete();
        Attach::where('head', $item->head)->forceDelete();
        Tax::where('head', $item->head)->forceDelete();
        $item->forceDelete();
        toastr()->success('Hapus Berhasil', ['timeOut' => 5000]);
        return back();
    }

    public function inputBarp($id)
    {
        $meet = Meet::where(DB::raw('md5(head)'), $id)->first();
        $head = Head::where(DB::raw('md5(id)'), $id)->first();

        if (!$meet) {
            $his = $head->barpTemp->whereNotNull('deleted_at');
            if ($his->count() > 0) {
                $meet = ($meet) ? $meet : $his[0];
            }
        }

        $data = "Dokumen " . $head->number;
        return view('document.barp.create', compact('data', 'head', 'meet'));
    }

    public function destroyBarp(Request $request, $id)
    {
        $item = Meet::where(DB::raw('md5(id)'), $id)->first();
        Signed::where('head', $item->head)->update(['bak' => null, 'barp' => null]);
        Head::where('head', $item->head)->update(['do' => 0]);
        Meet::where('head', $item->head)->forceDelete();
        Attach::where('head', $item->head)->forceDelete();
        Tax::where('head', $item->head)->forceDelete();
        $item->forceDelete();
        toastr()->success('Hapus Berhasil', ['timeOut' => 5000]);
        return back();
    }
}
