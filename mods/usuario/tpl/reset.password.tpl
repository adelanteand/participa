<div class="container">
	<div class="row">

		<h1>Acceso</h1>

		{if $msg}
		<div class="alert alert-success">
			{$msg}
		</div>
		{/if}

		<h2>Resetear clave</h2>
		<form role="form" action="/usuarios/recordar/go/?md={$md}" method=post>
			<div class="form-group">
				<label for="ejemplo_email_1">Nueva contraseña</label>
				<input type="password" class="form-control" id="ejemplo_email_1" name="pwda">
			</div>
			<div class="form-group">
				<label for="ejemplo_email_1">Repita contraseña</label>
				<input type="password" class="form-control" id="ejemplo_email_1" name="pwdb">
			</div>
			La contraseña debe tener entre 3 y 10 caracteres
			<br>
			<button type="submit" class="btn btn-default">
				Cambiar contraseña
			</button>
		</form>

	</div>
</div>
