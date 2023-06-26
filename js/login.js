document.addEventListener("DOMContentLoaded", function() {
    var loginForm = document.getElementById("admin-login-form");
    loginForm.addEventListener("submit", function(event) {
      event.preventDefault();
      var username = document.getElementById("username").value;
      var password = document.getElementById("password").value;
  
      var xhr = new XMLHttpRequest();
      xhr.open("POST", "http://localhost:8000/login.php", true);
      xhr.setRequestHeader("Content-Type", "application/json");
      xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
          console.log(xhr.responseText);
          var response = JSON.parse(xhr.responseText);
          if (response.success) {
            localStorage.setItem("isAdmin", true);
            localStorage.setItem("isAdminLoggedIn", true);
            window.location.href = "item-page.html";
          } else {
            alert("Invalid credentials. Please try again.");
          }
        }
      };
      var data = {
        username: username,
        password: password
      };
      var jsonData = JSON.stringify(data); 
      xhr.send(jsonData);
    });
  });
  