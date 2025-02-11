<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seminar;
use App\Models\User;

class KontenController extends Controller
{
    public function index()
    {
        $seminars = Seminar::all();
        return view ('admin.konten.index', compact('seminars'));
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

    public function destroySeminar(string $id)
    {
        $seminar = Seminar::findOrFail($id);
        $seminar->delete();

        return redirect()->route('konten.index')->with('success', 'Seminar berhasil dihapus');
    }
}

