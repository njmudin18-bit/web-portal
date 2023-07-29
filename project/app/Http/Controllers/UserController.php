<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\User;

class UserController extends Controller
{
  /**
   * Menampilkan halaman tabel user
   * 
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return view('auth/users');
  }

  /**
   * Datatables user server side process
   * 
   * @param Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function dataTable(Request $request)
  {
    if ($request->ajax()) {
      $users = User::all();
      return DataTables::of($users)
        ->addIndexColumn()
        ->make();


      // $datas = User::all();
      // return DataTables::of($datas)
      //   ->addIndexColumn() //memberikan penomoran
      //   ->addColumn('nama', function ($row) { //menambahkan column baru pada yajra datatable
      //     $nama = $row->first_name . ' ' . $row->last_name;
      //     return $nama;
      //   })
      //   ->addColumn('action', function ($row) {
      //     $enc_id = \Crypt::encrypt($row->id);
      //     $btn = '<a href="#" class="edit btn btn-sm btn-primary" > <i class="fas fa-edit"></i> Edit</a>
      //                       <a href="#" class="hapus btn btn-sm btn-danger"> <i class="fas fa-trash"></i> Hapus</a>';
      //     return $btn;
      //   })
      //   ->rawColumns(['action'])   //merender content column dalam bentuk html
      //   ->escapeColumns()  //mencegah XSS Attack
      //   ->toJson(); //merubah response dalam bentuk Json
    }
  }
}
