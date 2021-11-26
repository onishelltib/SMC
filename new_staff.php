<?php if(!isset($conn)){ include 'db_connect.php'; } ?>
<style>
  textarea{
    resize: none;
  }
</style>
<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-body">
			<form action="" id="manage-staff">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
        <div class="row">
          <div class="col-md-12">
            <div id="msg" class=""></div>

            <div class="row">
              <div class="col-sm-6 form-group ">
                <label for="" class="control-label">Nombre</label>
                <input type="text" name="firstname" id="" class="form-control form-control-sm" value="<?php echo isset($firstname) ? $firstname : '' ?>" required>
              </div>
              <div class="col-sm-6 form-group ">
                <label for="" class="control-label">Apellido</label>
                <input type="text" name="lastname" id="" class="form-control form-control-sm" value="<?php echo isset($lastname) ? $lastname : '' ?>" required>
              </div>
            </div>


            <div class="row">
              <div class="col-sm-6 form-group ">
                <label for="" class="control-label">Email</label>
                <input type="email" name="email" id="" class="form-control form-control-sm" value="<?php echo isset($email) ? $email : '' ?>" required>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-6 form-group ">
                <label for="" class="control-label">Contraseña</label>
                <input type="password" name="password" id="" class="form-control form-control-sm" <?php echo isset($id) ? '' : 'required' ?>>
                <?php if(isset($id)): ?>
                  <small class=""><i>Leave this blank if you dont want to change this</i></small>
                <?php endif; ?>
              </div>
            </div>

            
          </div>
        </div>
      </form>
  	</div>
  	<div class="card-footer border-top border-info">
  		<div class="d-flex w-100 justify-content-center align-items-center">
  			<button class="btn btn-flat  bg-gradient-primary mx-2" form="manage-staff">Guardar</button>
  			<a class="btn btn-flat bg-gradient-secondary mx-2" href="./index.php?page=staff_list">Cancelar</a>
  		</div>
  	</div>
	</div>
</div>
<script>
	$('#manage-staff').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=save_user',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp == 1){
					alert_toast('Datos Guardados Correctamente',"success");
					setTimeout(function(){
              location.href = 'index.php?page=staff_list'
					},2000)
				}else if(resp == 2){
          $('#msg').html('<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Este Email ya Existe.</div>')
          end_load()
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
</script>