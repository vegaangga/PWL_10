@extends('mahasiswas.layout')

@section('content')

<div class="container mt-5">
 <div class="row justify-content-center align-items-center">
   <div class="card" style="width: 24rem;">
      <div class="card-header">Edit Mahasiswa</div>
      <div class="card-body">
         @if ($errors->any())
         <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
               @foreach ($errors->all() as $error)
               <li>{{ $error }}</li>
               @endforeach
            </ul>
         </div>
         @endif
         <form method="post" action="{{ route('mahasiswa.update', $mahasiswa->nim) }}" id="myForm" enctype="multipart/form-data">
         @csrf
         @method('PUT')
            <div class="form-group">
               <label for="Nim">Nim</label>
               <br>
               <input type="text" name="nim" class="form-control" id="Nim" disabled value="{{ $mahasiswa->nim }}" aria describedby="Nim" >
            </div>
            <div class="form-group">
               <label for="Nama">Nama</label>
               <br>
               <input type="text" name="nama" class="form-control" id="Nama" value="{{ $mahasiswa->nama }}" aria describedby="Nama" >
            </div>
            <div class="form-group">
               <select name="kelas" class="form-control">
                  @foreach ($kelas as $item)
                  <option value="{{$item->id}}" {{$mahasiswa->kelas_id == $item->id ? 'selected': ''}}>
                     {{$item->nama_kelas}}
                  </option>
                  @endforeach
              </select>
            </div>
            <div class="form-group">
               <label for="Jurusan">Jurusan</label>
               <br>
               <input type="Jurusan" name="jurusan" class="form-control" id="Jurusan" value="{{ $mahasiswa->jurusan }}" aria describedby="Jurusan" >
            </div>
            <div class="form-group">
               <label for="No_Handphone">No_Handphone</label>
               <br>
               <input type="No_Handphone" name="no_handphone" class="form-control" id="No_Handphone" value="{{ $mahasiswa->no_handphone }}" aria describedby="No_Handphone" >
            </div>
            <div class="form-group">
               <label for="email">Email</label>
               <br>
               <input type="Email" name="email" class="form-control" id="email" value="{{ $mahasiswa->email }}" aria describedby="email" >
            </div>
            <div class="form-group">
               <label for="tgl_lahir">Tanggal Lahir</label>
               <br>
               <input type="date" name="tgl_lahir" class="form-control" id="tgl_lahir" value="{{ $mahasiswa->tgl_lahir }}" aria describedby="tgl_lahir" >
            </div>
            <div class="form-group">
               <label for="foto_profile">Upload Foto</label>
               <br>
               <input type="file" class="form-control" required="required" name="upload" value="{{$mahasiswa->foto_profile}}"></br>
               <img width="100px" src="{{asset('storage/'.$mahasiswa->foto_profile)}}">
           </div>
               <button type="submit" class="btn btn-primary">Submit</button>
            </form>
         </div>
      </div>
    </div>
</div>
   @endsection