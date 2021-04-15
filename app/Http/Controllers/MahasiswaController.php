<?php

namespace App\Http\Controllers;
use PDF;
use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\Kelas;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /* Praktikum 7 orm
        //$mahasiswa=Mahasiswa::all()->paginate(1);
        // Mengambil semua isi tabel
        $posts=Mahasiswa::orderBy('nim','asc')->paginate(5);
        //return view('mahasiswas.index',compact('mahasiswa','posts'))->with('i',(request()->input('page',1)-1)*5);
        return view('mahasiswas.index',compact('posts'))->with('i',(request()->input('page',1)-1)*5);

        /* End Praktikum 7 orm

        /* Praktikum 9 Orm Lanjutan */
        $mahasiswa = Mahasiswa::with('kelas')->get();
        $paginate = Mahasiswa::orderBy('nim','asc')->paginate(5);
        return view('mahasiswas.index',['mahasiswa'=>$mahasiswa,'paginate'=>$paginate]);

        /* End */
    }

    /*
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kelas = Kelas::all(); // Mendapatkan data dari tabel kelas
        return view('mahasiswas.create',['kelas' => $kelas]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nim'=>'required',
            'nama'=>'required',
            'jurusan'=>'required',
            'no_handphone'=>'required',
            'email'=>'required',
            'tgl_lahir'=>'required',
            'upload'=>'required'
            ]);

            // $img=$request->image;
            // $image_name=$img->getClientOriginalName();
            $image_name='';

            if($request->file('upload')){
                $image_name= $request->file('upload')->store('images','public');
            }

            $kelas = Kelas::find($request->get('kelas'));
            $mahasiswa = new Mahasiswa();
            $mahasiswa->nim = $request->get('nim');
            $mahasiswa->nama = $request->get('nama');
            $mahasiswa->no_handphone = $request->get('no_handphone');
            $mahasiswa->jurusan = $request->get('jurusan');
            $mahasiswa->email = $request->get('email');
            $mahasiswa->tgl_lahir = $request->get('tgl_lahir');
            $mahasiswa->foto_profile = $image_name;
            // $img->move(public_path().'/img'.$image_name);
            $mahasiswa->kelas()->associate($kelas);
            $mahasiswa->save();

            //jika data berhasil diupdate, akan kembali ke halaman utama
            return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa Berhasil Ditambahkan');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($nim)
    {
        // Prak ORM
        //$mahasiswa=Mahasiswa::find($nim);
        //return view('mahasiswas.detail',compact('mahasiswa'));

        //prak orm lanjutan
        $mahasiswa = Mahasiswa::with('kelas')->where('nim', $nim)->first();
        return view('mahasiswas.detail',['mahasiswa' => $mahasiswa]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($nim)
    {
        //Praktikum orm
        //$mahasiswa=Mahasiswa::find($nim);
        //return view('mahasiswas.edit',compact('mahasiswa'));

        //PRaktikum orm lanjutan
        //Menampilkan detail data dengan menemukan berdasarkan nim mahasiswa untuk diedit
        $mahasiswa = Mahasiswa::with('kelas')->where('nim',$nim)->first();
        $kelas = Kelas::all(); // mendapatkan data dari tabel kelas
        return view ('mahasiswas.edit',compact('mahasiswa','kelas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $nim)
    {
        $request->validate([
            'nama' => 'required',
            'kelas' => 'required',
            'jurusan' => 'required',
            'no_handphone' => 'required'

            ]);

            $kelas = Kelas::find($request->get('kelas'));
            $mahasiswas = Mahasiswa::find($nim);
            $mahasiswas = Mahasiswa::with('kelas')->where('nim', $nim)->first();
            $mahasiswas->nama = $request->get('nama');

            if($mahasiswas->foto_profile && file_exists(storage_path('app/public'.$mahasiswas->foto_profile))){
                Storage::delete('public/'.$mahasiswas->foto_profile);
            }
            $image_name = $request->file('upload')->store('images','public');
            $mahasiswas->foto_profile = $image_name;

            $mahasiswas->jurusan= $request->get('jurusan');
            $mahasiswas->no_handphone= $request->get('no_handphone');
            $mahasiswas->save();

            $kelas = new Kelas;
            $kelas->id = $request->get('kelas');
            //fungsi eloquent untuk menambah data dengan relasi belongto
            $mahasiswas->kelas()->associate($kelas);
            $mahasiswas->save();

            //jika data berhasil diupdate, akan kembali ke halaman utama
            return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($nim)
    {
        Mahasiswa::find($nim)->delete();
        return redirect()->route('mahasiswa.index')->with('success','Mahasiswa Berhasil  Dihapus');
    }

    public function cari (Request $request)
    {

        $cari = $request -> get ('cari');
        $post = DB::table('mahasiswa')->where('nama','like','%'.$cari.'%')->paginate(5);
        return view('mahasiswas.index',['posts' => $post]);

         /*
        // 2 variabel
        $posts = Mahasiswa::when($request->keyword, function ($query) use ($request) {
            $query->where('nama', 'like', "%{$request->keyword}%")
                ->orWhere('nim', 'like', "%{$request->keyword}%");
        })->paginate(5);
        return view('mahasiswas.index',compact('posts'));
        */
    }

    public function nilai($nim){
        $mhs = Mahasiswa::find($nim);
        return view('mahasiswas.nilai',compact('mhs'));
    }

    public function cetak_pdf($nim){
        $mhs = Mahasiswa::with('kelas', 'matakuliah')->find($nim);
        $pdf = PDF::loadview('mahasiswas.nilai_pdf', compact('mhs'));
        return $pdf->stream();

        // return view('mahasiswas.nilai_pdf',compact('mhs'));
    }

}