$(document).ready(function () {
  // Обработка формы регистрации
  $("#registerForm").on("submit", function (e) {
    e.preventDefault();

    const formData = new FormData(this);

    // Проверка совпадения паролей
    if (formData.get("password") !== formData.get("password_confirm")) {
      alert("Пароли не совпадают");
      return false;
    }

    // Отправка формы на сервер
    $.ajax({
      url: "register.php",
      method: "POST",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json",
      success: function (response) {
        if (response.success) {
          alert("Регистрация успешна");
          $("#registerModal").modal("hide");
          location.reload();
        } else {
          alert(response.message);
        }
      },
      error: function () {
        alert("Произошла ошибка при отправке формы");
      },
    });
  });

  // Проверка паролей в реальном времени
  $('input[name="password"], input[name="password_confirm"]').on(
    "input",
    function () {
      const form = document.getElementById("registerForm");
      const formData = new FormData(form);

      if (formData.get("password_confirm").length > 0) {
        const passwordInput = $('input[name="password_confirm"]');

        if (formData.get("password") === formData.get("password_confirm")) {
          passwordInput.removeClass("is-invalid").addClass("is-valid");
        } else {
          passwordInput.removeClass("is-valid").addClass("is-invalid");
        }
      }
    }
  );

  // Обработка формы входа
  $("#loginForm").on("submit", function (e) {
    e.preventDefault();

    const formData = new FormData(this);

    $.ajax({
      url: "login.php",
      method: "POST",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json",
      success: function (response) {
        if (response.success) {
          location.reload();
        } else {
          alert(response.message);
        }
      },
      error: function () {
        alert("Произошла ошибка при входе");
      },
    });
  });

  function updateSolvedCount() {
    $.ajax({
      url: "get_solved_count.php",
      dataType: "json",
      success: function (response) {
        const currentCount = parseInt($("#solvedCount").text());
        const newCount = parseInt(response.count);

        if (currentCount !== newCount && currentCount < newCount) {
          new Audio("notify.mp3").play();
          $("#solvedCount").animate(
            {
              opacity: 0,
            },
            500,
            function () {
              $(this).text(newCount).animate(
                {
                  opacity: 1,
                },
                500
              );
            }
          );
        } else if (currentCount !== newCount) {
          $("#solvedCount").animate(
            {
              opacity: 0,
            },
            500,
            function () {
              $(this).text(newCount).animate(
                {
                  opacity: 1,
                },
                500
              );
            }
          );
        }
      },
    });
  }

  // Обновление счетчика каждые 5 секунд
  setInterval(updateSolvedCount, 5000);

  // Загрузка решенных заявок
  function loadSolvedRequests() {
    $.ajax({
      url: "get_solved_requests.php",
      success: function (response) {
        $("#solvedRequests").html(response);
      },
    });
  }

  loadSolvedRequests();
});
