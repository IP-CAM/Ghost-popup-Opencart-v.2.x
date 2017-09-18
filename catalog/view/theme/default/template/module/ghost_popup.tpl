<div>
<?php if ($ghost_popup_status == true) {?>	  
<!-- start slyle and js -->
	<script src="catalog/view/javascript/jquery/arcticmodal/jquery.arcticmodal.js"></script>  
	<link rel="stylesheet" href="catalog/view/javascript/jquery/arcticmodal/jquery.arcticmodal.css"> 
	<link rel="stylesheet" href="catalog/view/javascript/jquery/arcticmodal/themes/simple.css">
	<script src="catalog/view/javascript/jquery/arcticmodal/jquery.cookie.min.js"></script>

	<script>  
	setTimeout(function() {
	(function($) {  
	$(function() {  
	if (!$.cookie('ghost_popup')) {  
    $('#ghost_popup').arcticmodal({  
      closeOnOverlayClick: true,  
      closeOnEsc: true  
    });  
	}  
	$.cookie('ghost_popup', true, {  
    expires: 1,  
    path: '/'  
	});  
	})  
	})(jQuery)  }, 000);
	</script>   
<!-- end slyle and js -->
<style>
#ghost_popup {
	width: 430px; 
	height: 445px; 
	background-color: white;
    padding: 25px 30px;
    border: none;
    border-radius: 0;
    box-shadow: 0 0 0 5px rgba(153, 153, 153, 0.23);
}
#ghost_popup h3 {
	color: #e56867;
    text-align: center;
    font-size: 25px;
    margin-bottom: 35px;
}

#ghost_popup p {
    text-align: center;
    font-size: 16px;
    margin-bottom: 40px;
}
#ghost_popup form input {
    border-radius: 0;
    border: none;
    background-color: #f3f3f5;
    box-shadow: none;
    height: 40px;
    color: black;
    
}
#ghost_popup form input[type="checkbox"] {
    width: inherit;
    border: none;
    box-shadow: none;
    display: inline-block;
height: 18px;
}
#ghost_popup form label {
color: black;
    font-size: 13px;
    vertical-align: super;
    padding-left: 10px;
}
#ghost_popup form button {
    width: 100%;
    border-radius: 0;
    border: none;
    background: #e56867;
    box-shadow: none;
    color: white;
    height: 40px;
    text-transform: uppercase;
}

#ghost_popup form input::-webkit-input-placeholder, #ghost_popup form input::-moz-placeholder , 
#ghost_popup form input::-moz-placeholder, #ghost_popup form input::-ms-input-placeholder  ,  {
    color: #757575;
}

.icon-modal.mclose {
    width: 15px;
    height: 15px;
    background-position: 0 -32px;
}

.icon-modal {
    width: 16px;
    height: 16px;
    display: inline-block;
    background-image: url(/catalog/view/theme/default/image/icon-modal.png);
    background-repeat: no-repeat;
    margin-right: 3px;
    vertical-align: middle;
}

/*#modal-subscribe .modal-dialog {
    top: 35%;
}
*/
#modal-subscribe {
    top: 35%;
}
#modal-subscribe .modal-header, .modal-subscribe .modal-footer {
    border: none;
    min-height: 45px;
}
#modal-subscribe .modal-body {
    padding: 0;
}
#modal-subscribe .modal-body p {
    font-size: 16px;
    text-align: center;
}


</style>
<!-- start content -->
	<div style="display: none;">  
		<div class="box-modal" id="ghost_popup" >  
			<div class="box-modal_close arcticmodal-close">
				<i class="icon-modal mclose"></i>
			</div>
			<div class="body">
				<h3>Хотите скидку 10%?</h3>
				<p>Заполнив форму ниже и отправив еще нам, вы <br> получите 10% скидку на свой первый заказ</p>

				<form id="subscribe-form">
				  <div class="form-group">
				    <input type="email" name="email" class="form-control" placeholder="E-mail">
				  </div>
				  <div class="form-group">
				    <input type="text" name="name" class="form-control" placeholder="Ваше имя">
				  </div>
				  <div class="form-group" style="margin-top: 25px;margin-bottom: 35px;">
				    <input type="checkbox" name="i_agree" id="i_agree" class="form-control" checked>
				    <label for="i_agree">Согласен на обработку персональных данных</label>
				  </div>
				  <button id="ghost_popup_submit" type="submit" class="btn btn-default">Отправить</button>
				</form>

			</div>
    
	
		</div>  
	</div> 





<!-- end content -->
<?php }?>
</div>

  <div class="modal fade" id="modal-subscribe" tabindex="-1" role="dialog" aria-labelledby="modal-subscribe" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content modal-subscribe">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">

        </div>
        <div class="modal-footer">

        </div>
      </div><!-- /.модальное окно-Содержание -->  
    </div><!-- /.модальное окно-диалог -->  
  </div><!-- /.модальное окно -->

<script>
  $('#ghost_popup_submit').on('click', function(event) {
  	event.preventDefault();

    if(!$('input[name="i_agree"]').is(':checked')) {
      // alert('Вы должны согласиться на получение рассылки');
      // $('#popup-subscribe-wrapper .alert-danger').remove();

      $('.modal-subscribe .modal-body').html( '<p>Вы должны согласиться на получение рассылки</p>' );
      $('#modal-subscribe').modal('show');

      return;
    }
   
    // masked('#popup-subscribe-wrapper .right', true);
    $.ajax({
      type: 'post',
      url:  'index.php?route=module/ghost_popup/make_subscribe',
      dataType: 'json',
      data: $('#subscribe-form').serialize(),
      success: function(json) {
        if (json['error']) {
          // masked('#popup-subscribe-wrapper .right', false);
          // $('#popup-subscribe-wrapper .alert-danger').remove();
          // $('#subscribe-form').after('<div class="alert alert-danger"><i class="fa fa-check-circle"></i> ' + json['error'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
          // alert(json['error']);

          $('.modal-subscribe .modal-body').html( '<p>'+json['error']+'</p>' );
          $('#modal-subscribe').modal('show');

        }
        if (json['output']) {
          // masked('#popup-subscribe-wrapper .right', false);
          // alert(json['output']);
          $('.icon-modal.mclose').trigger('click');
          $('.modal-subscribe .modal-body').html( json['output'] );
          $('#modal-subscribe').modal('show')
        }
      }
    });
  });
</script>
