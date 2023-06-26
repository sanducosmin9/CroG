var form = document.getElementById("add-resource-form");

      form.addEventListener("submit", function (event) {
        event.preventDefault();

        formData = new FormData(form);
        var xhr = new XMLHttpRequest();

        xhr.open("POST", `http://localhost:8000/add_resource.php`);
        xhr.setRequestHeader("Content-Type", "application/json");

        xhr.onload = function () {
          if (xhr.status === 200) {
            console.log("success");
          } else {
            console.log("failure");
          }
        };

        var object = {
          title: formData.get("title"),
          description: formData.get("description"),
          type: formData.get("resource-type"),
          subtype: formData.get("resource-subtype"),
          link: formData.get("link"),
        };

        console.log(object);

        xhr.send(JSON.stringify(object));
      });