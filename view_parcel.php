<?php
error_reporting(0);
include 'db_connect.php';
$qry = $conn->query("SELECT * FROM parcels where id = ".$_GET['id'])->fetch_array();
foreach($qry as $k => $v){
	$$k = $v;
}
if($to_branch_id > 0 || $from_branch_id > 0){
	$to_branch_id = $to_branch_id  > 0 ? $to_branch_id  : '-1';
	$from_branch_id = $from_branch_id  > 0 ? $from_branch_id  : '-1';
$branch = array();
 $branches = $conn->query("SELECT *,concat(street) as address FROM branches where id in ($to_branch_id,$from_branch_id)");
    while($row = $branches->fetch_assoc()):
    	$branch[$row['id']] = $row['address'];
	endwhile;
}
?>
<div class="container-fluid">
	<div class="col-lg-12">
		<div class="row">
			<div class="col-md-12">
				<div class="callout callout-info">
					<dl>
						<dt>Codigo de Referencia:</dt>
						<dd> <h4><b><?php echo $reference_number ?></b></h4></dd>
					</dl>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="callout callout-info">
					<b class="border-bottom border-primary">Informacion del Booking</b>
					<dl>
						<dt>Booking:</dt>
						<dd><?php echo ucwords($sender_name) ?></dd>
						<dt>Fecha de llegada:</dt>
						<dd><?php echo ucwords($sender_address) ?></dd>
						<dt>Fecha estimada de llegada:</dt>
						<dd><?php echo ucwords($sender_contact) ?></dd>
					</dl>
				</div>
				<div class="callout callout-info">
					<b class="border-bottom border-primary">Informacion del Contenedor</b>
					<dl>
						<dt>CutOff:</dt>
						<dd><?php echo ucwords($recipient_name) ?></dd>
						<dt>Localizacion de LLegada:</dt>
						<dd><?php echo ucwords($recipient_address) ?></dd>
						<dt>Localizacion de Envio:</dt>
						<dd><?php echo ucwords($recipient_contact) ?></dd>
					</dl>
				</div>
			</div>
			<div class="col-md-6">
				<div class="callout callout-info">
					<b class="border-bottom border-primary">Detalles del Contenedor</b>
						<div class="row">
							<div class="col-sm-6">
								<dl>
									<dt>Orden:</dt>
									<dd><?php echo $weight ?></dd>
									<dt>Cantidad:</dt>
									<dd><?php echo $height ?></dd>
									<dt>Precio:</dt>
									<dd><?php echo 	$price ?></dd>
								</dl>	
							</div>
							<div class="col-sm-6">
								<dl>
									<dt>Producto:</dt>
									<dd><?php echo $width ?></dd>
									<dt>Importacion:</dt>
									<dd><?php echo $length ?></dd>
									<!--<dt>Tipo:</dt>
									<dd><?php //echo $type == 1 ? "<span class='badge badge-primary'>Exportacion</span>":"<span class='badge badge-info'>Importacion</span>" ?></dd>-->
								</dl>	
							</div>
						</div>
					<dl>
						<dt>Embarcador:</dt>
						<dd><?php echo ucwords($branch[$from_branch_id]) ?></dd>
						<?php if($type == 2): ?>
							<dt>Suplidor:</dt>
							<dd><?php echo ucwords($branch[$to_branch_id]) ?></dd>
						<?php endif; ?>
						<dt>Estado:</dt>
						<dd>
							<?php 
							switch ($status) {
									case '0':
									echo "<span class='badge badge-pill badge-info'> Enviado</span>";
									break;
								case '1':
									echo "<span class='badge badge-pill badge-info'> Recibido</span>";
									break;
								case '2':
									echo "<span class='badge badge-pill badge-primary'> En Transito</span>";
									break;
								case '3':
									echo "<span class='badge badge-pill badge-primary'> En el Puerto</span>";
									break;
								
								default:
									echo "<span class='badge badge-pill badge-info'> Contenedor Recibido</span>";
									
									break;
							}

							?>
							<span class="btn badge badge-primary bg-gradient-primary" id='update_status'><i class="fa fa-edit"></i> Actualizar Estado</span>
						</dd>

					</dl>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal-footer display p-0 m-0">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
</div>
<style>
	#uni_modal .modal-footer{
		display: none
	}
	#uni_modal .modal-footer.display{
		display: flex
	}
</style>
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
	<h3 class="text-center"><b>Student Result</b></h3>
</noscript>
<script>
	$('#update_status').click(function(){
		uni_modal("Update Status of: <?php echo $reference_number ?>","manage_parcel_status.php?id=<?php echo $id ?>&cs=<?php echo $status ?>","")
	})
</script>