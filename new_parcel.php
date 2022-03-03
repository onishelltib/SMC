<?php if(!isset($conn)){ include 'db_connect.php'; } ?>
<style>
  textarea{
    resize: none;
  }
</style>

<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-body">
			<form action="" id="manage-parcel">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
        <div id="msg" class=""></div>
        <div class="row">
          <div class="col-md-6">
              <b>Informacion del Booking</b>
              <div class="form-group">
                <label for="" class="control-label">Booking</label>
                <input type="text" name="sender_name" id="Tracking" class="form-control form-control-sm" value="<?php echo isset($sender_name) ? $sender_name : '' ?>" required>
              </div>
              <div class="form-group">
                <label for="" class="control-label">Fecha de llegada</label>
                <input type="text" name="sender_address" id="ETA" class="form-control form-control-sm" value="<?php echo isset($sender_address) ? $sender_address : '' ?>" required>
              </div>
              <div class="form-group">
                <label for="" class="control-label">Fecha estimada de llegada</label>
                <input type="text" name="sender_contact" id="Estimated_ETA" class="form-control form-control-sm" value="<?php echo isset($sender_contact) ? $sender_contact : '' ?>" required>
              </div>
          </div>
          <div class="col-md-6">
              <b>Informacion del Contenedor</b>
              <div class="form-group">
                <label for="" class="control-label">CutOff</label>
                <input type="text" name="recipient_name" id="Cargo_Cutoff" class="form-control form-control-sm" value="<?php echo isset($recipient_name) ? $recipient_name : '' ?>">
              </div>
              <div class="form-group">
                <label for="" class="control-label">Localizacion de Llegada</label>
                <input type="text" name="recipient_address" id="POD" class="form-control form-control-sm" value="<?php echo isset($recipient_address) ? $recipient_address : '' ?>" >
              </div>
              <div class="form-group">
                <label for="" class="control-label">Localizacion de Envio</label>
                <input type="text" name="recipient_contact" id="POL" class="form-control form-control-sm" value="<?php echo isset($recipient_contact) ? $recipient_contact : '' ?>" required>
              </div>
          </div>
          <button  onclick="javascript:start();" type="button" class="btn waves-effect waves-light btn-outline-success">Buscar</button>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-6">
            <!--<div class="form-group">
              <label for="dtype">Tipo</label>
              <input type="checkbox" name="type" id="dtype" <?php echo isset($type) && $type == 1 ? 'checked' : '' ?> data-bootstrap-switch data-toggle="toggle" data-on="Exportacion" data-off="Importacion" class="switch-toggle status_chk" data-size="xs" data-offstyle="info" data-width="6rem" value="1">
             
            </div>-->
            <label for="navieras"><b>Naviera</b></label>
              <select id="navieras" class="form-control">
                <option value="Api/api_cosco.php">Cosco</option>
                <option value="Api/api_maersk.php">Maersk</option>
                <option value="Api/api_cma.php">CMA CGM</option>
                <option value="Api/api_msc.php">MSC</option>
                <option value="Api/api_hapag_loid.php">Hapag Lloyd</option>
                <option value="Api/api_evergreen.php">Evergreen</option>
                </select>
          </div>
          <div class="col-md-6" id=""  <?php //echo isset($type) && $type == 1 ? 'style="display: none"' : '' ?>>
            <?php if($_SESSION['login_branch_id'] <= 0): ?>
              <div class="form-group" id="fbi-field">
                <label for="" class="control-label">Embarcador</label>
              <select name="from_branch_id" id="from_branch_id" class="form-control select2" required="">
                <option value=""></option>
                <?php 
                  $branches = $conn->query("SELECT *,concat(street,', ',city,', ',state,', ',zip_code,', ',country) as address FROM branches");
                    while($row = $branches->fetch_assoc()):
                ?>
                 <option value="<?php echo $row['id'] ?>" <?php echo isset($from_branch_id) && $from_branch_id == $row['id'] ? "selected":'' ?>><?php echo $row['street'] ?></option>-->
                <?php endwhile; ?>
              </select>
            </div>
            <?php else: ?>
              <input type="hidden" name="from_branch_id" value="<?php echo $_SESSION['login_branch_id'] ?>">
            <?php endif; ?>  
            <div class="form-group" id="tbi-field" style ="padding-top: 47px;">
              <label for="" class="control-label">Suplidor </label>
              <select name="to_branch_id" id="to_branch_id" class="form-control select2">
                <option value=""></option>
                <?php 
                  $branches = $conn->query("SELECT *,concat(street,', ',city,', ',state,', ',zip_code,', ',country) as address FROM branches");
                    while($row = $branches->fetch_assoc()):
                ?>
                  <option value="<?php echo $row['id'] ?>" <?php echo isset($to_branch_id) && $to_branch_id == $row['id'] ? "selected":'' ?>><?php echo $row['street'] ?></option>
                <?php endwhile; ?>
              </select>
            </div>
          </div>
        </div>
        <hr>  
        <b>Informacion del contenedor</b>
        <table class="table table-bordered" id="parcel-items">
          <thead>
            <tr>
              <th>Orden</th>
              <th>Cantidad</th>
              <th>Importacion</th>
              <th>Producto</th>
              <th>Precio</th>
              <?php if(!isset($id)): ?>
              <th></th>
            <?php endif; ?>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><input type="text" name='weight[]' value="<?php echo isset($weight) ? $weight :'' ?>" ></td>
              <td><input type="text" name='height[]' value="<?php echo isset($height) ? $height :'' ?>" ></td>
              <td><input type="text" name='length[]' value="<?php echo isset($length) ? $length :'' ?>" ></td>
              <td><input type="text" name='width[]' value="<?php echo isset($width) ? $width :'' ?>" ></td>
              <td><input type="text" name='price[]' value="<?php echo isset($price) ? $price :'' ?>" ></td>
              <?php if(!isset($id)): ?>
              <td><button class="btn btn-sm btn-danger" type="button" onclick="$(this).closest('tr').remove() && calc()"><i class="fa fa-times"></i></button></td>
              <?php endif; ?>
            </tr>
          </tbody>
              <?php if(!isset($id)): ?>
          <tfoot>
            <th colspan="4" class="text-right">Total</th>
            <th class="text-right" id="tAmount">0.00</th>
            <th></th>
          </tfoot>
              <?php endif; ?>
        </table>
              <?php if(!isset($id)): ?>
        <div class="row">
          <div class="col-md-12 d-flex justify-content-end">
            <button  class="btn btn-sm btn-primary bg-gradient-primary" type="button" id="new_parcel"><i class="fa fa-item"></i>Nuevo Producto</button>
          </div>
        </div>
              <?php endif; ?>
      </form>
  	</div>
  	<div class="card-footer border-top border-info">
  		<div class="d-flex w-100 justify-content-center align-items-center">
  			<button class="btn btn-flat  bg-gradient-primary mx-2" form="manage-parcel">Guardar</button>
  			<a class="btn btn-flat bg-gradient-secondary mx-2" href="./index.php?page=parcel_list">Cancelar</a>
  		</div>
  	</div>
	</div>
