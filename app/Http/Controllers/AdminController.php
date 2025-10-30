<?php

namespace App\Http\Controllers;

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    private $baseUrl = "https://starter-kit-larvel12.vercel.app/api/api/users";
    // private $baseUrl = "http://127.0.0.1:8000/api/users";

    // Dashboard
    public function index()
    {
        return view('dashboard');
    }

    // List Admin
    public function list()
    {
        $token = Session::get('api_token');
        $response = Http::withToken($token)->get($this->baseUrl);

        if ($response->successful()) {
            $json = $response->json();
            $admins = $json['data'] ?? []; // ambil array di dalam key "data"
        } else {
            $admins = [];
        }

        return view('admins.index', ['admins' => $admins]);
    }

    public function downloadSk($id)
    {
        $token = Session::get('api_token');
        $response = Http::withToken($token)->get($this->baseUrl . '/' . $id);

        if (!$response->successful()) {
            return back()->with('error', 'Gagal mengambil data admin');
        }

        $data = $response->json()['data'] ?? null;

        if (!$data) {
            return back()->with('error', 'Data admin tidak ditemukan');
        }

        // === MULAI BUAT FILE WORD ===
        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        // Header surat
        $header = $section->addTextRun(['alignment' => 'center']);
        $header->addText('KEMENTERIAN TEKNOLOGI DAN INFORMASI', ['bold' => true, 'size' => 14]);
        $header->addTextBreak();
        $header->addText('Jl. Raya Teknologi No. 10, Palembang 30111', ['size' => 11]);
        $header->addText('Telp. (0711) 123456 | Email: info@kemeninfo.go.id', ['size' => 11]);
        $section->addLine(['weight' => 1, 'width' => 450, 'height' => 0, 'color' => '#000000']);

        $section->addTextBreak(1);

        // Judul surat
        $section->addText(
            'SURAT KEPUTUSAN (SK)',
            ['bold' => true, 'size' => 14],
            ['alignment' => 'center']
        );
        $section->addText(
            'Nomor: SK-' . strtoupper(substr($data['first_name'], 0, 2)) . '/' . date('Y'),
            ['italic' => true, 'size' => 12],
            ['alignment' => 'center']
        );
        $section->addTextBreak(2);

        // Isi surat
        $section->addText('Menimbang:', ['bold' => true]);
        $section->addText('Bahwa yang bersangkutan dinilai layak untuk diberikan Surat Keputusan berdasarkan prestasi kerja.');

        $section->addTextBreak(1);
        $section->addText('MEMUTUSKAN:', ['bold' => true]);
        $section->addText('Memberikan penugasan resmi kepada:');
        $section->addTextBreak(1);

        // Nama admin dari JSON
        $section->addText('Nama Lengkap  : ' . $data['first_name'] . ' ' . $data['last_name']);
        $section->addText('Email         : ' . $data['email']);
        $section->addText('Tanggal SK    : ' . now()->format('d M Y'));
        $section->addTextBreak(2);

        $section->addText('Untuk melaksanakan tugas dan tanggung jawab sesuai dengan jabatan yang diberikan.');
        $section->addTextBreak(3);

        // Footer tanda tangan
        $section->addText('Ditetapkan di Palembang, ' . now()->format('d F Y'), ['alignment' => 'right']);
        $section->addText('Kepala Dinas Teknologi dan Informasi', ['alignment' => 'right']);
        $section->addTextBreak(3);
        $section->addText('(___________________)', ['alignment' => 'right']);

        // Simpan file sementara
        $fileName = 'Surat-SK-' . $data['first_name'] . '-' . $data['last_name'] . '.docx';
        $tempFile = tempnam(sys_get_temp_dir(), $fileName);
        $writer = IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save($tempFile);

        return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);
    }

    // Show Create Form
    public function create()
    {
        return view('admins.create');
    }

    // Store Admin
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'     => 'required|email|max:255',
            'birth_date' => 'required|date',
            'gender'    => 'required|in:male,female',
            'password'   => 'nullable|string|min:6',
            'password_confirmation' => 'nullable|string|min:6',
        ]);

        $token = Session::get('api_token');
        Http::withToken($token)->post("{$this->baseUrl}", $request->all());
        return redirect()->route('admins.list')->with('success', 'Admin berhasil ditambahkan.');
    }

    // Show Edit Form
    public function edit($id)
    {
        $token = Session::get('api_token');
        $response = Http::withToken($token)->get("{$this->baseUrl}/{$id}");

        if ($response->successful()) {
            $json = $response->json();
            $admin = $json['data'] ?? $json; // jaga-jaga kalau API balikin langsung data tunggal
        } else {
            return redirect()->route('admins.list')->withErrors(['error' => 'Gagal mengambil data admin.']);
        }

        return view('admins.edit', compact('admin'));
    }

    // Update Admin
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'first_name' => 'nullable|string|max:255',
            'last_name'  => 'nullable|string|max:255',
            'email'      => 'nullable|email|max:255',
            'birth_date' => 'nullable|date',
            'gender'     => 'nullable|string',
            'password'   => 'nullable|string|min:6|confirmed',
            'password_confirmation' => 'nullable|string|min:6',
        ]);

        $token = Session::get('api_token');
        $response = Http::withToken($token)->put("{$this->baseUrl}/{$id}", $validated);
        if (!$response->successful()) {
            return back()->withErrors(['error' => 'Gagal memperbarui admin.']);
        }

        return redirect()->route('admins.list')->with('success', 'Admin berhasil diperbarui.');
    }

    // Delete Admin
    public function destroy($id)
    {
        $token = Session::get('api_token');
        Http::withToken($token)->delete("{$this->baseUrl}/$id");

        return redirect()->route('admins.list')->with('success', 'Admin berhasil dihapus.');
    }
}
