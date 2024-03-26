<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HargaJual;
use App\Models\User;
use App\Traits\ApiResponder;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MitraController extends Controller
{
    use ApiResponder;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::where('role', 'user')->get();
            if ($request->mode == "datatable") {
                return DataTables::of($users)
                    ->addColumn('aksi', function ($user) {
                        $editButton = '<button class="btn btn-sm btn-warning me-1" onclick="getModal(`createModal`, `/admin/mitra/' . $user->id . '`, [`id`, `nama`, `email`])"><i class="fas fa-pencil-alt"></i></button>';
                        $deleteButton = '<button class="btn btn-sm btn-danger " onclick="confirmDelete(`/admin/mitra/' . $user->id . '`, `stok-table`)"><i class="fas fa-trash"></i></button>';
                        return $editButton . $deleteButton;
                    })
                    ->addIndexColumn()
                    ->rawColumns(['aksi'])
                    ->make(true);
            }
        }
        return view('pages.admin.mitra.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid', 422);
        }

        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'user',
        ]);

        HargaJual::create([
            'user_id' => $user->id,
            'harga_pokok_id' => '1',
            'harga_jual' => '0',
        ]);

        return $this->successResponse($user, 'Data Mitra ditambahkan.');

    }

    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return $this->errorResponse(null, 'Data Mitra tidak ditemukan.', 404);
        }

        return $this->successResponse($user, 'Data Mitra ditemukan.');
    }

    public function update(Request $request, $id)
    {
        $dataValidator = [
            'nama' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
        ];

        if ($request->password != null) {
            $dataValidator['password'] = 'required|min:8|confirmed';
        }

        $validator = Validator::make($request->all(), $dataValidator);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }

        $user = User::find($id);

        if (!$user) {
            return $this->errorResponse(null, 'Data Mitra tidak ditemukan.', 404);
        }

        $updateUser = [
            'nama' => $request->nama,
            'email' => $request->email,
        ];

        if ($request->password != null) {
            $updateAdmin['password'] = bcrypt($request->password);
        }

        $user->update($updateUser);

        return $this->successResponse($user, 'Data Mitra diubah.');

    }

    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return $this->errorResponse(null, 'Data Mitra tidak ditemukan.', 404);
        }

        $user->delete();

        return $this->successResponse(null, 'Data Mitra  dihapus.');
    }

}
