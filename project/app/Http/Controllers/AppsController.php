<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DataTables;
use App\Models\Apps;

class AppsController extends Controller
{
  /**
   * Datatables user server side process
   * 
   * @param Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function dataTable(Request $request)
  {
    if ($request->ajax()) {
      $datas = Apps::all();
      return DataTables::of($datas)
        ->addIndexColumn() //memberikan penomoran
        ->addColumn('status_apps', function ($row) {
          $status_apps = $row->status == 'Aktif' ? '<span class="badge bg-success">' . strtolower($row->status) . '</span>' : '<span class="badge bg-dark">' . strtolower($row->status) . '</span>';

          return $status_apps;
        })
        ->addColumn('corp_apps', function ($row) {
          $corp_apps = $row->corp_apps == 'MAS' ? 'PT. MULTI ARTA SEKAWAN' : 'PT. MULTI ARTA INDUSTRI';

          return $corp_apps;
        })
        ->addColumn('action', function ($row) {
          $new_tab = "'" . $row->link_apps . "', '_blank'";
          $btn = '<button onclick="edit_data(' . "'" . $row->id . "'" . ')" class="edit btn btn-warning btn-sm mr-2">edit</button>';
          $btn = $btn . '<button onclick="hapus_data(' . "'" . $row->id . "'" . ');" class="edit btn btn-danger btn-sm mr-2">delete</button>';
          $btn = $btn . '<button onclick="window.open(' . $new_tab . ')" class="edit btn btn-info btn-sm">view</button>';

          return $btn;
        })
        ->rawColumns(['action', 'status_apps', 'corp_apps'])
        ->escapeColumns()  //mencegah XSS Attack
        ->toJson(); //merubah response dalam bentuk Json
    }
  }

  public function list()
  {
    $list = Apps::select('id', 'nama_apps', 'link_apps', 'deskripsi', 'corp_apps')
      ->where('status', 'Aktif')
      ->orderBy('corp_apps', 'desc')
      ->get();

    return response()->json([
      'code'        => 200,
      'status'      => "success",
      'message'     => "Data berhasil ditampilkan",
      'data'        => $list
    ], 200);
  }

  public function save(Request $request)
  {
    $input_request = $request->input();
    $validator = Validator::make($input_request, [
      'nama_apps'  => 'required|min:4',
      'link_apps'  => 'required|min:5',
      'deskripsi'  => 'required|min:15',
      'milik'  => 'required',
      'aktivasi'  => 'required'
    ]);

    if ($validator->fails()) {
      return response()->json(
        [
          'error_string' => $validator->errors()->all(),
          'inputerror' => $validator->errors()->keys()
        ]
      );
    }

    $insert = Apps::create([
      'nama_apps'   => $request->input('nama_apps'),
      'link_apps'   => $request->input('link_apps'),
      'deskripsi'   => $request->input('deskripsi'),
      'corp_apps'   => $request->input('milik'),
      'status'      => $request->input('aktivasi'),
      'create_date' => date('Y-m-d H:i:s'),
      'create_by'   => Auth()->user()->id,
    ]);

    if ($insert) {
      return response()->json([
        'code'        => 200,
        'status'      => "success",
        'message'     => "Data berhasil disimpan",
        'data'        => $insert
      ], 200);
    } else {
      return response()->json([
        'code'        => 500,
        'status'      => "error",
        'message'     => "Data gagal disimpan",
        'data'        => $insert
      ], 500);
    }
  }

  public function edit(Request $request)
  {
    $data = Apps::where('id', $request->post('id'))->first();
    return response()->json([
      'code'        => 200,
      'status'      => "success",
      'message'     => "data berhasil ditemukan",
      'data'        => $data,
    ], 200);
  }

  public function hapus(Request $request)
  {
    $exec = Apps::where('id', $request->post('id'))->delete();
    if ($exec) {
      return response()->json([
        'code'        => 200,
        'status'      => "success",
        'message'     => "Data berhasil dihapus",
        'data'        => $exec
      ], 200);
    } else {
      return response()->json([
        'code'        => 500,
        'status'      => "error",
        'message'     => "Data gagal dihapus",
        'data'        => $exec
      ], 500);
    }
  }

  public function update(Request $request)
  {
    $input_request = $request->input();
    $validator = Validator::make($input_request, [
      'nama_apps'  => 'required|min:4',
      'link_apps'  => 'required|min:5',
      'deskripsi'  => 'required|min:15',
      'milik'  => 'required',
      'aktivasi'  => 'required'
    ]);

    if ($validator->fails()) {
      return response()->json(
        [
          'error_string' => $validator->errors()->all(),
          'inputerror' => $validator->errors()->keys()
        ]
      );
    }

    $update = Apps::where('id', $request->post('id'))
      ->update([
        'nama_apps'   => $request->input('nama_apps'),
        'link_apps'   => $request->input('link_apps'),
        'deskripsi'   => $request->input('deskripsi'),
        'corp_apps'   => $request->input('milik'),
        'status'      => $request->input('aktivasi'),
        'update_date' => date('Y-m-d H:i:s'),
        'update_by'   => Auth()->user()->id,
      ]);

    if ($update) {
      return response()->json([
        'code'        => 200,
        'status'      => "success",
        'message'     => "Data berhasil diupdate",
        'data'        => $update
      ], 200);
    } else {
      return response()->json([
        'code'        => 500,
        'status'      => "error",
        'message'     => "Data gagal diupdate",
        'data'        => $update
      ], 500);
    }
  }
}
