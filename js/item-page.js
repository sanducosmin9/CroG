document.addEventListener("DOMContentLoaded", function () {
  var rowDataString = localStorage.getItem("rowData");
  var rowData = JSON.parse(decodeURIComponent(rowDataString));

  var titleElement = document.getElementById("title");
  var descriptionElement = document.getElementById("description");
  var linkElement = document.getElementById("link");
  var deleteButton = document.getElementById("delete-btn");
  var submitButton = document.getElementById("submit-btn");

  titleElement.textContent = rowData.name;
  descriptionElement.textContent = rowData.description;
  linkElement.textContent = rowData.link;
  linkElement.href = rowData.link;

  deleteButton.addEventListener("click", function () {
    var id = rowData.id;

    var xhr = new XMLHttpRequest();
    xhr.open("DELETE", "http://localhost:8000/item_controller.php?id=" + id);
    xhr.onreadystatechange = function () {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 204) {
          console.log("Item deleted successfully");

          var notification = document.createElement("div");
          notification.textContent = "Item deleted successfully";
          notification.classList.add("notification");
          document.body.appendChild(notification);

          setTimeout(function () {
            notification.parentNode.removeChild(notification);
          }, 3000);
        } else {
          console.error("Error deleting item");
        }
      }
    };
    xhr.send();
  });

  submitButton.addEventListener("click", function () {
    var id = rowData.id;
    var updatedTitle = titleElement.textContent;
    var updatedDescription = descriptionElement.textContent;
    var updatedLink = linkElement.textContent;

    var data = {
      id: id,
      title: updatedTitle,
      description: updatedDescription,
      link: updatedLink,
    };

    var xhr = new XMLHttpRequest();
    xhr.open("PUT", "http://localhost:8000/item_controller.php?id=" + id);
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.onreadystatechange = function () {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          console.log("Item updated successfully");

          var notification = document.createElement("div");
          notification.textContent = "Item updated successfully";
          notification.classList.add("notification");
          document.body.appendChild(notification);

          setTimeout(function () {
            notification.parentNode.removeChild(notification);
          }, 3000);
        } else {
          console.error("Error updating item");
        }
      }
    };
    xhr.send(JSON.stringify(data));
  });

  localStorage.removeItem("rowData");
});
