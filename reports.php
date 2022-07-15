<?php include 'db_connect.php' ?>
<?php $status = isset($_GET['status']) ? $_GET['status'] : 'all' ?>

<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-body">
			
			<div class="d-flex w-100 px-1 py-2 justify-content-center align-items-center">
			<?php 
			$status_arr =  array(" Enviado"," Recibido"," En Transito"," En el Puerto"," Cancelado"); ?>
				<label for="date_from" class="mx-1">Status</label>
				<select name="" id="status" class="custom-select custom-select-sm col-sm-3">
					<option value="all" <?php echo $status == 'all' ? "selected" :'' ?>>All</option>
					<?php foreach($status_arr as $k => $v): ?>
						<option value="<?php echo $k ?>" <?php echo $status != 'all' && $status == $k ? "selected" :'' ?>><?php echo $v; ?></option>
					<?php endforeach; ?>
				</select>
				<label for="date_from" class="mx-1">From</label>
                <input type="date" id="date_from" class="form-control form-control-sm col-sm-3" value="<?php echo isset($_GET['date_from']) ? date("Y-m-d",strtotime($_GET['date_from'])) : '' ?>">
                <label for="date_to" class="mx-1">To</label>
                <input type="date" id="date_to" class="form-control form-control-sm col-sm-3" value="<?php echo isset($_GET['date_to']) ? date("Y-m-d",strtotime($_GET['date_to'])) : '' ?>">
                <button class="btn btn-sm btn-primary mx-1 bg-gradient-primary" type="button" id='view_report'>View Report</button>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 ">
			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="col-md-12">
        					<button type="button" class="btn btn-success float-right" style="display: none" id="print"><i class="fa fa-print"></i> Print</button>
						</div>
					</div>	
					
					<table class="table table-bordered" id="report-list">
						<thead>
							<tr>
								<th>#</th>
								<th>Orden</th>
								<!--<th>Importacion</th>-->
								<th>Suplidor</th>
								<th>Embarcador</th>
								<th>Producto</th>
								<th>Costo x Caja</th>
								<th>Cantidad</th>
								<th>ETA</th>
								<!--<th>ETD</th>-->
							</tr>
						</thead>
						<tbody>
							
						</tbody>
					</table>
				</div>
			</div>
			
		</div>
	</div>
</div>
<noscript>
	<style>
		table.table{
			width:100%;
			border-collapse: collapse;
		}
		table.table tr,table.table th, table.table td{
			border:1px solid;
		}
		.text-cnter{
			text-align: center;
		}
	</style>
	<h3 class="text-center"><b>Reporte de Contenedores de Importacion</b></h3>
</noscript>
<div class="details d-none">
		<p><b>Rango de Fechas:</b> <span class="drange"></span></p>
		<p><b>Estado:</b> <span class="status-field">All</span></p>
	</div>