</div>
<div id="ptr_clone" class="d-none">
  <table>
    <tr>
        <td><input type="text" name='weight[]' ></td>
        <td><input type="text" name='height[]' ></td>
        <td><input type="text" name='length[]' ></td>
        <td><input type="text" name='width[]' ></td>
        <td><input type="text" class="text-right number" name='price[]' ></td>
        <td><button class="btn btn-sm btn-danger" type="button" onclick="$(this).closest('tr').remove() && calc()"><i class="fa fa-times"></i></button></td>
      </tr>
  </table>
</div>
<script>

</script>
<script>
function start(){
    
    var Bl = $("#Tracking").val();
    var BL_send = Bl.split("\n");
    BL_send.forEach(function(value, index) {
        setTimeout(
            function() {
             
              var nav = document.getElementById("navieras");
              var api = nav.value;
              var api_selected = nav.options[nav.selectedIndex].text;
              
              if (api_selected == 'Hapag Lloyd'){
                var url = "https://www.hapag-lloyd.com/en/online-business/track/track-by-container-solution.html?container=" + Bl;
                window.open(url, "_blank");
                console.log(api_selected);
              }else if (api_selected == 'Evergreen'){
                var url = "https://ct.shipmentlink.com/servlet/TDB1_CargoTracking.do";
                window.open(url, "_blank");
                console.log(api_selected);
              }
            Array.prototype.randomElement = function () {
            return this[Math.floor(Math.random() * this.length)]
            }
               var ajaxCall = $.ajax({
                    url: api+'?lista=' + value,
                    type: 'POST',
                    success: function (data) { 
                       
                    var data_parsed = JSON.parse(data); 
                    $('#ETA').val(data_parsed.ETA_at_Place_of_Delivery);
                    $('#Estimated_ETA').val(data_parsed.Estimated_Date_of_Arrival);
                    $('#Cargo_Cutoff').val(data_parsed.CutOff);
                    $('#POD').val(data_parsed.Point_of_Depature);
                    $('#POL').val(data_parsed.Point_of_Landing);  
              

                    }
                });
            });
    });
}


