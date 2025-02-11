<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proyek;
use App\Models\Seminar;
use App\Models\User;

class KontenController extends Controller
{
    public function index()
    {
        $seminars = Seminar::all();
        $proyeks = Proyek::with('dosenPembimbing')->get();
        return view ('admin.konten.index', compact('seminars', 'proyeks'));
    }
    public function show(string $id)
    {
        //
    }
    public function editSeminar($id)
    {
        $seminar = Seminar::findOrFail($id);
        return view('admin.konten.editSeminar', compact('seminar'));
    }

    public function updateSeminar(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'tanggal_seminar' => 'required|date',
            'deadline_pendaftaran' => 'required|date',
            'kuota' => 'required|integer',
            'link_seminar' => 'nullable|string',
        ]);

        $seminar = Seminar::findOrFail($id);
        $seminar->update($request->all());

        return redirect()->route('konten.index')->with('success', 'Seminar berhasil diperbarui');
    }

    public function editProyek($id)
    {
        $proyek = Proyek::findOrFail($id);
        $dosens = User::where('peran', 'dosen')->get();
        return view('admin.konten.editProyek', compact('proyek', 'dosens'));
    }

    public function updateProyek(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'tanggal_proyek' => 'required|date',
            'deadline_pendaftaran' => 'required|date',
            'kuota' => 'required|integer',
            'dosen_pembimbing_id' => 'nullable|exists:users,id'
        ]);

        $proyek = Proyek::findOrFail($id);
        $proyek->update($request->all());

        return redirect()->route('konten.index')->with('success', 'Proyek berhasil diperbarui');
    }
    public function destroySeminar(string $id)
    {
        $seminar = Seminar::findOrFail($id);
        $seminar->delete();

        return redirect()->route('konten.index')->with('success', 'Seminar berhasil dihapus');
    }

    public function destroyProyek(string $id)
    {
        $proyek = Proyek::findOrFail($id);
        $proyek->delete();

        return redirect()->route('konten.index')->with('success', 'Proyek berhasil dihapus');
    }
}

