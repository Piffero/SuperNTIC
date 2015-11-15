

<script type="text/javascript"
	src="<?php echo $this->config->base_url();?>application/plug/jquery-2.1.1.min.js"></script>
<script type="text/javascript"
	src="<?php echo $this->config->base_url();?>application/plug/jquery.mask.js"></script>
<script type="text/javascript"
	src="<?php echo $this->config->base_url();?>web/js/jquery.js"></script>
<script type="text/javascript"
	src="<?php echo $this->config->base_url();?>web/js/jquery.select2/select2.min.js"></script>
<script type="text/javascript"
	src="<?php echo $this->config->base_url();?>web/js/bootstrap.slider/js/bootstrap-slider.js"></script>
<script type="text/javascript"
	src="<?php echo $this->config->base_url();?>web/js/jquery.nanoscroller/jquery.nanoscroller.js"></script>
<script type="text/javascript"
	src="<?php echo $this->config->base_url();?>web/js/bootstrap.switch/bootstrap-switch.min.js"></script>
<script type="text/javascript"
	src="<?php echo $this->config->base_url();?>web/js/jquery.nestable/jquery.nestable.js"></script>
<script type="text/javascript"
	src="<?php echo $this->config->base_url();?>web/js/bootstrap.datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript"
	src="<?php echo $this->config->base_url();?>web/js/behaviour/general.js"></script>
<script type="text/javascript"
	src="<?php echo $this->config->base_url();?>web/js/jquery.ui/jquery-ui.js"></script>
<script type="text/javascript"
	src="<?php echo $this->config->base_url();?>web/js/jquery.niftymodals/js/jquery.modalEffects.js"></script>
<script type="text/javascript"
	src='<?php echo $this->config->base_url();?>web/js/jquery.icheck/icheck.min.js'
	id="after">

</script>
<script type="text/javascript">
$(document).ready(function(){
//initialize the javascript
App.init();	
$(".md-trigger").modalEffects();
$('label.tree-toggler').click(function () {var icon = $(this).children(".fa");if(icon.hasClass("fa-folder-o")){icon.removeClass("fa-folder-o").addClass("fa-folder-open-o");}else{icon.removeClass("fa-folder-open-o").addClass("fa-folder-o");}$(this).parent().children('ul.tree').toggle(300,function(){$(this).parent().toggleClass("open");$(".tree .nscroller").nanoScroller({ preventPageScrolling: true });});});
});

	function validador(id, atributo)
	{
		var valor = [];
		var total = true;
		var count = document.getElementsByTagName("input").length;

		for(var i = 0; i < count; i++)
		{
			if(document.getElementsByTagName("input")[i].hasAttribute(atributo) == true)
			{
				valor[i] = (document.getElementsByTagName("input")[i].value).trim();

				if(valor[i] == '' || valor[i] == 'undefined' || valor[i] == ' ')
				{
					total = false;
				}
			}		
		}
		
		if (total == false)
		{
			alert("Você deve informar os campos obrigatórios vazios!");
			return;					
		}
		else if(total == true)
		{
			document.getElementById(id).submit();
		}
	}

	
</script>


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->

<script
	src="<?php echo $this->config->base_url();?>web/js/bootstrap/dist/js/bootstrap.min.js"></script>
<script type="text/javascript">
	window.scrollTo(0,0);
</script>
</body>
</html>
