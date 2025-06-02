<div class="container is-fluid mb-6">
	<?php 

		$id=$insLogin->limpiarCadena($url[1]);

		if($id==$_SESSION['id']){ 
	?>
	<h1 class="title">Mi cuenta</h1>
	<h2 class="subtitle">Actualizar cuenta</h2>
	<?php }else{ ?>
	<h1 class="title">Pacientes</h1>
	<h2 class="subtitle">Actualizar Paciente</h2>
	<?php } ?>
</div>
<div class="container pb-6 pt-6">
	<?php
	
		include "./app/views/inc/btn_back.php";

		$datos=$insLogin->seleccionarDatos("Unico","paciente","id",$id);

		if($datos->rowCount()==1){
			$datos=$datos->fetch();
	?>

	<h2 class="title has-text-centered"><?php echo $datos['nombre1']." ".$datos['apellido1']; ?></h2>

	<p class="has-text-centered pb-6"><?php echo "<strong>Usuario creado:</strong> ".date("d-m-Y  h:i:s A",strtotime($datos['paciente_creado']))." &nbsp; <strong>Usuario actualizado:</strong> ".date("d-m-Y  h:i:s A",strtotime($datos['paciente_actualizado'])); ?></p>

	<form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/usuarioAjax.php" method="POST" autocomplete="off">

		<input type="hidden" name="modulo_usuario" value="actualizar">
		<input type="hidden" name="id" value="<?php echo $datos['id']; ?>">

		<div class="columns">
			<div class="column">
				<label for="tipo_documento">Tipo Documento</label>
				<select class="input" id="tipo_documento" name="tipo_documento" value="<?php echo $datos['tipo_documento']; ?>" required>
					<option value="" disabled selected>Seleccione</option>
					<option value="1">Cédula de Ciudadanía</option>
					<option value="2">Tarjeta de Identidad</option>
				</select>
			</div>

			<div class="column">
				<label for="numero_documento">Número Documento</label>
				<input class="input" type="text" id="numero_documento" name="numero_documento" pattern="[0-9]{5,20}" maxlength="20" value="<?php echo $datos['numero_documento']; ?>" required>
			</div>

			<div class="column">
				<label for="nombre1">Primer Nombre</label>
				<input class="input" type="text" id="nombre1" name="nombre1" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{2,40}" maxlength="40" value="<?php echo $datos['nombre1']; ?>">
			</div>

			<div class="column">
				<label for="nombre2">Segundo Nombre</label>
				<input class="input" type="text" id="nombre2" name="nombre2" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{2,40}" maxlength="40" value="<?php echo $datos['nombre2']; ?>">
			</div>
		</div>

		<div class="columns">
			<div class="column">
				<label for="apellido1">Primer Apellido</label>
				<input class="input" type="text" id="apellido1" name="apellido1" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{2,40}" maxlength="40" value="<?php echo $datos['apellido1']; ?>" required>
			</div>

			<div class="column">
				<label for="apellido2">Segundo Apellido</label>
				<input class="input" type="text" id="apellido2" name="apellido2" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{2,40}" maxlength="40" value="<?php echo $datos['apellido2']; ?>">
			</div>
		</div>

		<div class="columns">
			<div class="column">
				<label for="genero">Género</label>
				<select class="input" id="genero" name="genero" value="<?php echo $datos['genero']; ?>" required>
					<option value="" disabled selected>Seleccione</option>
					<option value="1">Masculino</option>
					<option value="2">Femenino</option>
				</select>
			</div>

			<div class="column">
				<label for="departamento">Departamento</label>
				<select class="input" id="departamento" name="departamento" value="<?php echo $datos['departamento']; ?>" required>
					<option value="" disabled selected>Seleccione</option>
					<option value="1">Cundinamarca</option>
					<option value="2">Antioquia</option>
					<option value="3">Valle del Cauca</option>
					<option value="4">Bolívar</option>
					<option value="5">Santander</option>
				</select>
			</div>

			<div class="column">
				<label for="municipio">Municipio</label>
				<select class="input" id="municipio" name="municipio" value="<?php echo $datos['municipio']; ?>" required>
					<option value="" disabled selected>Seleccione</option>
					<option value="1">Bogotá</option>
					<option value="2">Soacha</option>
					<option value="3">Medellín</option>
					<option value="4">Bello</option>
					<option value="5">Cali</option>
					<option value="6">Palmira</option>
					<option value="7">Cartagena</option>
					<option value="8">Turbaco</option>
					<option value="9">Bucaramanga</option>
					<option value="10">Floridablanca</option>
				</select>
			</div>

			<div class="column">
				<label for="correo">Correo electrónico</label>
				<input class="input" type="email" id="correo" name="correo" maxlength="100" value="<?php echo $datos['correo']; ?>" required>
			</div>
		</div>
		<p class="has-text-centered">
			Para poder actualizar los datos de este usuario por favor ingrese su USUARIO y CLAVE con la que ha iniciado sesión
		</p>
		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Usuario</label>
				  	<input class="input" type="text" name="administrador_usuario" pattern="[a-zA-Z0-9]{4,20}" maxlength="20"  >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Clave</label>
				  	<input class="input" type="password" name="administrador_clave" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" >
				</div>
		  	</div>
		</div>
		<p class="has-text-centered">
			<button type="submit" class="button is-success is-rounded">Actualizar</button>
		</p>
	</form>

	<?php
		}else{
			include "./app/views/inc/error_alert.php";
		}
	?>
</div>