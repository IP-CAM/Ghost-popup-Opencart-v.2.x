<div>
<?php if ($status == true) {?>
<script src="catalog/view/javascript/jquery/ghostpopup/jquery.cookie.min.js"></script>
<script src="catalog/view/javascript/jquery/ghostpopup/jquery.ghostpopup.js"></script>  
<link rel="stylesheet" href="catalog/view/javascript/jquery/ghostpopup/jquery.ghostpopup.css"> 
  
<script>
setTimeout(function() 
{
  (function($) {
    var cookietime = Number.parseInt('<?php print $cookie; ?>');

    $(function() {  
      if (!$.cookie('ghostpopup')) {
        $('#ghostpopup-modal').ghostpopup();  
      }
      if (cookietime) {
        $.cookie('ghostpopup', true, {
          expires: cookietime,  
          path: '/'  
        }); 
      }
    })  
  })(jQuery)  
},  <?php print $timeout; ?>);
</script>
  <div style="display: none;">  
    <div class="box-modal" id="ghostpopup-modal" >  
      <div class="box-modal_close ghostpopup-close">
        <i class="icon-modal mclose"></i>
      </div>
      <div class="body">
        <?php print $content; ?>
      </div>
    </div>  
  </div> 
<?php }?>
</div>