</script>
    <script src="app-assets/vendors/js/vendors.min.js" type="text/javascript"></script>
    <script src="app-assets/vendors/js/forms/toggle/switchery.min.js" type="text/javascript"></script>
    <script src="app-assets/js/scripts/forms/switch.min.js" type="text/javascript"></script>
    <script src="app-assets/js/core/app-menu.min.js" type="text/javascript"></script>
    <script src="app-assets/js/core/app.min.js" type="text/javascript"></script>
    <script src="app-assets/js/scripts/customizer.min.js" type="text/javascript"></script>
    <script src="app-assets/vendors/js/jquery.sharrre.js" type="text/javascript"></script>
<script>
  $('#dtype').change(function(){
      if($(this).prop('checked') == true){
        $('#tbi-field').hide()
      }else{
        $('#tbi-field').show()
      }
  })
    $('[name="price[]"]').keyup(function(){
      calc()
    })
  $('#new_parcel').click(function(){
    var tr = $('#ptr_clone tr').clone()
    $('#parcel-items tbody').append(tr)
    $('[name="price[]"]').keyup(function(){
      calc()
    })
    $('.number').on('input keyup keypress',function(){
        var val = $(this).val()
        val = val.replace(/[^0-9]/, '');
        val = val.replace(/,/g, '');
        val = val > 0 ? parseFloat(val).toLocaleString("en-US") : 0;
        $(this).val(val)
    })

  })
	$('#manage-parcel').submit(function(e){
		e.preventDefault()
		start_load()
    if($('#parcel-items tbody tr').length <= 0){
      alert_toast("Please add atleast 1 parcel information.","error")
      end_load()
      return false;
    }
		$.ajax({
			url:'ajax.php?action=save_parcel',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
			// if(resp){
      //       resp = JSON.parse(resp)
      //       if(resp.status == 1){
      //         alert_toast('Data successfully saved',"success");
      //         end_load()
      //         var nw = window.open('print_pdets.php?ids='+resp.ids,"_blank","height=700,width=900")
      //       }
			// }
        if(resp == 1){
            alert_toast('Data successfully saved',"success");
            setTimeout(function(){
              location.href = 'index.php?page=parcel_list';
            },2000)

        }
			}
		})
	})
  function displayImgCover(input,_this) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function (e) {
            $('#cover').attr('src', e.target.result);
          }

          reader.readAsDataURL(input.files[0]);
      }
  }
  function calc(){

        var total = 0 ;
         $('#parcel-items [name="price[]"]').each(function(){
          var p = $(this).val();
              p =  p.replace(/,/g,'')
              p = p > 0 ? p : 0;
            total = parseFloat(p) + parseFloat(total)
         })
         if($('#tAmount').length > 0)
         $('#tAmount').text(parseFloat(total).toLocaleString('en-US',{style:'decimal',maximumFractionDigits:2,minimumFractionDigits:2}))
  }
</script>