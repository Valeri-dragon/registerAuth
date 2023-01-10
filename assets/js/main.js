document.addEventListener("DOMContentLoaded", function () {
  const register = document.querySelector(".register");
  function userRegister(url) {
    let xhr = new XMLHttpRequest();
    console.log(xhr);

    let formData = new FormData(document.forms.registerForm);

    xhr.open("POST", url, true);
    xhr.responseType = "json";
    xhr.onload = function () {
      if (xhr.status == 200) {
        let answer = xhr.response;
        console.log(answer);
        if (answer.error) {
          document.getElementById("registerError").innerHTML = answer.error;
        } else {
          document.getElementById("registerSucces").innerHTML = answer.error;
          setTimeout(function () {
            location.reload(true);
          }, 3000);
        }
      }
    };

    xhr.send(formData);
  }
  register.addEventListener("click", () => {
    userRegister("/");
     });
});
