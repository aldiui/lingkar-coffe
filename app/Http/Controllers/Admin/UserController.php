<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use ApiResponder;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::all();
            if ($request->mode == "datatable") {
                return DataTables::of($users)
                    ->addColumn('aksi', function ($user) {
                        $editButton = '<button class="btn btn-sm btn-warning  d-inline-flex me-1" onclick="getModal(`createModal`, `/admin/user/' . $user->id . '`, [`id`, `nama`, `email`, `role`])"><i class="bi bi-pencil-square me-1"></i>Edit</button>';
                        $deleteButton = '<button class="btn btn-sm btn-danger d-inline-flex" onclick="confirmDelete(`/admin/user/' . $user->id . '`, `user-table`)"><i class="bi bi-trash me-1"></i>Hapus</button>';
                        return $editButton . $deleteButton;
                    })
                    ->addIndexColumn()
                    ->rawColumns(['aksi'])
                    ->make(true);
            }
            return $this->successResponse($request->all());
        }
        return view('admin.user.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'role' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid', 422);
        }

        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return $this->successResponse($user, 'User baru telah ditambahkan.', 201);
    }

    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return $this->errorResponse(null, 'Data User tidak ditemukan.', 404);
        }

        return $this->successResponse($user, 'Data User telah ditemukan.');
    }

    public function update(Request $request, $id)
    {
        $dataValidator = [
            'nama' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required',
        ];

        if ($request->password != null) {
            $dataValidator['password'] = 'required|min:8|confirmed';
        }

        $validator = Validator::make($request->all(), $dataValidator);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid', 422);
        }

        $user = User::find($id);

        if (!$user) {
            return $this->errorResponse(null, 'Data User tidak ditemukan.', 404);
        }

        $user->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        if ($request->password != null) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return $this->successResponse($user, 'Data User telah diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return $this->errorResponse(null, 'Data User tidak ditemukan.', 404);
        }

        $user->delete();

        return $this->successResponse(null, 'Data User telah dihapus.');
    }
}
