<div class="container is-fluid mb-6">
	<h1 class="title">PACIENTES</h1>
	<h2 class="subtitle">Nuevo Paciente</h2>
</div>

<div class="container pb-6 pt-6">

	<form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/usuarioAjax.php" method="POST" autocomplete="off" enctype="multipart/form-data">

		<input type="hidden" name="modulo_usuario" value="registrar">

		<div class="columns">
			<div class="column">
				<label for="tipo_documento">Tipo Documento</label>
				<select class="input" id="tipo_documento" name="tipo_documento" required>
					<option value="" disabled selected>Seleccione</option>
					<option value="1">Cédula de Ciudadanía</option>
					<option value="2">Tarjeta de Identidad</option>
				</select>
			</div>

			<div class="column">
				<label for="numero_documento">Número Documento</label>
				<input class="input" type="text" id="numero_documento" name="numero_documento" pattern="[0-9]{5,20}" maxlength="20" required>
			</div>

			<div class="column">
				<label for="nombre1">Primer Nombre</label>
				<input class="input" type="text" id="nombre1" name="nombre1" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{2,40}" maxlength="40" required>
			</div>

			<div class="column">
				<label for="nombre2">Segundo Nombre</label>
				<input class="input" type="text" id="nombre2" name="nombre2" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{2,40}" maxlength="40">
			</div>
		</div>

		<div class="columns">
			<div class="column">
				<label for="apellido1">Primer Apellido</label>
				<input class="input" type="text" id="apellido1" name="apellido1" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{2,40}" maxlength="40" required>
			</div>

			<div class="column">
				<label for="apellido2">Segundo Apellido</label>
				<input class="input" type="text" id="apellido2" name="apellido2" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{2,40}" maxlength="40">
			</div>
		</div>

		<div class="columns">
			<div class="column">
				<label for="genero">Género</label>
				<select class="input" id="genero" name="genero" required>
					<option value="" disabled selected>Seleccione</option>
					<option value="1">Masculino</option>
					<option value="2">Femenino</option>
				</select>
			</div>

			<div class="column">
				<label for="departamento">Departamento</label>
				<select class="input" id="departamento" name="departamento" required>
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
				<select class="input" id="municipio" name="municipio" required>
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
				<input class="input" type="email" id="correo" name="correo" maxlength="100" required>
			</div>
		</div>

		<div class="columns">
			<div class="column">
				<div class="file has-name is-boxed">
					<label class="file-label">
						<input class="file-input" type="file" id="foto" name="foto" accept=".jpg, .png, .jpeg">
						<span class="file-cta">
							<span class="file-label">Seleccione una foto</span>
						</span>
						<span class="file-name">JPG, JPEG, PNG. (MAX 5MB)</span>
					</label>
				</div>
			</div>
		</div>

		<p class="has-text-centered">
			<button type="reset" class="button is-link is-light is-rounded">Limpiar</button>
			<button type="submit" class="button is-info is-rounded">Guardar</button>
		</p>
	</form>

</div>