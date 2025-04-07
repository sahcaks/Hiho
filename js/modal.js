//регистрация с ajax
var btnlogin = document.getElementById("login"); //кнопка входа
var btnreg = document.getElementById("btn_reg"); //кнопка перехода на регистрацию в форме
var btnlog = document.getElementById("btn_log"); //кнопка перехода на авторизацию в форме
var modal_registration = document.getElementById("registration"); //модалка на регистрацию
var modal_entry = document.getElementById("entry"); //модалка на авторизацию

var btnclose_reg = document.getElementsByClassName("close_reg")[0]; //закрыть модарку регистрации
var btnclose_ent = document.getElementsByClassName("close_ent")[0]; //закрыть модаклу авторизации

btnlogin.addEventListener("click", function () {
  //открвть модалку на вход при клике на кноппочку
  modal_entry.style.display = "block";
  document.body.classList.add("modal-open");
});
btnreg.addEventListener("click", function (event) {
  //открыть модалку на регистрацию при клике на кнопочку регистрации
  event.preventDefault();
  modal_registration.style.display = "block";
  modal_entry.style.display = "none";
});
btnlog.addEventListener("click", function (event) {
  //обратно на вход с регистрации
  event.preventDefault();
  modal_registration.style.display = "none";
  modal_entry.style.display = "block";
});

btnclose_reg.addEventListener("click", function () {
  //усю регистрацию закрыть на крэстик
  modal_registration.style.display = "none";
  document.body.classList.remove("modal-open");
});

btnclose_ent.addEventListener("click", function () {
  //вход закрыть на крэстик
  modal_entry.style.display = "none";
  document.body.classList.remove("modal-open");
});

function inputError(name, error) {
  // Вывод ошибки при её наличии и блокировка кнопки отправки формы
  if (error) {
    $("#" + name + "_error").html(error); // вывод текста ошибок
    $("#" + name + "_error").show(); // текст ошибок
    $('input[class="form__btn"]').attr("disabled", true); //блок кнопки отправки пр ошибкке
  } else {
    $("#" + name + "_error").html(error);
    $("#" + name).removeClass("error_input");
  }
}

// обработка форм с ajax-запросами
$("input").bind("input", function (e) {
  var name_user = $("#name_user").val(); // получение данных из полей
  var email_user = $("#email_user").val();
  var password_user = $("#password1").val();
  var password_2_user = $("#password2").val();

  var name_user_entry = $("#name_user_entry").val();
  var password_entry = $("#password").val();

  $.ajax({
    type: "POST",
    url: "error.php",
    data: {
      name_user: name_user,
      email_user: email_user,
      password_user: password_user,
      password_2_user: password_2_user,

      name_user_entry: name_user_entry,
      password_entry: password_entry,
    },
    dataType: "json",
    success: function (data) {
      // обработка ошибок в форме
      // каждый раз проверяется input в котором стоит курсор, чтобы инпуты не зависели друг от друга
      if (e.target.id === "name_user") {
        var nameError = data.text_error["name_user"];
        inputError("name_user", nameError);
      }

      // обработка двух паролей чтобы при изменении одного показывало ошибку что второй тоже надол поменяц
      if (e.target.id === "password1") {
        var firstPasswordError = data.text_error["password_user"];
        inputError("password_user", firstPasswordError);
        var secondPasswordError = data.text_error["password_2_user"];
        if (data.text_error["password_2_user"] == "Пароли не совпадают") {
          inputError("password_2_user", secondPasswordError);
        }
        if (data.text_error["password_2_user"] == false) {
          inputError("password_2_user", secondPasswordError);
        }
      }

      if (e.target.id === "password2") {
        var secondPasswordError = data.text_error["password_2_user"];
        inputError("password_2_user", secondPasswordError);
      }

      if (e.target.id === "email_user") {
        var emailError = data.text_error["email_user"];
        inputError("email_user", emailError);
      }

      var enterPasError = data.text_error["password_entry"];
      if (e.target.id === "name_user_entry") {
        var enterNameError = data.text_error["name_user_entry"];
        inputError("name_user_entry", enterNameError);
        inputError("password_entry", enterPasError);
      }

      if (e.target.id === "password") {
        inputError("password_entry", enterPasError);
      }

      if (
        data.text_error["name_user"] == false &&
        data.text_error["password_user"] == false &&
        data.text_error["password_2_user"] == false &&
        data.text_error["email_user"] == false
      ) {
        $('input[id="formbtn1"]').attr("disabled", false);
      }

      if (
        data.text_error["name_user_entry"] == false &&
        data.text_error["password_entry"] == false
      ) {
        $('input[id="formbtn2"]').attr("disabled", false);
      }
    },
  });
  // останавливаем дабы не перезагружалась страница
  return false;
});

// ajax-обработка пароля после клика на кнопку "войти"
$("#formbtn2").bind("click", function (e) {
  var name_user_entry = $("#name_user_entry").val();
  var password_entry = $("#password").val();
  $.ajax({
    type: "POST",
    url: "authorization.php",
    data: {
      password_entry: password_entry,
      name_user_entry: name_user_entry,
    },
    success: function (data) {
      if (data == "Неверный пароль") {
        inputError("password_entry", data);
      } else {
        alert("Вы вошли в аккаунт");
        function reload() {
          top.location = "main.php";
        }
        reload();
      }
    },
  });
  return false;
});
