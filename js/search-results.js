var resultsParam = decodeURIComponent(
  window.location.search.match(/(\?|&)results=(.*?)(?=&|$)/)[2]
);
var results = JSON.parse(resultsParam);
var table = document.getElementById("results-table");

function handleTitleClick(result) {
  var isAdminLoggedIn = localStorage.getItem("isAdminLoggedIn");
  localStorage.setItem("rowData", JSON.stringify(result));
  if (isAdminLoggedIn) {
    console.log("rowData");
    window.location.href = "item-page.html";
  } else {
    var loginPopup = document.getElementById("login-popup");
    loginPopup.style.display = "block";
  }
}

results.forEach((result) => {
  var row = document.createElement("tr");

  var titleCell = document.createElement("td");
  titleCell.innerHTML = result.name;

  (function (result) {
    titleCell.addEventListener("click", function () {
      handleTitleClick(result);
    });
  })(result);

  titleCell.classList.add("clickable");

  row.appendChild(titleCell);

  var descriptionCell = document.createElement("td");
  descriptionCell.innerHTML = result.description;
  row.appendChild(descriptionCell);

  var linkCell = document.createElement("td");
  var link = document.createElement("a");
  link.href = result.link;
  link.textContent = result.link;
  linkCell.appendChild(link);
  row.appendChild(linkCell);

  table.appendChild(row);
});
