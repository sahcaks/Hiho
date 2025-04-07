<form class="form form_registration" id="registration" action="enter_bd.php" method="post">
	<p>Регистрация</p>
	<img class="close close_reg" src="img/icons/close.png" alt="close">
	<div class="inputs">
		<div class="form__inbox">
			<label>Имя</label>
			<input id="name_user" type="text" placeholder="Имя" name="name_user" required>
			<span id="name_user_error" class="error"></span>
		</div>
		<div class="form__inbox">
			<label>Пароль</label>
			<input id="password1" name="password_user" type="password" placeholder="**********" required>
			<span id="password_user_error" class="error"></span>
		</div>
		<div class="form__inbox">
			<label>Email</label>
			<input id="email_user" type="email" placeholder="klevakingr45@.COM" name="email_user" required>
			<span id="email_user_error" class="error"></span>
		</div>
		<div class="form__inbox">
			<label>Повторите пароль</label>
			<input id="password2" name="password_2_user" type="password" placeholder="**********" required>
			<span id="password_2_user_error" class="error"></span>
		</div>
	</div>
	<div class="form__btnbox">
		<input type="submit" id="formbtn1" class="form__btn" value="Создать аккаунт" disabled>
		<button class="btn_login" id="btn_log">Уже есть аккаунт</button>
	</div>
</form>


<form class="form form_entry" id="entry">
	<p>Авторизация</p>
	<img class="close close_ent" src="img/icons/close.png" alt="close">
	<div class="form__inbox">
		<label>Имя</label>
		<input id="name_user_entry" type="text" placeholder="Имя" name="name_user" required>
		<span id="name_user_entry_error" class="error"></span>
	</div>
	<div class="form__inbox">
		<label>Пароль</label>
		<input id="password" name="password_user" type="password" placeholder="**********" required>
		<span id="password_entry_error" class="error"></span>
	</div>
	<div class="form__btnbox">
		<input type="submit" id="formbtn2" class="form__btn" value="Войти в аккаунт" disabled>
		<button class="btn_login" id="btn_reg">Нет аккаунта</button>
	</div>
</form>