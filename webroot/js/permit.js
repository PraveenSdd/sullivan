/*  upload frontent forms 
* By @Ahsan Ahamad
* Date : 12th Dec. 2017
*/

$(document).ready(function(){
 
// start   code for set alert value from forntend permit 
$(".uploadForm").click(function(){
        var title = $(this).data('title');
        var formId = $(this).data('formid');
        $('.modelTitle').html(title);
        $('#formId').val(formId);
        
});

 $('.permit').on('click',function(){
        if($(this).val() == 'on'){
           $('#attachment').attr('disabled',true);  
           $('#document').attr('disabled',true);  
           $('#alertType').val('permit');
        }
    });
    
    
 $('.document').on('click',function(){
        if($(this).val() == 'on'){
           $('#attachment').attr('disabled',true);  
           $('#document').attr('disabled',false);  
            $('#alertType').val('document');
        }
    });
    $('.attachment').on('click',function(){
         if($(this).val() == 'on'){
           $('#attachment').attr('disabled',false);  
           $('#document').attr('disabled',true); 
             $('#alertType').val('attachment');
        }
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


  
  
