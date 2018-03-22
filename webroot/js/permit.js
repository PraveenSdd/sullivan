/*  upload frontent forms 
* By @Ahsan Ahamad
* Date : 12th Dec. 2017
*/

$(document).ready(function(){

/*---------Start code for update the status of permit by users-----------------------*/
   $(".change-status").on('change',function(){
        var status_id = $(this).val(); 
        var permit_id = $(this).attr('permit_id');
        var user_location_id = $(this).attr('user_location_id');
        var operation_id = $(this).attr('operation_id');
                 $.ajax({
                    url: "/users/changeUserPermitStatus",
                        type: "POST",               
                        data: {'status_id':status_id,'permit_id':permit_id,'user_location_id':user_location_id,'operation_id':operation_id},
                                      
                        success: function(responce)         
                        {
                        var res = JSON.parse(responce);    
                        if(res.statusCode == 200){
                         
                         $("#success").show();
                         $("#success").html("Status has been updated sucessfully");


                        }else{
                            $("#success").show();
                            $("#success").html("Status has been updated sucessfully");
                       }

                       setTimeout(function(){
                        $("#success").hide();
                        $("#error").hide();
                       },3000);
                      
                    }           
           });
      
      });
/*---------END code for update the status of permit by users-----------------------*/

 
// start   code for set alert value from forntend permit 
$(".uploadForm").click(function(){
        var title = $(this).data('title');
        var formId = $(this).data('formid');
        $('.modelTitle').html(title);
        $('#formId').val(formId);
        
});

 $(document).on('click','.permit',function(){
           $('#attachmentDocument').attr('disabled',true);  
           $('#document').attr('disabled',true);  
           $('#alertType').val('permit');
       
    });
    
    
 $(document).on('click','.document',function(){
      
           $('#attachmentDocument').attr('disabled',true);  
           $('#document').attr('disabled',false);  
            $('#alertType').val('document');
    });
    $(document).on('click','.attachment',function(){
           $('#attachmentDocument').attr('disabled',false);  
           $('#document').attr('disabled',true); 
             $('#alertType').val('attachment');
    });
// end  code for set alert value from forntend permit   
// code for set upload form value     
    $(".uploadForm").click(function(){
         $('#statusmsg').html('');
        var title = $(this).data('title');
        var formId = $(this).data('formid');
        var documentId = $(this).data('documentid');
        var permitDocumentsId = $(this).data('permitdocumentsid');
        $('.formTitle').html(title);
        $('#form_id').val(formId);
        $('#form_documents_id').val(documentId);
        $('#permit_documents_id').val(permitDocumentsId);
    });
}); 


    $("#uploadPermit").validate({
     debug: false,
      errorClass: "authError",
      onkeyup: false,
      rules: {
      form_documet:"required",
      },
      messages: {
      form_documet: "Please upload permit",
        
   },
  });
   
//  
  
/* submit permit upload */
$("#uploadPermit").on('submit',function(e) {
    var documentId = $('#form_documents_id').val();
        e.preventDefault();
   if ($('#uploadPermit').valid()) {
        $.ajax({
            url: "/permits/uploadPermitDocument",
                type: "POST",      			
                data:  new FormData(this),
                contentType: false,  
                dataType:'Json',
    cache: false,					
                processData:false,  			
                success: function(responce)  		
            {
                if(responce.flag){
                    pNotifySuccess('Permit', responce.msg);
                    $('#uploadPermitDocumentModel').modal('toggle');
                    $('.updated'+documentId).html(responce.data.updated);
                    $('.status').html('');
                    $('.formStatus'+documentId).attr('data-attachment-src',responce.path);
                    $('.formStatus'+documentId).attr('data-attachment-id',responce.id);
                    $('.formStatus'+documentId).removeClass('hide');
                }else{
                      pNotifySuccess('Permit', responce.msg);
               }
              
            }	        
   });
   }
});

/* * statrt code for form attachment document **/

$(document).ready(function(){
    $(".uploadFormAttachment").click(function(){
         $('#statusmsg').html('');
        var title = $(this).data('title');
        var formId = $(this).data('formid');
        var documentId = $(this).data('documentid');
        var attachmentId = $(this).data('attachmentid');
        var permitAttachmentId = $(this).data('permitattachmentid');
            
        $('.formAttachmentTitle').html(title);
        $('#form_attachment_id').val(formId);
        $('#form_attachment_documents_id').val(documentId);
        $('#form_attachment_document_id').val(attachmentId);
        $('#permit_attachment_id').val(permitAttachmentId);
    });
}); 
/* validation upload permit attachment  */

$("#uploadPermitAttachment").validate({
     debug: false,
      errorClass: "authError",
      onkeyup: false,
      rules: {
      form_documet:"required",
      },
      messages: {
      form_documet: "Please upload permit attachment",
        
   },
  });
/* submit form of attechment forms */
$("#uploadPermitAttachment").on('submit',function(e) {
    var attachmentId = $('#attachment_documents_id').val();
        e.preventDefault();
   if ($('#uploadPermitAttachment').valid()) { 
        $.ajax({
            url: "/permits/uploadPermitAttachment",
                type: "POST",      			
                data:  new FormData(this),
                contentType: false,  
                dataType:'Json',
    cache: false,					
                processData:false,  			
                success: function(responce)  		
            {
                if(responce.flag){
                    pNotifySuccess('Permit Attachment', responce.msg);
                    $('#uploadPermitAttachmentModel').modal('toggle');
                    $('.updatedAttachment'+attachmentId).html(responce.data.updated);
                    $('.statusAttachment'+attachmentId).html(responce.data.status);
                    $('.uploadAttachment'+attachmentId).html('');
                }else{
                    pNotifySuccess('Permit Attachment', responce.msg);
                }
              
            }	        
   });
   }
});

 /* change  form status of ther permit form front-end */

    $(document).on('click', '.changeFormStatus', function (event) {
        var permitId = $(this).data('permitid');
        var newstatus = $(this).data('newstatus');
        var userId = $(this).data('userid');
        var title = $(this).data('title');
        var oldStatus = $(this).data('oldstatus');
        var operationId = $(this).data('operationid');
        var locationId = $(this).data('locationid');
        var agencyId = $(this).data('agencyid');
        event.preventDefault();
        var urllink = $(this).attr('href');
        ecoConfirm("Are you sure you want to change the '" + title + "' status?", function
                ecoAlert(findreturn) {
            if (findreturn == true) {
                $.ajax({
                    url: "/Customs/changeFormStatus",
                    type: "POST",
                    data: { permit_id: permitId,
                            newstatus: newstatus,
                            user_id: userId,
                            oldStatus: oldStatus,
                            title: title,
                            operation_id: operationId,
                            user_location_id: locationId,
                            agency_id: agencyId,
                    },
                    success: function (data) {
                      //  window.location.reload();
                    }
                });
            } else {
                console.log('false');
            }
        });
    });



  
  
