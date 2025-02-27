/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(function () {
  $("input.check-all").change(function () {
    $("input.case:checkbox").prop('checked', $(this).prop("checked"));
  });

  $('#radioBtn a').on('click', function () {
    var sel = $(this).data('title');
    var tog = $(this).data('toggle');
    $('#' + tog).prop('value', sel);

    $('a[data-toggle="' + tog + '"]').not('[data-title="' + sel + '"]').removeClass('active').addClass('notActive');
    $('a[data-toggle="' + tog + '"][data-title="' + sel + '"]').removeClass('notActive').addClass('active');
  });

  //check range limit
  $("input[type=range]").on('mousedown mousemove change', function (e) {
    //return false if not 0-9
    $(this).next('output').text($(this).val());
  });






//date datetimepicker
  
  $('#datepicker-12 .input-daterange').datetimepicker({
    

    useCurrent: false,
    
       format : 'DD-MM-YYYY HH:mm'


        
  });

  $('#datepicker-13 .input-daterange').datetimepicker({
    
   
    useCurrent: false,
    format : 'DD-MM-YYYY HH:mm'


        
  });


  //datetime filter
  $('#datepicker-1 .input-daterange').datetimepicker({
    format: 'YYYY-MM-DD',
    maxDate: ($('#timePeriodEnd').val()) ? $('#timePeriodEnd').val() : null,
    useCurrent: false
  });
  $('#datepicker-2 .input-daterange').datetimepicker({
    format: 'YYYY-MM-DD',
    minDate: ($('#timePeriodStart').val()) ? $('#timePeriodStart').val() : null,
    useCurrent: false //Important! See issue #1075
  });
  $("#datepicker-1 .input-daterange").on("dp.change", function (e) {

    $('#datepicker-2 .input-daterange').data("DateTimePicker").minDate(e.date);


  });
  $("#datepicker-2 .input-daterange").on("dp.change", function (e) {

    $("#datepicker-1 .input-daterange").data("DateTimePicker").maxDate(e.date);
  });
  if ($('input[name=datefilter]').length > 0 && $('input[name=datefilter]:checked').val() == 'all') {
    console.log($('input[name=datefilter]').val());
    $('input[name=timePeriodStart], input[name=timePeriodEnd]').attr('disabled', 'disabled');
  }
  $('button#formFilter').click(function (){
    $('form').submit();
  });
  $(".withdraw-studio-payee").change(function(){
    var withdrawType = $(this).val();
    $('.payee-payment-box-type').addClass('hidden');
    $('.'+withdrawType+'-payee-payment').removeClass('hidden');
  });
});

function changeFilter(elem) {
  if (elem.value == 'date') {
    $('#datepicker-1, #datepicker-2').removeClass('hidden');
    $('input[name=timePeriodStart], input[name=timePeriodEnd]').removeAttr('disabled');
  } else {
    $('#datepicker-1, #datepicker-2').addClass('hidden');
    $('input[name=timePeriodStart], input[name=timePeriodEnd]').attr('disabled', 'disabled');
  }
}

function confirmDelete(message, id) {
  alertify.confirm(message,
          function () {
            return window.location.href = appSettings.BASE_URL + 'admin/manager/user/disable/' + id;
          }).set('title', 'Confirm');
}
function disableAllMembers() {
  var users = [];
  $('input.case:checkbox:checked').each(function (index) {
    users.push($(this).val());
  });
  if (users.length == 0) {
    return alertify.alert('Warning', 'Por favor, seleccione al menos 1 artículo.');
  }

  alertify.confirm('¿Estás seguro de que deseas eliminar a todos los miembros?',
          function () {
            $.ajax({
              type: 'delete',
              url: appSettings.BASE_URL + 'api/v1/user/disable',
              data: {'ids': users},
              success: function (data) {
                if (data.success) {
//                  for (var index in users) {
//                    $('tr#user-' + users[index]).remove();
//                  }
                  alertify.success(data.message);
                  return window.location.reload();

                }
                alertify.error(data.error);
              }
            });
          }).set('title', 'Confirm');
}
function deletePackage(id) {
  alertify.confirm('¿Está seguro de que desea eliminar este paquete?',
          function () {
            window.location.href = '/admin/manager/paymentpackage/delete/' + id;
          }).set('title', 'Confirm');
}
function openVideoPopup(url) {
  var player = jwplayer('video-player-popup'); // Created new video player
  player.setup({
    width: '100%',
    height: '350px',
    aspectratio: '16:9',
    image: '',
    sources: [{
        file: url,
        'type': 'mp4'
      }]
  });
  $('#mediaModal').modal('show');
}

function rejectPayment(id) {
  alertify.confirm('¿Está seguro de que desea rechazar este pago?',
          function () {
            window.location.href = '/admin/manager/payments/reject/' + id;
          }).set('title', 'Confirm');
}
function approvePayment(id) {
  alertify.confirm('¿Estás seguro de que quieres aprobar este pago?',
          function () {
            window.location.href = '/admin/manager/payments/approve/' + id;
          }).set('title', 'Confirm');
}

