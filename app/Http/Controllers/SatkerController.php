<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Satker;
use App\Models\Profile;
use App\Models\Issue;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class SatkerController extends Controller
{
    private function checkAccess($satker, $action = 'view')
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        // 1. Super Admin: Bebas melakukan apapun
        if ($user->isSuperAdmin()) return true;

        // 2. Akses READ (Lihat Data)
        if ($action === 'view') {
            if ($user->isManager()) return true; // Manager All-Read Only
            if ($user->isItwil() && $user->wilayah_id == $satker->wilayah_id) return true;
            if ($user->isSatker() && $user->satker_id == $satker->id) return true;
        }

        // 3. Akses UPDATE PROFIL
        if ($action === 'update_profile') {
            if ($user->isManager()) abort(403, 'Manager hanya memiliki akses Read-Only.');
            if ($user->isItwil() && $user->wilayah_id == $satker->wilayah_id) return true;
            if ($user->isSatker() && $user->satker_id == $satker->id) return true;
        }

        // Akses UPDATE ISU (Tambah / Edit Isu)
        if ($action === 'update_issue') {
            if ($user->isManager() || $user->isSatker()) abort(403, 'Akses ditolak.');
            if ($user->isItwil() && $user->wilayah_id == $satker->wilayah_id) return true;
        }

        // 4. Akses DELETE (Hapus Data)
        if ($action === 'delete') {
            if ($user->isManager() || $user->isSatker()) abort(403, 'Akses ditolak. Role Anda tidak bisa menghapus entitas.');
            if ($user->isItwil() && $user->wilayah_id == $satker->wilayah_id) return true;
        }

        // Jika tidak memenuhi syarat di atas, tolak akses
        abort(403, 'Akses Ditolak. Anda tidak memiliki izin untuk mengelola entitas ini.');
    }


    // DASHBOARD UTAMA (Dengan Filter RBAC & Search)
    public function index(Request $request)
    {
        $search = $request->input('search');
        $tipe = $request->input('tipe');
        
        /** @var \App\Models\User $user */
        $user = auth()->user();

        if ($user->isSatker() && $user->satker_id) {
            return redirect('/satker/' . $user->satker_id);
        }

        // Mulai Query
        $query = Satker::where('is_active', true);

        // FILTER DATA BERDASARKAN ROLE USER (Read)
        if ($user->isItwil()) {
            $query->where('wilayah_id', $user->wilayah_id); 
        } elseif ($user->isSatker()) {
            $query->where('id', $user->satker_id);
        }
        // Super Admin & Manager tidak di-filter (Lihat Semua)

        $satkers = $query->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('nama_entitas', 'like', "%{$search}%")
                      ->orWhere('lokasi', 'like', "%{$search}%");
                });
            })
            ->when($tipe, function ($query, $tipe) {
                return $query->where('tipe_entitas', $tipe);
            })
            ->orderBy('nama_entitas', 'asc')
            ->get();

        $unassignedSatkers = Satker::whereNull('wilayah_id')->where('is_active', true)->orderBy('nama_entitas')->get();

        return view('satker.index', compact('satkers', 'unassignedSatkers'));
    }

    // TAMBAH ENTITAS
    public function create()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        
        if (!$user->isSuperAdmin()) {
            abort(403, 'Akses ditolak. Hanya Super Admin yang dapat menambah entitas baru.');
        }

        return view('satker.create');
    }

    // SIMPAN SATKER BARU
    public function store(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        
        if (!$user->isSuperAdmin()) abort(403, 'Akses ditolak. Hanya Super Admin yang dapat menambah entitas baru.');

        $request->validate([
            'nama_entitas' => 'required',
            'tipe_entitas' => 'required',
            'lokasi'       => 'required',
            'wilayah_id'   => 'nullable',
        ]);

        Satker::create([
            'nama_entitas' => $request->nama_entitas,
            'tipe_entitas' => $request->tipe_entitas,
            'lokasi'       => $request->lokasi,
            'wilayah_id'   => $request->wilayah_id,
            'is_active'    => true,
        ]);

        return redirect('/satker')->with('success', 'Entitas baru berhasil ditambahkan!');
    }

    // DETAIL SATKER
    public function show(Request $request, $id)
    {
        $satker = Satker::with(['profile'])->findOrFail($id);
        
        // Cek Hak Akses
        $this->checkAccess($satker, 'view');

        $perPage = $request->get('per_page', 5);
        $statusFilter = $request->get('status');

        $issues = Issue::where('satker_id', $id)
                        ->when($statusFilter, function ($query, $statusFilter) {
                            return $query->where('status', $statusFilter);
                        })
                        ->orderBy('updated_at', 'desc')
                        ->paginate($perPage)
                        ->withQueryString();

        /** @var \App\Models\User $user */
        $user = auth()->user();

        if ($user->isSatker()) {
            $satkers = collect([]); // Kosongkan untuk menyembunyikan sidebar
        } else {
            $query = Satker::where('is_active', true);
            if ($user->isItwil()) {
                $query->where('wilayah_id', $user->wilayah_id);
            }
            $satkers = $query->orderBy('nama_entitas', 'asc')->get(); 
        }

        return view('satker.show', compact('satker', 'satkers', 'issues'));
    }

    // EXPORT PDF
    public function exportPdf($id)
    {
        $satker = Satker::with(['profile'])->findOrFail($id);
        
        // Cek Hak Akses
        $this->checkAccess($satker, 'view');

        $issues = Issue::where('satker_id', $id)->get();

        $pdf = Pdf::loadView('satker.pdf', compact('satker', 'issues'));
        
        return $pdf->stream('Profil_Satker_' . str_replace(' ', '_', $satker->nama_entitas) . '.pdf');
    }

    // EDIT PROFIL
    public function editProfile($satker_id)
    {
        $satker = Satker::with('profile')->findOrFail($satker_id);
        
        // Cek Hak Akses
        $this->checkAccess($satker, 'update_profile');

        return view('profile.edit', compact('satker'));
    }

    // SIMPAN PERUBAHAN PROFIL
    public function updateProfile(Request $request, $satker_id)
    {
        $satker = Satker::findOrFail($satker_id);
        
        // Cek Hak Akses
        $this->checkAccess($satker, 'update_profile');

        $satker->update([
            'jumlah_hs' => $request->jumlah_hs,
            'jumlah_ls' => $request->jumlah_ls,
        ]);

        $dataProfile = [
            'satker_id'   => $satker->id,
            'kontak'      => $request->kontak,
            'kepala_nama' => $request->kepala_nama,
            'kepala_telp' => $request->kepala_telp,
            'hoc_nama'    => $request->hoc_nama,
            'hoc_telp'    => $request->hoc_telp,
            'ppk_nama'    => $request->ppk_nama,
            'ppk_telp'    => $request->ppk_telp,
            'bpkrt_nama'  => $request->bpkrt_nama,
            'bpkrt_telp'  => $request->bpkrt_telp,
        ];

        if (!auth()->user()->isSatker()) {
            $dataProfile['tahun_audit'] = $request->tahun_audit;
            $dataProfile['status_rr']   = $request->status_rr;
            $dataProfile['area_resiko'] = $request->area_resiko;
            $dataProfile['temuan']      = $request->temuan;
        }

        Profile::updateOrCreate(['satker_id' => $satker->id], $dataProfile);

        return redirect('/satker/' . $satker_id)->with('success', 'Profil perwakilan berhasil diperbarui!');
    }
   
    // SIMPAN ISU BARU
    public function storeIssue(Request $request, $satker_id) 
    {
        $satker = Satker::findOrFail($satker_id);
        
        // Cek Hak Akses
        $this->checkAccess($satker, 'update_issue');

        $request->validate([
            'kategori'      => 'required',
            'deskripsi_isu' => 'required',
            'status'        => 'required'
        ]);

        /** @var \App\Models\User $user */
        $user = auth()->user();

        Issue::create([
            'satker_id'     => $satker_id,
            'kategori'      => $request->kategori,
            'deskripsi_isu' => $request->deskripsi_isu,
            'tindak_lanjut' => $request->tindak_lanjut,
            'status'        => $request->status,
            'update_oleh'   => $user->name // Menyimpan nama user yang update
        ]);

        return back()->with('success', 'Isu baru berhasil ditambahkan!');
    }

    // SOFT DELETE
    public function destroy($id)
    {
        $satker = Satker::findOrFail($id);
        
        // Cek Hak Akses
        $this->checkAccess($satker, 'delete');

        $satker->update([
            'is_active' => false
        ]);

        return redirect('/satker')->with('success', 'Entitas telah berhasil dinonaktifkan dari daftar.');
    }

    // UPDATE DATA ISU (FULL EDIT)
    public function updateIssue(Request $request, $id)
    {
        $issue = Issue::findOrFail($id);
        $satker = Satker::findOrFail($issue->satker_id);
        
        // Cek Hak Akses
        $this->checkAccess($satker, 'update_issue');

        $request->validate([
            'kategori'      => 'required',
            'deskripsi_isu' => 'required',
            'status'        => 'required'
        ]);

        $issue->update([
            'kategori'      => $request->kategori,
            'deskripsi_isu' => $request->deskripsi_isu,
            'tindak_lanjut' => $request->tindak_lanjut,
            'status'        => $request->status,
        ]);

        return back()->with('success', 'Isu berhasil diperbarui!');
    }

    // ASSIGN ITWIL (Hanya Super Admin)
    public function assignItwil(Request $request, $id)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        
        if (!$user->isSuperAdmin()) abort(403, 'Akses ditolak. Hanya Super Admin yang dapat menugaskan Itwil.');

        $request->validate([
            'wilayah_id' => 'required'
        ]);

        $satker = Satker::findOrFail($id);
        $satker->update([
            'wilayah_id' => $request->wilayah_id
        ]);

        return back()->with('success', 'Penanggungjawab Itwil berhasil diperbarui!');
    }

    // KLAIM SATKER (Hanya Itwil)
    public function claimSatker(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        
        if (!$user->isItwil()) abort(403, 'Akses ditolak. Hanya Itwil yang dapat melakukan klaim satker.');

        $request->validate([
            'satker_id' => 'required|exists:satkers,id'
        ]);

        $satker = Satker::findOrFail($request->satker_id);

        if ($satker->wilayah_id !== null) {
            return back()->with('error', 'Satker ini sudah diklaim oleh wilayah lain.');
        }

        $satker->update([
            'wilayah_id' => $user->wilayah_id
        ]);

        return back()->with('success', 'Satker berhasil diklaim ke dalam pengawasan Anda!');
    }
}