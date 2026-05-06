let table;
$(function () {
    table = $('#permission').DataTable({
        "language": {
        "zeroRecords": "No record(s) found.",
         searchPlaceholder: "Search records"
      },
        ajax:{
            url:site_url+"/admin/permission",
        },
        dataType: 'html',
        columns: [
            {data: 'DT_RowIndex' ,name:'DT_RowIndex',searching: false,orderable: false},
            {data: 'name',name: 'name',orderable: false},
            {data: 'action', name: 'action',orderable: false},
        ]
    });
    $.fn.dataTable.ext.errMode = 'none';
    $('#permission').on('error.dt', function(e, settings, techNote, message) {
       console.log( 'An error has been reported by DataTables: ', message);
    })
    $('.menu-item').on('click',function(){
        try {
            table.state.clear();
        }
        catch(err) {
            console.log(err.message);
        }
    })
    $(".search").on('click',function(){
        table.draw();
    })
  });

$("#permission-create").on("submit",function(e){
    e.preventDefault();
    
    showLoader();
    $.ajax({
        url:site_url+"/admin/permission/store",
        type:"POST",
        data:new FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        success:(res)=>{
            hideLoader();
            showToaster("bg-success","top-0 end-0",res.msg);
            window.setTimeout(() => {
                window.location.href=res.url; 
            }, 1000);
            
        },error:(xhr, ajaxOptions, thrownError)=>{
           hideLoader();
            if(xhr.status=="422"){
                $(this).find(".permission-group-error").html("");
                $(this).find(".permission-name-error").html("");
                let error = xhr.responseJSON.errors;
                $(this).find(".permission-group-error").append(`<span class="text-danger">${error.permission_group}</span>`);
                $(this).find(".permission-name-error").append(`<span class="text-danger">${error.permission_name}</span>`);
            }
            if(xhr.status=="401"){
                console
                let error = xhr.responseJSON;
                showToaster("bg-danger","top-0 end-0",error.msg);
            }else{
                showToaster("bg-danger","top-0 end-0",xhr.responseJSON.message);
            }
            
        }
    });
})

$("#permission-edit").on("submit",function(e){
    e.preventDefault();
    showLoader();
    $.ajax({
        url:site_url+"/admin/permission/update",
        type:"POST",
        data:new FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        success:(res)=>{
            hideLoader();
            showToaster("bg-success","top-0 end-0",res.msg);
            window.setTimeout(() => {
                window.location.href=res.url; 
            }, 1000);
            
        },error:(xhr, ajaxOptions, thrownError)=>{
           hideLoader();
            if(xhr.status=="422"){
                $(this).find(".permission-group-error").html("");
                $(this).find(".permission-name-error").html("");
                let error = xhr.responseJSON.errors;
                $(this).find(".permission-group-error").append(`<span class="text-danger">${error.permission_group}</span>`);
                $(this).find(".permission-name-error").append(`<span class="text-danger">${error.permission_name}</span>`);
            }
            if(xhr.status=="401"){
                console
                let error = xhr.responseJSON;
                showToaster("bg-danger","top-0 end-0",error.msg);
            }else{
                showToaster("bg-danger","top-0 end-0",xhr.responseJSON.message);
            }
            
        }
    });
})

function deletePermission(id){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
            showLoader();
            $.ajax({
                url: site_url+"/admin/permission/delete",
                type: 'POST',
                dataType: "json",
                data:{'id':id},
                cache:false,
                success:function (res) {
                    // hideLoader();
                    showToaster("bg-success","top-0 end-0",res.msg);
                    window.setTimeout(() => {
                        window.location.reload(); 
                    }, 1000);
                },error:(xhr, ajaxOptions, thrownError)=>{
                    hideLoader()
                    if(xhr.status=="401"){
                        let error = xhr.responseJSON;
                        showToaster("bg-danger","top-0 end-0",error.msg);
                    }else{
                        showToaster("bg-danger","top-0 end-0",xhr.responseJSON.message);
                    }
                }
            });
        }
    });
}