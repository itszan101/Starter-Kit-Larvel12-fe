<?php

namespace App\Http\Controllers;

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    private $userUrl = "https://starter-kit-larvel12.vercel.app/api/api/users";
    // private $userUrl = "http://127.0.0.1:8000/api/users";
    private $rolesUrl = "https://starter-kit-larvel12.vercel.app/api/api/roles";
    // private $rolesUrl = "http://127.0.0.1:8000/api/roles";

    // Dashboard
    public function index()
    {
        return view('dashboard');
    }

    // List Admin
    public function list()
    {
        $token = Session::get('api_token');

        // Ambil daftar admin
        $responseAdmins = Http::withToken($token)
            ->accept('application/json')
            ->get($this->userUrl); //

        $admins = [];
        if ($responseAdmins->successful()) {
            $json = $responseAdmins->json();
            $admins = $json['data'] ?? $json ?? [];
        }

        // Ambil daftar role yang tersedia
        $responseRoles = Http::withToken($token)
            ->accept('application/json')
            ->get($this->rolesUrl);

        $availableRoles = [];
        if ($responseRoles->successful()) {
            $json = $responseRoles->json();

            $availableRoles = $json['roles'] ?? $json ?? [];
        }
        // dd($availableRoles);
        return view('admins.index', compact('admins', 'availableRoles'));
    }

    // Show Create Form
    public function create()
    {
        return view('admins.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|max:255',
            'birth_date' => 'required|date',
            'gender'     => 'required|in:male,female',
            'password'   => 'required|string|min:6|confirmed',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $token = Session::get('api_token');

        // Siapkan multipart form
        $multipart = [
            ['name' => 'first_name', 'contents' => $validated['first_name']],
            ['name' => 'last_name',  'contents' => $validated['last_name']],
            ['name' => 'email',      'contents' => $validated['email']],
            ['name' => 'birth_date', 'contents' => $validated['birth_date']],
            ['name' => 'gender',     'contents' => $validated['gender']],
            ['name' => 'password',   'contents' => $validated['password']],
            ['name' => 'password_confirmation', 'contents' => $request->password_confirmation],
        ];

        // Tambahkan file jika ada
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $multipart[] = [
                'name' => 'profile_picture',
                'contents' => fopen($file->getPathname(), 'r'),
                'filename' => $file->getClientOriginalName(),
            ];
        }

        // Kirim ke backend
        $response = Http::withToken($token)
            ->accept('application/json')
            ->asMultipart()
            ->post($this->userUrl, $multipart);

        // Tangani response sukses, termasuk kasus restore
        if ($response->successful()) {
            $message = $response->json('message') ?? 'Admin berhasil ditambahkan!';
            return redirect()
                ->route('admins.list')
                ->with('success', $message);
        }

        // Tangani error validasi atau email sudah aktif
        if ($response->status() === 422) {
            $errorMessage = $response->json('message') ?? 'Validasi gagal.';
            return back()
                ->with('error', $errorMessage)
                ->withInput();
        }

        // Tangani error umum lain
        $errorMessage = $response->json('message') ?? 'Gagal menambahkan admin.';
        return back()
            ->with('error', $errorMessage)
            ->withInput();
    }

    // Show Edit Form
    public function edit($id)
    {
        $token = Session::get('api_token');
        $response = Http::withToken($token)->get("{$this->userUrl}/{$id}");

        if ($response->successful()) {
            $json = $response->json();
            $admin = $json['data'] ?? $json; // jaga-jaga kalau API balikin langsung data tunggal
        } else {
            return redirect()->route('admins.list')->withErrors(['error' => 'Gagal mengambil data admin.']);
        }
        // dd($admin);
        return view('admins.edit', compact('admin'));
    }

    // Update Admin
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|max:255',
            'gender'     => 'required|in:male,female',
            'password'   => 'nullable|string|min:6|confirmed',
            'password_confirmation' => 'nullable|string|min:6',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
        $multipart = [];
        $multipart[] = [
            'name' => '_method',
            'contents' => 'PUT',
        ];
        foreach (['first_name', 'last_name', 'email', 'gender'] as $key) {
            $multipart[] = [
                'name' => $key,
                'contents' => (string) ($request->input($key) ?? ''),
            ];
        }
        // password hanya jika diisi (jangan kirim password kosong)
        if ($request->filled('password')) {
            $multipart[] = [
                'name' => 'password',
                'contents' => $request->input('password'),
            ];
            $multipart[] = [
                'name' => 'password_confirmation',
                'contents' => $request->input('password_confirmation') ?? '',
            ];
        }
        // tambahkan file jika ada
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $multipart[] = [
                'name' => 'profile_picture',
                'contents' => fopen($file->getRealPath(), 'r'),
                'filename' => $file->getClientOriginalName(),
            ];
        }
        $token = Session::get('api_token');
        try {
            // Kunci: gunakan post() bukan put(), tambahkan _method=PUT di multipart
            $response = Http::withToken($token)
                ->acceptJson()
                ->asMultipart()
                ->post("{$this->userUrl}/{$id}", $multipart);

            if ($response->successful()) {
                $message = $response->json('message') ?? 'Admin berhasil diperbarui.';
                return redirect()->route('admins.list')->with('success', $message);
            }

            $message = $response->json('message') ?? 'Gagal memperbarui admin.';
            return redirect()->back()->with('error', $message)->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    // Delete Admin
    public function destroy($id)
    {
        $token = Session::get('api_token');
        Http::withToken($token)->delete("{$this->userUrl}/$id");

        return redirect()->route('admins.list')->with('success', 'User berhasil dihapus');
    }

    public function downloadSk($id)
    {
        $token = Session::get('api_token');
        $response = Http::withToken($token)->get($this->userUrl . '/' . $id);

        if (!$response->successful()) {
            return back()->with('error', 'Gagal mengambil data admin');
        }

        $data = $response->json();
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
}
