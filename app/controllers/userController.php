<?php

	namespace app\controllers;
	use app\models\mainModel;

	class userController extends mainModel{

		
		public function registrarUsuarioControlador(){

			# Almacenando datos#
		    $tipo_documento=$this->limpiarCadena($_POST['tipo_documento']);
		    $numero_documento=$this->limpiarCadena($_POST['numero_documento']);
		    $nombre1=$this->limpiarCadena($_POST['nombre1']);
		    $nombre2=$this->limpiarCadena($_POST['nombre2']);
		    $apellido1=$this->limpiarCadena($_POST['apellido1']);
		    $apellido2=$this->limpiarCadena($_POST['apellido2']);
		    $genero=$this->limpiarCadena($_POST['genero']);
		    $departamento=$this->limpiarCadena($_POST['departamento']);
		    $municipio=$this->limpiarCadena($_POST['municipio']);
		    $correo=$this->limpiarCadena($_POST['correo']);
		    


		
		
		    
		   
		    if($this->verificarDatos("[0-9]{1,20}",$numero_documento)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El DOCUMENTO no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$nombre1)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El NOMBRE1 no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$nombre2)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El NOMBRE2 no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }
			if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$apellido1)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El APELLIDO1 no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }
			if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$apellido2)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El APELLIDO2 no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }
			
			if($this->verificarDatos("[a-zA-Z0-9$@.-]{7,100}",$correo)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El CORREO no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		   
		    if($correo!=""){
				if(filter_var($correo, FILTER_VALIDATE_EMAIL)){
					$check_email=$this->ejecutarConsulta("SELECT id FROM paciente WHERE correo='$correo'");
					if($check_email->rowCount()>0){
						$alerta=[
							"tipo"=>"simple",
							"titulo"=>"Ocurrió un error inesperado",
							"texto"=>"El EMAIL que acaba de ingresar ya se encuentra registrado en el sistema, por favor verifique e intente nuevamente",
							"icono"=>"error"
						];
						return json_encode($alerta);
						exit();
					}
				}else{
					$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"Ha ingresado un correo electrónico no valido",
						"icono"=>"error"
					];
					return json_encode($alerta);
					exit();
				}
            }

    

           
		    $check_usuario=$this->ejecutarConsulta("SELECT numero_documento FROM paciente WHERE numero_documento='$numero_documento'");
		    if($check_usuario->rowCount()>0){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El USUARIO ingresado ya se encuentra registrado, por favor elija otro",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    
    		$img_dir="../views/fotos/";

    		
    		if($_FILES['foto']['name']!="" && $_FILES['foto']['size']>0){

    			
		        if(!file_exists($img_dir)){
		            if(!mkdir($img_dir,0777)){
		            	$alerta=[
							"tipo"=>"simple",
							"titulo"=>"Ocurrió un error inesperado",
							"texto"=>"Error al crear el directorio",
							"icono"=>"error"
						];
						return json_encode($alerta);
		                exit();
		            } 
		        }

		        
		        if(mime_content_type($_FILES['foto']['tmp_name'])!="image/jpeg" && mime_content_type($_FILES['foto']['tmp_name'])!="image/png"){
		        	$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"La imagen que ha seleccionado es de un formato no permitido",
						"icono"=>"error"
					];
					return json_encode($alerta);
		            exit();
		        }

		        if(($_FILES['foto']['size']/1024)>5120){
		        	$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"La imagen que ha seleccionado supera el peso permitido",
						"icono"=>"error"
					];
					return json_encode($alerta);
		            exit();
		        }

		        
		        $foto=str_ireplace(" ","_",$nombre1);
		        $foto=$foto."_".rand(0,100);

		        
		        switch(mime_content_type($_FILES['foto']['tmp_name'])){
		            case 'image/jpeg':
		                $foto=$foto.".jpg";
		            break;
		            case 'image/png':
		                $foto=$foto.".png";
		            break;
		        }

		        chmod($img_dir,0777);

		      
		        if(!move_uploaded_file($_FILES['foto']['tmp_name'],$img_dir.$foto)){
		        	$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"No podemos subir la imagen al sistema en este momento",
						"icono"=>"error"
					];
					return json_encode($alerta);
		            exit();
		        }

    		}else{
    			$foto="";
    		}


		    $paciente_datos_reg=[
				[
					"campo_nombre" => "tipo_documento_id",
					"campo_marcador" => ":TipoDoc",
					"campo_valor" => $tipo_documento
				],
				[
					"campo_nombre" => "numero_documento",
					"campo_marcador" => ":NumDoc",
					"campo_valor" => $numero_documento
				],
				[
					"campo_nombre" => "nombre1",
					"campo_marcador" => ":Nombre1",
					"campo_valor" => $nombre1
				],
				[
					"campo_nombre" => "nombre2",
					"campo_marcador" => ":Nombre2",
					"campo_valor" => $nombre2
				],
				[
					"campo_nombre" => "apellido1",
					"campo_marcador" => ":Apellido1",
					"campo_valor" => $apellido1
				],
				[
					"campo_nombre" => "apellido2",
					"campo_marcador" => ":Apellido2",
					"campo_valor" => $apellido2
				],
				[
					"campo_nombre" => "genero_id",
					"campo_marcador" => ":Genero",
					"campo_valor" => $genero
				],
				[
					"campo_nombre" => "departamento_id",
					"campo_marcador" => ":Departamento",
					"campo_valor" => $departamento
				],
				[
					"campo_nombre" => "municipio_id",
					"campo_marcador" => ":Municipio",
					"campo_valor" => $municipio
				],
				[
					"campo_nombre" => "correo",
					"campo_marcador" => ":Correo",
					"campo_valor" => $correo
				],
				[
					"campo_nombre" => "foto",
					"campo_marcador" => ":Foto",
					"campo_valor" => $foto
				]
			];

			



			$registrar_usuario=$this->guardarDatos("paciente",$paciente_datos_reg);

			if($registrar_usuario->rowCount()==1){
				$alerta=[
					"tipo"=>"limpiar",
					"titulo"=>"Paciente registrado",
					"texto"=>"El paciente ".$nombre1." ".$apellido1." se registro con exito",
					"icono"=>"success"
				];
			}else{
				
				if(is_file($img_dir.$foto)){
		            chmod($img_dir.$foto,0777);
		            unlink($img_dir.$foto);
		        }

				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No se pudo registrar el usuario, por favor intente nuevamente",
					"icono"=>"error"
				];
			}

			return json_encode($alerta);

		}



		
		public function listarUsuarioControlador($pagina,$registros,$url,$busqueda){

			$pagina=$this->limpiarCadena($pagina);
			$registros=$this->limpiarCadena($registros);

			$url=$this->limpiarCadena($url);
			$url=APP_URL.$url."/";

			$busqueda=$this->limpiarCadena($busqueda);
			$tabla="";

			$pagina = (isset($pagina) && $pagina>0) ? (int) $pagina : 1;
			$inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;

			if(isset($busqueda) && $busqueda!=""){

				$consulta_datos="SELECT * FROM paciente WHERE ((id!='".$_SESSION['id']."' AND id!='1') AND (nombre1 LIKE '%$busqueda%' OR apellido1 LIKE '%$busqueda%' OR correo LIKE '%$busqueda%' OR nombre2 LIKE '%$busqueda%')) ORDER BY apellido2 ASC LIMIT $inicio,$registros";

				$consulta_total="SELECT COUNT(id) FROM paciente WHERE ((id!='".$_SESSION['id']."' AND id!='1') AND (nombre1 LIKE '%$busqueda%' OR apellido1 LIKE '%$busqueda%' OR correo LIKE '%$busqueda%' OR apellido2 LIKE '%$busqueda%'))";

			}else{

				$consulta_datos="SELECT * FROM paciente WHERE id!='".$_SESSION['id']."' AND id!='1' ORDER BY nombre1 ASC LIMIT $inicio,$registros";

				$consulta_total="SELECT COUNT(id) FROM paciente WHERE id!='".$_SESSION['id']."' AND id!='1'";

			}

			$datos = $this->ejecutarConsulta($consulta_datos);
			$datos = $datos->fetchAll();

			$total = $this->ejecutarConsulta($consulta_total);
			$total = (int) $total->fetchColumn();

			$numeroPaginas =ceil($total/$registros);

			$tabla.='
		        <div class="table-container">
		        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
		            <thead>
		                <tr>
		                    <th class="has-text-centered">#</th>
		                    <th class="has-text-centered">Tipo Documento</th>
		                    <th class="has-text-centered">Documento</th>
		                    <th class="has-text-centered">Primer Nombre</th>
		                    <th class="has-text-centered">Segundo Nombre</th>
		                    <th class="has-text-centered">Primer Apellido</th>
		                    <th class="has-text-centered">Segundo Apellido</th>
		                    <th class="has-text-centered">Genero</th>
		                    <th class="has-text-centered">Departamento</th>
		                    <th class="has-text-centered">Municipio</th>
		                    <th class="has-text-centered">Correo</th>
							<th class="has-text-centered">Creado</th>
							<th class="has-text-centered">Actualizado</th>
		                    <th class="has-text-centered" colspan="3">Opciones</th>
		                </tr>
		            </thead>
		            <tbody>
		    ';

		    if($total>=1 && $pagina<=$numeroPaginas){
				$contador=$inicio+1;
				$pag_inicio=$inicio+1;
				foreach($datos as $rows){
					$tabla.='
					<tr class="has-text-centered">
						<td>'.$contador.'</td>
						<td>'.$rows['tipo_documento_id'].'</td>
						<td>'.$rows['numero_documento'].'</td>
						<td>'.$rows['nombre1'].'</td>
						<td>'.$rows['nombre2'].'</td>
						<td>'.$rows['apellido1'].'</td>
						<td>'.$rows['apellido2'].'</td>
						<td>'.$rows['genero_id'].'</td>
						<td>'.$rows['departamento_id'].'</td>
						<td>'.$rows['municipio_id'].'</td>
						<td>'.$rows['correo'].'</td>
						<td>'.date("d-m-Y h:i:s A",strtotime($rows['paciente_creado'])).'</td>
						<td>'.date("d-m-Y h:i:s A",strtotime($rows['paciente_actualizado'])).'</td>
						<td>
			                <a href="'.APP_URL.'userPhoto/'.$rows['id'].'/" class="button is-info is-rounded is-small">Foto</a>
			                </td>
			                <td>
			                    <a href="'.APP_URL.'userUpdate/'.$rows['id'].'/" class="button is-success is-rounded is-small">Actualizar</a>
			                </td>
			                <td>
			                	<form class="FormularioAjax" action="'.APP_URL.'app/ajax/usuarioAjax.php" method="POST" autocomplete="off" >

			                		<input type="hidden" name="modulo_usuario" value="eliminar">
			                		<input type="hidden" name="id" value="'.$rows['id'].'">

			                    	<button type="submit" class="button is-danger is-rounded is-small">Eliminar</button>
			                    </form>
			                </td>
						</tr>
					';
					$contador++;
				}
				$pag_final=$contador-1;
			}else{
				if($total>=1){
					$tabla.='
						<tr class="has-text-centered" >
			                <td colspan="7">
			                    <a href="'.$url.'1/" class="button is-link is-rounded is-small mt-4 mb-4">
			                        Haga clic acá para recargar el listado
			                    </a>
			                </td>
			            </tr>
					';
				}else{
					$tabla.='
						<tr class="has-text-centered" >
			                <td colspan="7">
			                    No hay registros en el sistema
			                </td>
			            </tr>
					';
				}
			}

			$tabla.='</tbody></table></div>';

			
			if($total>0 && $pagina<=$numeroPaginas){
				$tabla.='<p class="has-text-right">Mostrando usuarios <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>';

				$tabla.=$this->paginadorTablas($pagina,$numeroPaginas,$url,7);
			}

			return $tabla;
		}




		
		public function eliminarUsuarioControlador(){

			$id=$this->limpiarCadena($_POST['id']);

			if($id==1){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No podemos eliminar el usuario principal del sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
			}

			
		    $datos=$this->ejecutarConsulta("SELECT * FROM paciente WHERE id='$id'");
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado el usuario en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }else{
		    	$datos=$datos->fetch();
		    }

		    $eliminarUsuario=$this->eliminarRegistro("paciente","id",$id);

		    if($eliminarUsuario->rowCount()==1){

		    	if(is_file("../views/fotos/".$datos['foto'])){
		            chmod("../views/fotos/".$datos['foto'],0777);
		            unlink("../views/fotos/".$datos['foto']);
		        }

		        $alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Usuario eliminado",
					"texto"=>"El usuario ".$datos['nombre1']." ".$datos['apellido1']." ha sido eliminado del sistema correctamente",
					"icono"=>"success"
				];

		    }else{

		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos podido eliminar el usuario ".$datos['nombre1']." ".$datos['apellido1']." del sistema, por favor intente nuevamente",
					"icono"=>"error"
				];
		    }

		    return json_encode($alerta);
		}


		
		public function actualizarUsuarioControlador(){

			$id=$this->limpiarCadena($_POST['id']);

			
		    $datos=$this->ejecutarConsulta("SELECT * FROM paciente WHERE id='$id'");
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado el usuario en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }else{
		    	$datos=$datos->fetch();
		    }

		    $admin_usuario=$this->limpiarCadena($_POST['administrador_usuario']);
		    $admin_clave=$this->limpiarCadena($_POST['administrador_clave']);

		   
		    if($admin_usuario=="" || $admin_clave==""){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No ha llenado todos los campos que son obligatorios, que corresponden a su USUARIO y CLAVE",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    if($this->verificarDatos("[a-zA-Z0-9]{4,20}",$admin_usuario)){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"Su USUARIO no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    if($this->verificarDatos("[a-zA-Z0-9$@.-]{7,100}",$admin_clave)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"Su CLAVE no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		   
		    $check_admin=$this->ejecutarConsulta("SELECT * FROM usuario WHERE usuario_usuario='$admin_usuario' AND usuario_id='".$_SESSION['id']."'");
		    if($check_admin->rowCount()==1){

		    	$check_admin=$check_admin->fetch();

		    	if($check_admin['usuario_usuario']!=$admin_usuario || !password_verify($admin_clave,$check_admin['usuario_clave'])){

		    		$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"USUARIO o CLAVE de administrador incorrectos",
						"icono"=>"error"
					];
					return json_encode($alerta);
		        	exit();
		    	}
		    }else{
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"USUARIO o CLAVE de administrador incorrectos",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }


			
		    $tipo_documento=$this->limpiarCadena($_POST['tipo_documento']);
		    $numero_documento=$this->limpiarCadena($_POST['numero_documento']);
		    $nombre1=$this->limpiarCadena($_POST['nombre1']);
		    $nombre2=$this->limpiarCadena($_POST['nombre2']);
		    $apellido1=$this->limpiarCadena($_POST['apellido1']);
		    $apellido2=$this->limpiarCadena($_POST['apellido2']);
		    $genero=$this->limpiarCadena($_POST['genero']);
		    $departamento=$this->limpiarCadena($_POST['departamento']);
		    $municipio=$this->limpiarCadena($_POST['municipio']);
		    $correo=$this->limpiarCadena($_POST['correo']);

		
		    if($tipo_documento=="" || $numero_documento=="" || $nombre1=="" || $nombre2=="" || $apellido1=="" || $apellido2=="" || $genero=="" || $departamento=="" || $municipio=="" || $correo==""){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No has llenado todos los campos que son obligatorios",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }
			
		    if($this->verificarDatos("[a-zA-Z0-9]{4,20}",$numero_documento)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El DOCUMENTO no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    
		    if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$nombre1)){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El NOMBRE no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$nombre2)){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El APELLIDO no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$apellido1)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El PRIMER APELLIDO no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

			
		    if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$apellido2)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El SEGUNDO APELLIDO no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }
			
		    if($this->verificarDatos("[a-zA-Z0-9$@.-]{7,100}",$correo)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El CORREO no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    
		    if($correo!="" && $datos['correo']!=$correo){
				if(filter_var($correo, FILTER_VALIDATE_EMAIL)){
					$check_email=$this->ejecutarConsulta("SELECT correo FROM paciente WHERE correo='correo'");
					if($check_email->rowCount()>0){
						$alerta=[
							"tipo"=>"simple",
							"titulo"=>"Ocurrió un error inesperado",
							"texto"=>"El EMAIL que acaba de ingresar ya se encuentra registrado en el sistema, por favor verifique e intente nuevamente",
							"icono"=>"error"
						];
						return json_encode($alerta);
						exit();
					}
				}else{
					$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"Ha ingresado un correo electrónico no valido",
						"icono"=>"error"
					];
					return json_encode($alerta);
					exit();
				}
            }

           

            
            if($datos['nombre1']!=$nombre1 ){
			    $check_usuario=$this->ejecutarConsulta("SELECT nombre1 FROM paciente WHERE nombre1='$nombre1'");
			    if($check_usuario->rowCount()>0){
			        $alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"El USUARIO ingresado ya se encuentra registrado, por favor elija otro",
						"icono"=>"error"
					];
					return json_encode($alerta);
			        exit();
			    }
            }

            $usuario_datos_up=[
				[
					"campo_nombre" => "tipo_documento_id",
					"campo_marcador" => ":TipoDoc",
					"campo_valor" => $tipo_documento
				],
				[
					"campo_nombre" => "numero_documento",
					"campo_marcador" => ":NumDoc",
					"campo_valor" => $numero_documento
				],
				[
					"campo_nombre" => "nombre1",
					"campo_marcador" => ":Nombre1",
					"campo_valor" => $nombre1
				],
				[
					"campo_nombre" => "nombre2",
					"campo_marcador" => ":Nombre2",
					"campo_valor" => $nombre2
				],
				[
					"campo_nombre" => "apellido1",
					"campo_marcador" => ":Apellido1",
					"campo_valor" => $apellido1
				],
				[
					"campo_nombre" => "apellido2",
					"campo_marcador" => ":Apellido2",
					"campo_valor" => $apellido2
				],
				[
					"campo_nombre" => "genero_id",
					"campo_marcador" => ":Genero",
					"campo_valor" => $genero
				],
				[
					"campo_nombre" => "departamento_id",
					"campo_marcador" => ":Departamento",
					"campo_valor" => $departamento
				],
				[
					"campo_nombre" => "municipio_id",
					"campo_marcador" => ":Municipio",
					"campo_valor" => $municipio
				],
				[
					"campo_nombre" => "correo",
					"campo_marcador" => ":Correo",
					"campo_valor" => $correo
				],
				[
					"campo_nombre"=>"paciente_actualizado",
					"campo_marcador"=>":Actualizado",
					"campo_valor"=>date("Y-m-d H:i:s")
				]
			];

			$condicion=[
				"condicion_campo"=>"id",
				"condicion_marcador"=>":ID",
				"condicion_valor"=>$id
			];

			if($this->actualizarDatos("paciente",$usuario_datos_up,$condicion)){

				if($id==$_SESSION['id']){
					$_SESSION['tipo_documento']=$tipo_documento;
					$_SESSION['numero_documento']=$numero_documento;
					$_SESSION['nombre1']=$nombre1;
					$_SESSION['nombre2']=$nombre2;
					$_SESSION['apellido1']=$apellido1;
					$_SESSION['apellido2']=$apellido2;
					$_SESSION['genero']=$genero;
					$_SESSION['departamento']=$departamento;
					$_SESSION['municipio']=$municipio;
					$_SESSION['correo']=$correo;
				}

				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Usuario actualizado",
					"texto"=>"Los datos del usuario ".$datos['nombre1']." ".$datos['apellido1']." se actualizaron correctamente",
					"icono"=>"success"
				];
			}else{
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos podido actualizar los datos del usuario ".$datos['nombre1']." ".$datos['apellido1'].", por favor intente nuevamente",
					"icono"=>"error"
				];
			}

			return json_encode($alerta);
		}


	
		public function eliminarFotoUsuarioControlador(){

			$id=$this->limpiarCadena($_POST['id']);

			# Verificando usuario #
		    $datos=$this->ejecutarConsulta("SELECT * FROM paciente WHERE id='$id'");
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado el usuario en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }else{
		    	$datos=$datos->fetch();
		    }

		  
    		$img_dir="../views/fotos/";

    		chmod($img_dir,0777);

    		if(is_file($img_dir.$datos['foto'])){

		        chmod($img_dir.$datos['foto'],0777);

		        if(!unlink($img_dir.$datos['foto'])){
		            $alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"Error al intentar eliminar la foto del usuario, por favor intente nuevamente",
						"icono"=>"error"
					];
					return json_encode($alerta);
		        	exit();
		        }
		    }else{
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado la foto del usuario en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    $usuario_datos_up=[
				[
					"campo_nombre"=>"foto",
					"campo_marcador"=>":Foto",
					"campo_valor"=>""
				],
				[
					"campo_nombre"=>"paciente_actualizado",
					"campo_marcador"=>":Actualizado",
					"campo_valor"=>date("Y-m-d H:i:s")
				]
			];

			$condicion=[
				"condicion_campo"=>"id",
				"condicion_marcador"=>":ID",
				"condicion_valor"=>$id
			];

			if($this->actualizarDatos("paciente",$usuario_datos_up,$condicion)){

				if($id==$_SESSION['id']){
					$_SESSION['foto']="";
				}

				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Foto eliminada",
					"texto"=>"La foto del usuario ".$datos['usuario_nombre']." ".$datos['usuario_apellido']." se elimino correctamente",
					"icono"=>"success"
				];
			}else{
				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Foto eliminada",
					"texto"=>"No hemos podido actualizar algunos datos del usuario ".$datos['usuario_nombre']." ".$datos['usuario_apellido'].", sin embargo la foto ha sido eliminada correctamente",
					"icono"=>"warning"
				];
			}

			return json_encode($alerta);
		}


		
		public function actualizarFotoUsuarioControlador(){

			$id=$this->limpiarCadena($_POST['usuario_id']);

			
		    $datos=$this->ejecutarConsulta("SELECT * FROM usuario WHERE usuario_id='$id'");
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado el usuario en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }else{
		    	$datos=$datos->fetch();
		    }

		    
    		$img_dir="../views/fotos/";

    		
    		if($_FILES['usuario_foto']['name']=="" && $_FILES['usuario_foto']['size']<=0){
    			$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No ha seleccionado una foto para el usuario",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
    		}

    		
	        if(!file_exists($img_dir)){
	            if(!mkdir($img_dir,0777)){
	                $alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"Error al crear el directorio",
						"icono"=>"error"
					];
					return json_encode($alerta);
	                exit();
	            } 
	        }

	        
	        if(mime_content_type($_FILES['usuario_foto']['tmp_name'])!="image/jpeg" && mime_content_type($_FILES['usuario_foto']['tmp_name'])!="image/png"){
	            $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"La imagen que ha seleccionado es de un formato no permitido",
					"icono"=>"error"
				];
				return json_encode($alerta);
	            exit();
	        }

	       
	        if(($_FILES['usuario_foto']['size']/1024)>5120){
	            $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"La imagen que ha seleccionado supera el peso permitido",
					"icono"=>"error"
				];
				return json_encode($alerta);
	            exit();
	        }

	        
	        if($datos['usuario_foto']!=""){
		        $foto=explode(".", $datos['usuario_foto']);
		        $foto=$foto[0];
	        }else{
	        	$foto=str_ireplace(" ","_",$datos['usuario_nombre']);
	        	$foto=$foto."_".rand(0,100);
	        }
	        

	        
	        switch(mime_content_type($_FILES['usuario_foto']['tmp_name'])){
	            case 'image/jpeg':
	                $foto=$foto.".jpg";
	            break;
	            case 'image/png':
	                $foto=$foto.".png";
	            break;
	        }

	        chmod($img_dir,0777);

	        
	        if(!move_uploaded_file($_FILES['usuario_foto']['tmp_name'],$img_dir.$foto)){
	            $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No podemos subir la imagen al sistema en este momento",
					"icono"=>"error"
				];
				return json_encode($alerta);
	            exit();
	        }

	       
	        if(is_file($img_dir.$datos['usuario_foto']) && $datos['usuario_foto']!=$foto){
		        chmod($img_dir.$datos['usuario_foto'], 0777);
		        unlink($img_dir.$datos['usuario_foto']);
		    }

		    $usuario_datos_up=[
				[
					"campo_nombre"=>"usuario_foto",
					"campo_marcador"=>":Foto",
					"campo_valor"=>$foto
				],
				[
					"campo_nombre"=>"usuario_actualizado",
					"campo_marcador"=>":Actualizado",
					"campo_valor"=>date("Y-m-d H:i:s")
				]
			];

			$condicion=[
				"condicion_campo"=>"usuario_id",
				"condicion_marcador"=>":ID",
				"condicion_valor"=>$id
			];

			if($this->actualizarDatos("usuario",$usuario_datos_up,$condicion)){

				if($id==$_SESSION['id']){
					$_SESSION['foto']=$foto;
				}

				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Foto actualizada",
					"texto"=>"La foto del usuario ".$datos['usuario_nombre']." ".$datos['usuario_apellido']." se actualizo correctamente",
					"icono"=>"success"
				];
			}else{

				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Foto actualizada",
					"texto"=>"No hemos podido actualizar algunos datos del usuario ".$datos['usuario_nombre']." ".$datos['usuario_apellido']." , sin embargo la foto ha sido actualizada",
					"icono"=>"warning"
				];
			}

			return json_encode($alerta);
		}

	}