@extends('app')
@section('content')
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
  {{session('success')}}
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
</div>
@endif
<div class="text-end mb-2">

  <a class="btn btn-success" href="{{ route('jadwals.create') }}"> Add Karyawan</a>
</div>
<table id="example" class="table table-striped" style="width:100%">
  <thead>
    <tr>
      <th scope="col">No</th>
      <th scope="col">ID Karyawan</th>
      <th scope="col">Tanggal Kerja</th>
      <th scope="col">Waktu Mulai Kerja</th>
      <th scope="col">Waktu Selesai Kerja</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    @php $no = 1 @endphp
    @foreach ($jadwals as $data)
    <tr>
      <td>{{ $no ++ }}</td>
      <!-- <td>{{ $data->id }}</td> -->
      <td>{{ $data->no_karyawan }}</td>
      <td>{{ $data->tanggal }}</td>
      <td>{{ $data->jam_mulai }}</td>
      <td>{{ $data->jam_selesai }}</td>
        
      <td>
        <form action="{{ route('jadwals.destroy',$data->id) }}" method="Post">
          <a class="btn btn-primary" href="{{ route('jadwals.edit',$data->id) }}">Edit</a>
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger">Delete</button>
        </form>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
@endsection
@section('js')
<script>
  $(document).ready(function() {
    $('#example').DataTable();
  });
</script>
@endsection