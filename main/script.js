// Wait for the document to be ready
$(document).ready(function() {
    // Handle form submission
    $("#search-form").submit(function(event) {
      // Prevent default form submission behavior
      event.preventDefault();
      // Get the search input value
      var searchInput = $("#search-input").val();
      // Clear the search results
      $("#search-results").empty();
      // Send a GET request to the Github API
      $.get("https://api.github.com/search/repositories?q=" + searchInput, function(data) {
        // Loop through the search results and display them
        $.each(data.items, function(index, item) {
          // Create a new search result element
          var searchResult = $("<div class='panel panel-default'>");
          // Add the repository name and description
          searchResult.append("<div class='panel-heading'>" + item.full_name + "</div>");
          searchResult.append("<div class='panel-body'>" + item.description + "</div>");
          // Add the number of stars and forks
          searchResult.append("<div class='panel-footer'>" + item.stargazers_count + " stars | " + item.forks_count + " forks</div>");
  
          // Create a "Save Link" button
          var saveButton = $("<button class='btn btn-primary float-right'>Save Link</button>");
          // Store the repository URL as data attribute
          saveButton.data("url", item.html_url);
          // Add click event handler for the save button
          saveButton.click(function() {
            var url = $(this).data("url");
            // Save the link to the SQL table
            saveLinkToDatabase(url);
          });
  
          // Add the save button to the search result element
          searchResult.append(saveButton);
  
          // Add the search result element to the search results container
          $("#search-results").append(searchResult);
        });
      });
    });
  
    // Function to save the link to the SQL table
    function saveLinkToDatabase(url) {
      // Send an AJAX request to save the link
      $.ajax({
        url: "save_link.php", // Update the URL with the correct path to the PHP file
        method: "POST",
        data: { url: url },
        success: function(response) {
          console.log("Link saved successfully");
          // Update the saved links display
          
        },
        error: function(xhr, status, error) {
          console.error("Error saving link:", error);
        }
      });
    }
  });
  