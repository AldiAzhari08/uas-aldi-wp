@extends('app')
@section('content')
<form action="{{ route('jadwals.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>ID Karyawan:</strong>
                <input type="text" name="no_karyawan" class="form-control" placeholder="Masukan ID karyawan">
                @error('no_karyawan')
                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Tanggal Bekerja:</strong>
                <input type="date" name="tanggal" class="form-control" placeholder="Masukan tanggal">
                @error('name')
                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
            </div>
        </div>


        <!--  -->
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Waktu Mulai Bekerja:</strong>
                <input type="time" name="jam_mulai" class="form-control" placeholder="MAsukan waktu mulai bekerja">
                @error('jam_mulai')
                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Waktu Selesai Bekerja:</strong>
                <input type="time" name="jam_selesai" class="form-control" placeholder="Masukan waktu selesai bekerja">
                @error('jam_selesai')
                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <!--  -->
        <div class="row col-xs-12 col-sm-12 col-md-12 mt-3">
            <div class="col-md-10 form-group">
                <input type="text" name="search" id="search" class="form-control" placeholder="Masukan Nama Karyawan">
                @error('nama_karyawan')
                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-2 form-group text-center">
                <button class="btn btn-secondary" type="button" name="btnAdd" id="btnAdd"><i class="fa fa-plus"></i>Tambah</button>
            </div>
        </div>

        <!--  -->
       <!--  -->
      
        <!--  -->

        <!--  -->
        <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
            <table id="example" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Karyawan</th>
                    <th scope="col">Bagian</th>
                    <th scope="col">Keterangan</th>
                    <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody id="detail">
                    
                </tbody>
            </table>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Jumlah Jadwal :</strong>
                <input type="text" name="jml" class="form-control" placeholder="Jumlah Jadwal">
                @error('tanggal')
                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-3 ml-3">Submit</button>
    </div>
</form>
@endsection
@section('js')
<script type="text/javascript">
    var path = "{{ route('search.karyawan') }}";

    $("#search").autocomplete({
        source: function( request, response ) {
          $.ajax({
            url: path,
            type: 'GET',
            dataType: "json",
            data: {
               search: request.term
            },
            success: function( data ) {
               response( data );
            }
          });
        },
        select: function (event, ui) {
            $('#search').val(ui.item.label);
           console.log($("input[name=jml]").val());
            if($("input[name=jml]").val() > 0){
                for (let i = 1; i <=  $("input[name=jml]").val(); i++) {
                    id = $("input[name=id_karyawan"+i+"]").val();
                    if(id==ui.item.id){
                        alert(ui.item.value+' sudah ada!');
                        break;
                    }else{
                        add(ui.item.id);
                    }
                }
            }else{
                add(ui.item.id);
            } 
           return false;
        }
      });

      function add(id){
        const path = "{{ route('karyawans.index') }}/" + id;
        var html = "";
        var no=0;
        if($('#detail tr').length > 0){
            var html = $('#detail').html();
            no = no+$('#detail tr').length;
        }
        $.ajax({
            url: path,
            type: 'GET',
            dataType: "json",
            success: function( data ) {
                console.log(data); 
                no++;
                html += '<tr>'+
                            '<td>'+no+'<input type="hidden" name="no_ship'+no+'" class="form-control" value="'+data.no_ship+'"></td>'+
                            '<td><input type="text" name="nama_karyawan'+no+'" class="form-control""></td>'+
                            '<td><input type="text" name="bagian'+no+'" class="form-control"></td>'+
                            '<td><input type="text" name="keterangan'+no+'" class="form-control"></td>'+
                            '<td><a href="#" class="btn btn-sm btn-danger">X</a></td>'+
                        '</tr>';
             $('#detail').html(html);
             $("input[name=jml]").val(no);
            }
        });
    }

    // function sumQty(no, q){
    //     var price = $("input[name=price"+no+"]").val();
    //     var subtotal = q*parseInt(price);
    //     $("input[name=sub_total"+no+"]").val(subtotal);
    //     console.log(q+"*"+price+"="+subtotal);
    // }

    // function sumTotal(){
    // var total = 0;
    //     for (let i = 1; i <= $("input[name=jml]").val(); i++) {
    //         var sub = $("input[name=sub_total]"+i+"]").val();
    //         total = total + parseInt(sub);
    //     }
    //     $("input[name=total]").val();
    // }

</script>
@endsection