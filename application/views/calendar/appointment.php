<?php $this->load->view("partial/header"); ?>
<link rel='stylesheet' type='text/css'
	href='<?php echo $this->config->base_url();?>web/js/jquery.fullcalendar/fullcalendar/fullcalendar.css' />


<div class="container-fluid" id="pcont">
	<div class="page-head">
		<h2>Calendario de Atendimento</h2>
	</div>

	<div class="cl-mcont">
		<div class="row">
			<div class="col-md-12">
				<div class="block-flat">
					<div class="header">
						<h3>Agenda</h3>
					</div>
					<div id="DivCep" class="content">
	              <?php echo $calendar;?>
	            </div>
				</div>
			</div>
		</div>
	</div>

	<button id="button" class="btn btn-primary btn-flat md-trigger"
		data-modal="md-scale" style="visibility: hidden;"></button>
	<!-- Nifty Modal -->
	<div class="md-modal md-effect-1" id="md-scale">
		<div class="md-content" style="background-image: url('<?php echo $this->config->base_url();?>images/calendar.png');  background-position:95% 15%;  	background-size: 145px 120px;  background-repeat: no-repeat;">
			<div class="modal-header">
				<button type="button" class="close md-close" data-dismiss="modal"
					aria-hidden="true">&times;</button>
			</div>
			<form class="form-horizontal" action="#" style="border-radius: 0px;">
				<div class="modal-body">
					<div class="text-center">
						<h3>Novo Agendamento</h3>
						<div class="form-group">
							<label class="col-sm-3 control-label">Fonoaudiologo:</label>
							<div class="col-sm-6">
				    						<?php echo $fono;?>				    						
				    					</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Cadastrado </label>
							<div class="col-sm-2">
								<div class="switch" data-on="success">
									<input type="checkbox" onchange="changecliente();"
										name="isclient" id="onoff" value="1" checked>
								</div>
							</div>
							<div class="col-sm-4" id="chateado">
	              							<?php echo $customers;?>
				    					</div>
							<div class="col-sm-4" style="visibility: hidden; display: none;"
								id="tuts">
								<input type="text" placeholder="Nome do paciente"
									id="nomecliente" class="form-control" disabled="disabled">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Data e Hora:</label>
							<div class="col-sm-3">
								<input id="date" type="text" class="form-control"
									placeholder="00/00/0000" value="">
							</div>
							<div class="col-sm-3">
								<input id="time" type="text" class="form-control"
									placeholder="00:00" value="">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Atendimento:</label>
							<div class="col-sm-6">
								<textarea id="info" class="form-control" style="resize: none;"></textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="reset" class="btn btn-default md-close"
						data-dismiss="modal">Cancelar</button>
					<button type="button" class="btn btn-primary md-close"
						onclick="javascript: setappointment();" data-dismiss="modal">Agendar</button>
				</div>
			</form>
		</div>
	</div>

	<div class="md-overlay"></div>
</div>

<script
	src="<?php echo $this->config->base_url();?>web/js/jquery.min.js"></script>

<script type="text/javascript">

 		function setdatetime(ev){
		
		var name = ev.target.id;
		var p = document.getElementById("profi");		
		var profi = p.options[p.selectedIndex].value; 
		
		var URL = "<?php echo $this->config->site_url('calendars/new_appointment'); ?>";
		
			$.post(URL,
			    {
					id:name,
					employeer:profi				     			      
			    },
			    function(data,status){	

			    	eval(data);
			    	
			    	var d = document.getElementById("date");
					d.setAttribute("value", info[0]);

					var t = document.getElementById("time");
					t.setAttribute("value", info[1]);					   
						    
					var f = document.getElementById("fono");
					f.setAttribute("value", info[2]);	

					
					
					if(info[2] == '1')
					{
						f.removeAttribute("readonly",0);
						var f = document.getElementById("fono");
						f.setAttribute("value", '');	
					}
					else
					{
						att = document.createAttribute("readonly");
						att.value = "readonly";

						var f = document.getElementById("fono");
						f.setAtribute("value", info[2]);
							
						f.setAttributeNode(att);	
					}
										    					   						    	
			    });
		
		
		}


		function setappointment(){


			var fono = document.getElementById('fono').value;
			var e = document.getElementById("patient");
			var customer = e.options[e.selectedIndex].value; 
			var data = document.getElementById('date').value;
			var hora = document.getElementById('time').value;
			var info = document.getElementById('info').value;
			var nomecliente = document.getElementById('nomecliente').value;
			
			if(document.getElementById('onoff').checked == true)
			{
				var onoff = "1";
			}
			else
			{
				var onoff = "0"; 
			}
			
			var URL = "<?php echo $this->config->site_url('calendars/save'); ?>";

			
			$.post(URL,
			    {	
			    	check:onoff,
			    	cliente:nomecliente,
					doctor_id:fono,
					patient_id:customer,
					appointment:data,
					hour:hora,
					atendimento:info				     			      
			    },
			    function(data,status){	
				
			    	eval(data);
			    	window.location.reload(true);
			    	    					   						    	
			    });
		    
		}
		
	</script>


