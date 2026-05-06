let property_reviews_rating_table;
$(function(){
    property_reviews_rating_table =$('#property_reviews').DataTable({
        "language": {
            "zeroRecords": "No record(s) found.",
            searchPlaceholder: "Search records"
        },
        "bDestroy": true,
        ordering: false,
        paging: true,
        processing: true,
        serverSide: true,
        searchable:false,
        bStateSave: true,
        "bPaginate": false,
        "bFilter": false, 
        "bInfo": false, 
        scrollX: true,
        "bLengthChange" : false,
        ajax:{
            url:site_url+"/admin/property/get-property-reviews",
            data:function(d){
                d.property_id =$("input[name=property_id]").val();
            }
        },
        dataType: 'html',
        columns: [
            {data: 'DT_RowIndex' ,name:'DT_RowIndex',searching: false,orderable: false},
            {data: 'reviews_heading', name: 'reviews_heading',orderable: false},
            {data: 'guest_name', name: 'guest_name',orderable: false},
            {data: 'place', name: 'place',orderable: false},
            {data: 'reviews', name: 'reviews',orderable: false},
            {data: 'rating', name: 'rating',orderable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
    $.fn.dataTable.ext.errMode = 'none';
    $('#property_reviews').on('error.dt', function(e, settings, techNote, message) {
        console.log( 'An error has been reported by DataTables: ', message);
    })
    $('.mega-menu').on('click',function(){
        try {
           table.state.clear();
        }
        catch(err) {
           console.log(err.message);
        }
    });
});


$(".add_reviews").on('click',function(e){
    e.preventDefault();
    showLoader();
    let reviews={
        'property_id':$("input[name=property_id]").val(),
        'reviews_heading':$("input[name=reviews_heading]").val(),
        'guest_name':$("input[name=guest_name]").val(),
        'place':$("input[name=place]").val(),
        'reviews':$("textarea[name=reviews]").val(),
        'rating':$("select[name=rating]").val(),
    };
    $.ajax({
        url:site_url+"/admin/property/reviews-store",
        type:"POST",
        data:reviews,
        dataType: "json",
        cache: false,
        success:(res)=>{
            if(res.status=='1'){
                property_reviews_rating_table.draw();
                $("input[name=reviews_heading]").val("");
                $("input[name=guest_name]").val("");
                $("input[name=place]").val("");
                $("textarea[name=reviews]").val("");
                $("select[name=rating]").val("");
                hideLoader();
                showToaster("bg-success","top-0 end-0",res.msg);
            }else{
                hideLoader();
                showToaster("bg-danger","top-0 end-0",res.msg);
            }
        },error(xhr,ajaxOptions,thrownError){
            hideLoader();
            let error = xhr.responseJSON.errors;
            if(xhr.status=="422"){
                $(".reviews_heading").html("");
                $(".reviews_heading").html(error.reviews_heading );
                $(".guest_name").html("");
                $(".guest_name").html(error.guest_name );
                $(".place").html("");
                $(".place").html(error.place );
                $(".reviews").html("");
                $(".reviews").html(error.reviews);
                $(".rating").html("");
                $(".rating").html(error.rating );
            }else{
                showToaster("bg-danger","top-0 end-0",xhr.responseJSON.message);
            }
        }
    });
})

$(".reviews_rating").on("click",function(e){
    var curStep = $(this).closest(".setup-content"),curStepBtn = curStep.attr("id"),
    nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a");
    e.preventDefault();
    nextStepWizard.removeAttr('disabled').trigger('click')
});

function editReviwes(id){
    showLoader();
    $.ajax({
        url:site_url+"/admin/property/edit-property-reviews",
        type:"POST",
        data:{"id":id},
        cache:false,
        success:(res)=>{
            hideLoader();
            if(res.status=='1'){
                $('#edit-rviews').modal('show');
                let form = $("#editReviews");
                form.find("input[name=id]").val(res.data.id);
                form.find("input[name=reviews_heading]").val(res.data.reviews_heading);
                form.find("input[name=guest_name]").val(res.data.guest_name);
                form.find("input[name=place]").val(res.data.place);
                form.find("input[name=reviews]").val(res.data.reviews);
                $('select[name^="rating_update"] option[value="'+res.data.rating+'"]').attr("selected","selected");
            }
        },error(xhr,ajaxOptions,thrownError){
        }
    });

}

editReviews.onsubmit = async (e) => {
    showLoader();
    e.preventDefault();
    let response = await fetch(site_url+'/admin/property/review-rating-update', {
      method: 'POST',
      body: new FormData(editReviews),
      processData: false,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
      },
     
    });
    let result = await response.json();
    if(result.status==200){
        $('#edit-rviews').modal('hide');
        hideLoader();
        showToaster("bg-success","top-0 end-0",result.msg);
        property_reviews_rating_table.draw();
    }else{
        hideLoader();
        showToaster("bg-danger","top-0 end-0",result.msg);
    }
   
};



async function deleteReviews(id) {
    try {
        const result = await Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!',
        });
    
        if (result.isConfirmed) {  
          $.ajax({
              url:site_url +'/admin/property/delete-reviews-rating',
              type:"POST",
              data:{
                   id: id,
              },
              dataType: "json",
              cache: false,
              success:(res)=>{
                  if (res.status === 200) {
                      hideLoader();
                      Swal.fire('Deleted!', res.msg, 'danger');
                      property_reviews_rating_table.draw();
                  } else {
                      hideLoader();
                      Swal.fire('Error!', res.msg, 'danger');
                  }
              }
      
          })
        }
      } catch (error) {
        console.error(error);
    } 
}
  



