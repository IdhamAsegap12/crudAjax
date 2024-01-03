<script>
    // Isi Table
    let table = new DataTable('#myTable', {
        processing: true,
        serverside: true,
        ajax: "{{ url('pegawaiAjax') }}",
        columns: [{
            data: 'DT_RowIndex',
            name: 'DT_RowIndex',
            orderable: false,
            searchable:false
        },
        {
            data: 'nama',
            name: 'Nama'
        },
        {
            data: 'email',
            name: 'Email'
        },
        {
            data: 'aksi',
            name: 'Aksi'
        }
    ]
    });

    // GLOBAL_SETUP
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Tambah
    $('body').on('click', '#tombol-tambah', function(e){
        e.preventDefault()
        $('#exampleModal').modal('show');

        // simpan
        $('#simpan').click(()=>{
            $.ajax({
                url: 'pegawaiAjax',
                type: 'POST',
                data: {
                    nama : $('#nama').val(),
                    email : $('#email').val()
                },
                success:function(response){
                   if(response.errors){
                        console.log(response.errors)
                        $('.alert-danger').removeClass('d-none');
                        $('.alert-danger').html("<ul>");
                        $.each(response.errors, function(key, value){
                            $('.alert-danger').find('ul').append("<li>"+ value+"</li>");
                        });
                        $('.alert-danger').append("</ul>");
                   } else {
                        $('.alert-success').removeClass('d-none');
                        $('.alert-success').html(response.success);
                   }
                   $('#myTable').DataTable().ajax.reload();
                }
            })
            
        })
    });

    // Edit
    $('body').on('click', '.tmbl-edit', function(){
        var id = $(this).data('id')
        $.ajax({
            url : 'pegawaiAjax/'+id+'/edit',
            tye : 'GET',
            success: function(response){
                $('#exampleModal').modal('show');
                $('#nama').val(response.result.nama)
                $('#email').val(response.result.email)
            }
        })
        $('#simpan').click(()=>{
            $.ajax({
                url: 'pegawaiAjax/'+id,
                type: 'PUT',
                data: {
                    nama: $('#nama').val(),
                    email: $('#email').val()
                },
                success: function(response){
                    console.log(response.errors)
                }
            })
        })
    })

    $('body').on('click', '.tmbl-hapus', function(){
        confirm('Yakin mo di hapus?')
        var id = $(this).data('id')
        $.ajax({
            url: 'pegawaiAjax/'+id,
            type: 'DELETE',
            success: function(response){
                if(response.success){
                    alert(response.success)
                } else {
                    alert('gagal')
                }
            }
        })
    })

    $('#exampleModal').on('hidden.bs.modal', function() {
        $('#nama').val('')
        $('#email').val('')

        $('.alert-danger').addClass('d-none')
        $('.alert-danger').html('')
        $('.alert-success').addClass('d-none')
        $('.alert-success').html('')
    });
</script>