<script type="text/javascript">
		var Notification = window.Notification || window.mozNotification || window.webkitNotification;
	
		Notification.requestPermission(function (permission) {
			// console.log(permission);
		});


		function gotoleft()
		{
			var strMesAno = document.getElementById('stringMesAno').innerHTML;
			var URL = "<?php echo $this->config->site_url('calendars/gotoleft');?>";


			var elemArray = document.getElementsByClassName('fc-button fc-state-active');
			for(var i = 0; i < elemArray.length; i++){
				var elem = document.getElementById(elemArray[i].id);				        
			}

			var e = document.getElementById('profi');
			var p = e.options[e.selectedIndex].value;
			    
			$.post(URL,
					{						
						stringMesAno:strMesAno,
						modal:elem.id,
						profi:p
					},
					function(data,status){
						document.getElementById( "DivCep" ).innerHTML = data;
					});
		}


		function gotoright()
		{
			var strMesAno = document.getElementById('stringMesAno').innerHTML;
			var URL = "<?php echo $this->config->site_url('calendars/gotoright');?>";

			var elemArray = document.getElementsByClassName('fc-button fc-state-active');
			for(var i = 0; i < elemArray.length; i++){
				var elem = document.getElementById(elemArray[i].id);				        
			}

			var e = document.getElementById('profi');
			var p = e.options[e.selectedIndex].value;
			
			$.post(URL,
					{
						stringMesAno:strMesAno,
						modal:elem.id,
						profi:p
					},
					function(data,status){
						document.getElementById( "DivCep" ).innerHTML = data;
					});
		}
		
		function show(doctor,patient,date,hour,link) {


			var instance = new Notification(
				"Fonoaudiologa: "+doctor, {
					body: "Cliente: "+patient+" \nMarcado:  "+date+" "+hour+" horas",					
					icon: "<?php echo $this->config->base_url();?>web/images/notification.png"
				}
			);

			
			instance.onclick = function () {
				// Something to do
				window.location = link;
			};
			instance.onerror = function () {
				// Something to do
			};
			instance.onshow = function () {
				// Something to do
								
			};
			instance.onclose = function () {
				
			};
			
			return false;
		}
	

		
		function showcalendar(e)
		{
			var URL = "<?php echo $this->config->site_url('calendars/agenda')?>";			
			e = parseInt(e);
			
			switch (e) {
				case 1:
					$.post(URL,
						    {
								modal:e						     			      
						    },
						    function(data,status){	
						    	document.getElementById( "DivCep" ).innerHTML = data;
						    });
				break;

				case 2:
					$.post(URL,
						    {
								modal:e						     			      
						    },
						    function(data,status){	
						    	document.getElementById( "DivCep" ).innerHTML = data;						    	
						    });
				break;

				case 3:					
					$.post(URL,
						    {
								modal:e						     			      
						    },
						    function(data,status){	
						    	document.getElementById( "DivCep" ).innerHTML = data;						    	
						    });
				break;
				
			}
					
		}	



		function agendado(ev)
		{
	
			var id =  ev.target.id;
			var e = document.getElementById(id);
			var p = e.options[e.selectedIndex].value;

			
			 URL = "<?php echo $this->config->site_url('calendars/agendaDo')?>";
			 
			if(p == 1){

				
				    var elemArray = document.getElementsByClassName('fc-button fc-state-active');
				    for(var i = 0; i < elemArray.length; i++){
				        var elem = document.getElementById(elemArray[i].id);				        
				    }				
				 			 								
				 var URL = "<?php echo $this->config->site_url('calendars/agenda')?>";	
				 $.post(URL,
				    		{
			    				modal:elem.id
				    		},
				    		function(data,status){
				    			document.getElementById( "DivCep" ).innerHTML = data;
				    		});
			}else{				
				
		    $.post(URL,
		    		{
	    				fono:p
		    		},
		    		function(data,status){
		    			document.getElementById( "DivCep" ).innerHTML = data;
		    		});
			}
		}
		
		
		function allowDrop(ev) {
		    ev.preventDefault();		    
		}
		
		function drag(ev) {
		    ev.dataTransfer.setData("Text", ev.target.id);

		    id = ev.target.id;
		    URL = "<?php echo $this->config->site_url('calendars/get_appointment')?>";

		    $.post(URL,
		    		{
	    				datatime:id
		    		},
		    		function(data,status){
		    			return;
		    		});
		}
		
		function drop(ev) {
		    ev.preventDefault();
		    var data = ev.dataTransfer.getData("Text");
		    ev.target.appendChild(document.getElementById(data));

		    id = ev.target.id;
		    URL = "<?php echo $this->config->site_url('calendars/alter_appointment')?>";

		    $.post(URL,
		    		{
	    				datatime:id
		    		},
		    		function(data,status){
			    		eval(data);
		    		});
		}


		function changecliente()
		{
			if(document.getElementById("onoff").checked == false)
			{
				document.getElementById("tuts").removeAttribute("style");
				document.getElementById("chateado").style.display="none";
				document.getElementById("chateado").style.visibility="hidden";

				document.getElementById("patient").setAttribute("disabled", "disabled");
				document.getElementById("nomecliente").removeAttribute("disabled");
				
				
			}
			else if(document.getElementById("onoff").checked == true)
			{
				document.getElementById("chateado").removeAttribute("style");
				document.getElementById("tuts").style.display="none";
				document.getElementById("tuts").style.visibility="hidden";
				
				document.getElementById("nomecliente").setAttribute("disabled", "disabled");
				document.getElementById("patient").removeAttribute("disabled");

				
				
			}
		}
	</script>


<?php $this->load->view("partial/footer"); ?>