function showCommissionDetail(item, id) {
  var modal = $('#commissionModal');
  $.ajax({
    type: 'get',
    url: appSettings.BASE_URL + 'api/v1/earning/get-earning-by-item/' + item + '/' + id,
    success: function (data) {
      if (data.success) {

        var html = '';
        for (var index in data.results) {
          html += '<tr>\n\
<td>' + data.results[index].username + '</td>\n\
<td>' + data.results[index].item + '</td>\n\
<td>' + data.results[index].tokens + '</td>\n\
<td>' + data.results[index].percent + '</td></tr>';
        }

        modal.find('.modal-body table tbody').html(html);
        modal.modal('show');
      } else {

        alertify.error(data.message);
      }
    }
  });

}




function showFormPremiosTokens(item, username,tokensGanados) {
  console.log(item);
  console.log(username);
  var modal = $('#PremiosModal');


  $("#premioUsernameTxt").html(username);
  $("#userPremiosTokens").val(item);
  $("#tokensGanados").val(tokensGanados);
  $("#userPremiosFechaInicio").val($("#timePeriodStart").val());
  $("#userPremiosFechaFinal").val($("#timePeriodEnd").val());

  

//    modal.find('.modal-body table tbody').html(html);
    modal.modal('show');




}



function formTokensPremiosSubmit() {
    
     

        var registerForm = $("#formTokensPremios");
        var formData = registerForm.serialize();
        $( '#premiostokens-error' ).html( "" );
        




 $.ajax({
            url: appSettings.BASE_URL + 'admin/manager/premios/tokens',
            type:'POST',
            data:formData,
            success:function(data) {
               
                if(data.errors) {
                    if(data.errors){
                      alertify.error(data.errors.tokensPremios[0]);   
                    }

                }
                if(data.success) {
                   alertify.success(data.message);
                   setInterval(function(){ 
                         return window.location.reload();
                    }, 10000);
                }else{
                    alertify.warning(data.message);

                }

                    
                }
            
        });












    //document.getElementById('form').submit();


}



function deleteAllDreams() {
  var dreams = [];
  $('input.case:checkbox:checked').each(function (index) {
    dreams.push($(this).val());
  });
  if (dreams.length == 0) {
    return alertify.alert('Warning', 'Por favor, seleccione al menos 1 artículo.');
  }

  alertify.confirm('¿Estás segura de que quieres eliminar todos los sueños?',
          function () {
            $.ajax({
              type: 'delete',
              url: appSettings.BASE_URL + 'api/v1/users/model/dreams',
              data: {'ids': dreams},
              success: function (data) {
                if (data.success) {
                  alertify.success(data.message);
                  return window.location.reload();

                }
                alertify.error(data.message);
              }
            });
          }).set('title', 'Confirm');
}
//change account status
function changeAllAccountStatus(status) {
  if(!status || status == ''){
    return;
  }
  var users = [];
  $('input.case:checkbox:checked').each(function (index) {
    users.push($(this).val());
  });
  if (users.length == 0) {
    return alertify.warning('Por favor, seleccione al menos 1 artículo.');
  }
  var processing = $('.processing-event');
  var statusMSG = '';
  
  switch(status){
    case 'disable': statusMSG = '¿Está seguro de que desea inhabilitar a todos los miembros?';
      break;
    case 'active': statusMSG = '¿Está seguro de que desea aprobar a todos los miembros?';
      break;
    case 'suspend': statusMSG = '¿Está seguro de que desea suspender a todos los miembros?';
      break;
  };
  alertify.confirm(statusMSG,
          function () {
            processing.text('Procesando ...');
            $('button').attr('disabled', 'disabled');
            $.ajax({
              type: 'POST',
              url: appSettings.BASE_URL + 'api/v1/user/change-account-status/'+status,
              data: {'ids': users},
              success: function (data) {
                $('button').removeAttr('disabled');
                processing.text('');
                if (data.success) {
//                  for (var index in users) {
//                    $('tr#user-' + users[index]).remove();
//                  }
                  alertify.success(data.message);
                  return window.location.reload();

                }
                alertify.error(data.error);
              }
            });
          }).set('title', 'Confirm');
}

function deleteAllChatMessages(){
    var chats = [];
  $('input.case:checkbox:checked').each(function (index) {
    chats.push($(this).val());
  });
  if (chats.length == 0) {
    return alertify.warning('Por favor, seleccione al menos 1 artículo.');
  }
  var processing = $('.processing-event');
  
  processing.text('Procesando ...');
    $('button').attr('disabled', 'disabled');
    $.ajax({
      type: 'DELETE',
      url: appSettings.BASE_URL + 'api/v1/chat-messages',
      data: {'ids': chats},
      success: function (data) {
        $('button').removeAttr('disabled');
        processing.text('');
        if (data.success) {
    //                  for (var index in users) {
    //                    $('tr#user-' + users[index]).remove();
    //                  }
          alertify.success(data.message);
          return window.location.reload();

        }
        alertify.error(data.error);
      }
    });
}

function approveOrRejectPayment(action){
  var actionUrl = $('input[name=action]').val();
  $("form").attr('method', 'post').attr("action", actionUrl + '?action='+action).submit();
  
    
}