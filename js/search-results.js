  // Parse the query results from the URL parameter
  var resultsParam = decodeURIComponent(
    window.location.search.match(/(\?|&)results=(.*?)(?=&|$)/)[2]
  );
  console.log(resultsParam);
  var results = JSON.parse(resultsParam);
  // Get the table element
  var table = document.getElementById("results-table");

  // Loop through the results and generate rows dynamically
  results.forEach((result) => {
    var row = document.createElement("tr");

    var titleCell = document.createElement("td");
    titleCell.innerHTML = result.name;
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