function searchResources() {
    var searchString = document.getElementById('searchBar').value
    console.log(searchString)

    var languageCheckboxes = document.querySelectorAll(".accordion-selector-1 input[type='checkbox']")
    var selectedLanguages = Array.from(languageCheckboxes)
    .filter(function (checkbox) {
      return checkbox.checked;
    })
    .map(function (checkbox) {
      return checkbox.parentElement.textContent.trim();
    });
    console.log(selectedLanguages)

    var artisticStylesCheckboxes = document.querySelectorAll(".accordion-selector-2 input[type='checkbox']")
    var selectedArtisticStyles = Array.from(artisticStylesCheckboxes)
    .filter(function (checkbox) {
      return checkbox.checked
    })
    .map(function (checkbox) {
      return checkbox.parentElement.textContent.trim()
    })
    console.log(selectedArtisticStyles)

    var wayOfInteractionCheckboxes = document.querySelectorAll(".accordion-selector-3 input[type='checkbox']")
    var selectedWaysOfInteraction = Array.from(wayOfInteractionCheckboxes)
    .filter(function (checkbox) {
      return checkbox.checked
    })
    .map(function (checkbox) {
        return checkbox.parentElement.textContent.trim()
    })
    console.log(selectedWaysOfInteraction)

    var searchData = {
      search: searchString,
      languages: selectedLanguages,
      artisticStyles: selectedArtisticStyles,
      waysOfInteraction: selectedWaysOfInteraction
    }

    var xhr = new XMLHttpRequest()
    xhr.open('POST', '../scripts/queries.php')
    xhr.setRequestHeader('Content-Type', 'application/json')
    xhr.setRequestHeader('Access-Control-Allow-Methods', '*')
    xhr.onreadystatechange = function () {
      if(xhr.readyState === 4 && xhr.status === 200) {
        var response = xhr.responseText
        console.log(response)
      }
    }
    xhr.send(JSON.stringify(searchData));
}