<script>
	function load_report(){
		start_load()
		var date_from = $('#date_from').val()
		var date_to = $('#date_to').val()
		var status = $('#status').val()
			$.ajax({
				url:'ajax.php?action=get_report',
				method:'POST',
				data:{status:status,date_from:date_from,date_to:date_to},
				error:err=>{
					console.log(err)
					alert_toast("An error occured",'error')
					end_load()
				},
				success:function(resp){
					if(typeof resp === 'object' || Array.isArray(resp) || typeof JSON.parse(resp) === 'object'){
						resp = JSON.parse(resp)
						if(Object.keys(resp).length > 0){
							$('#report-list tbody').html('')
							var i =1;
							Object.keys(resp).map(function(k){
								var tr = $('<tr></tr>')
								tr.append('<td>'+(i++)+'</td>')
								tr.append('<td>'+(resp[k].weight)+'</td>')
								tr.append('<td>'+(resp[k].length)+'</td>')
								/*if (resp[k].to_branch_id == 1){
									resp[k].to_branch_id = "Jose Paiewonsky E Hijos";
								}else if (resp[k].to_branch_id == 2){
									resp[k].to_branch_id = "Hartwick Financial Corp.";
								}
								tr.append('<td>'+(resp[k].to_branch_id)+'</td>')*/

								if (resp[k].from_branch_id == 1){
									resp[k].from_branch_id = "China Unichem ind. L";
								}else if (resp[k].from_branch_id == 2){
									resp[k].from_branch_id = "Heinrich Christen";
								}else if (resp[k].from_branch_id == 3){
									resp[k].from_branch_id = "Sunny Success int.";
								}else if (resp[k].from_branch_id == 4){
									resp[k].from_branch_id = "Curacao Trading";
								}else if (resp[k].from_branch_id == 5){
									resp[k].from_branch_id = "Global Wax LLC";
								}else if (resp[k].from_branch_id == 6){
									resp[k].from_branch_id = "Sao Visitor";
								}else if (resp[k].from_branch_id == 7){
									resp[k].from_branch_id = "Hci Wax";
								}else if (resp[k].from_branch_id == 8){
									resp[k].from_branch_id = "Tranpak";
								}else if (resp[k].from_branch_id == 9){
									resp[k].from_branch_id = "Brascera S.A";
								}else if (resp[k].from_branch_id == 10){
									resp[k].from_branch_id = "Masterank Global L.";
								}else if (resp[k].from_branch_id == 11){
									resp[k].from_branch_id = "All American";
								}else if (resp[k].from_branch_id == 12){
									resp[k].from_branch_id = "Fortunare";
								}else if (resp[k].from_branch_id == 13){
									resp[k].from_branch_id = "AM WAX, INC.";
								}else if (resp[k].from_branch_id == 14){
									resp[k].from_branch_id = "Mexim  S.A";
								}else if (resp[k].from_branch_id == 15){
									resp[k].from_branch_id = "José Paiewonsky E Hijos, S.R.L.";
								}else if (resp[k].from_branch_id == 15){
									resp[k].from_branch_id = "Hartwick Financial Corp.";
								}else{
									resp[k].from_branch_id = "";
								}
								tr.append('<td>'+(resp[k].from_branch_id)+'</td>')
								tr.append('<td>'+(resp[k].width)+'</td>')
								tr.append('<td>'+(resp[k].price)+'</td>')
								tr.append('<td>'+(resp[k].height)+'</td>')
								tr.append('<td>'+(resp[k].sender_contact)+'</td>')
								//tr.append('<td>'+(resp[k].recipient_name)+'</td>')
								$('#report-list tbody').append(tr)
							})
							$('#print').show()
						}else{
							$('#report-list tbody').html('')
								var tr = $('<tr></tr>')
								tr.append('<th class="text-center" colspan="6">No result.</th>')
								$('#report-list tbody').append(tr)
							$('#print').hide()
						}
					}
				}
				,complete:function(){
					end_load()
				}
			})
	}
$('#view_report').click(function(){
	if($('#date_from').val() == '' || $('#date_to').val() == ''){
		alert_toast("Please select dates first.","error")
		return false;
	}
	load_report()
	var date_from = $('#date_from').val()
	var date_to = $('#date_to').val()
	var status = $('#status').val()
	var target = './index.php?page=reports&filtered&date_from='+date_from+'&date_to='+date_to+'&status='+status
	window.history.pushState({}, null, target);
})

$(document).ready(function(){
	if('<?php echo isset($_GET['filtered']) ?>' == 1)
	load_report()
})
$('#print').click(function(){
		start_load()
		var ns = $('noscript').clone()
		var details = $('.details').clone()
		var content = $('#report-list').clone()
		var date_from = $('#date_from').val()
		var date_to = $('#date_to').val()
		var status = $('#status').val()
		var stat_arr = '<?php echo json_encode($status_arr) ?>';
			stat_arr = JSON.parse(stat_arr);
		details.find('.drange').text(date_from+" to "+date_to )
		if(status>-1)
		details.find('.status-field').text(stat_arr[status])
		ns.append(details)

		ns.append(content)
		var nw = window.open('','','height=700,width=900')
		nw.document.write(ns.html())
		nw.document.close()
		nw.print()
		setTimeout(function(){
			nw.close()
			end_load()
		},750)

	})
</script>