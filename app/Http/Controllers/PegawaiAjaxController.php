<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Pegawai;
use Illuminate\Support\Facades\Validator;

class PegawaiAjaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Pegawai::orderBy('nama', 'asc');
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('aksi', function($data){
                return view('pegawai.tombol')->with('data', $data);
            })
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validasi = Validator::make($request->all(),
        [
            'nama' => 'required',
            'email' => 'required|email'
        ],
        [
            'nama.required' => 'Nama tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Email harus email',
        ]);

        if($validasi->fails()){
            return response()->json(['errors' => $validasi->errors()]);
        } else {

            $data = [
                'nama' => $request->nama,
                'email' => $request->email
            ];
            Pegawai::create($data);

            return response()->json(['success' => "Berhasil menyimpan"]);
            
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Pegawai::find($id);

        return response()->json(['result'=> $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validasi = Validator::make($request->all(),[
            'nama' => 'required',
            'email' => 'required|email'
        ],
        [
            'nama.required' => 'Nama gaboleh kosong om',
            'email.required' => 'Email gaboleh kosong om',
            'email.email' => 'Email harus format email ya bro',
        ]);

        if($validasi->fails()){
            return response()->json(['errors'=> $validasi->errors()]);
        } else{

            $data = [
                'nama' => $request->nama,
                'email' => $request->email
            ];
    
            Pegawai::where('id', $id)->update($data);

            return response()->json(['success'=> 'Berhasil oyy']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Pegawai::find($id);

        $data->delete();

        return response()->json(['success'=> 'Data berhasil di hapus om']);
    }
}
