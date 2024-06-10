function addKeyArea() {
  const container = document.getElementById("keyAreasContainer");
  const index = container.children.length;

  const newDiv = document.createElement("div");
  newDiv.setAttribute("id", "keyArea_" + index);
  newDiv.innerHTML = `
      <h4>Key Area ${index + 1}</h4>
      <label for="keyAreas${index}_title">Title:</label><br>
      <input type="text" name="keyAreas[${index}][title]" id="keyAreas${index}_title" required><br><br>

      <label for="keyAreas${index}_description">Description:</label><br>
      <textarea name="keyAreas[${index}][description]" id="keyAreas${index}_description" required></textarea><br>
      <button type="button" onclick="deleteElement('keyArea', ${index})">Delete</button><br><br>
    `;
  container.appendChild(newDiv);
}

function addClient() {
  const clientsContainer = document.getElementById("clientsContainer");
  const index = clientsContainer.childElementCount;

  const clientDiv = document.createElement("div");
  clientDiv.setAttribute("id", "client_" + index);
  clientDiv.innerHTML = `
        <h3>Review ${index + 1}</h3>
        <label for="clients_reviews_${index}_textReview">Review:</label><br>
        <textarea id="clients_reviews_${index}_textReview" name="clients[reviews][${index}][textReview]" rows="4" cols="50"></textarea><br><br>
        <label for="clients_reviews_${index}_name">Name:</label><br>
        <input type="text" id="clients_reviews_${index}_name" name="clients[reviews][${index}][name]"><br><br>
        <label for="clients_reviews_${index}_position">Position:</label><br>
        <input type="text" id="clients_reviews_${index}_position" name="clients[reviews][${index}][position]"><br><br>
        <button type="button" onclick="deleteElement('client', ${index})">Delete</button><br><br>
    `;
  clientsContainer.appendChild(clientDiv);
}


function addNews() {
    const newsContainer = document.getElementById('newsContainer');
    const index = newsContainer.childElementCount;

    const newsDiv = document.createElement('div');
    newsDiv.setAttribute("id", "news_" + index);
    newsDiv.innerHTML = `
        <h3>News ${index + 1}</h3>
        <label for="news_${index}_type">Type:</label><br>
        <input type="text" id="news_${index}_type" name="news[${index}][type]"><br><br>
        <label for="news_${index}_title">Title:</label><br>
        <input type="text" id="news_${index}_title" name="news[${index}][title]"><br><br>
        <label for="news_${index}_summary">Summary:</label><br>
        <textarea id="news_${index}_summary" name="news[${index}][summary]" rows="4" cols="50"></textarea><br><br>
        <label for="news_${index}_url">URL:</label><br>
        <input type="text" id="news_${index}_url" name="news[${index}][url]"><br><br>
        <button type="button" onclick="deleteElement('news', ${index})">Delete</button><br><br>
    `;
    newsContainer.appendChild(newsDiv);
}

function addLink() {
  const footerLinksContainer = document.getElementById('footerLinksContainer');
  const index = footerLinksContainer.children.length;

  const linkDiv = document.createElement('div');
  linkDiv.setAttribute("id", "footerLink_" + index);
  linkDiv.innerHTML = `
      <h3>Link ${index + 1}</h3>
      <label for="footer_links_${index}_text">Text:</label><br>
      <input type="text" id="footer_links_${index}_text" name="footer[links][${index}][text]"><br><br>
      <label for="footer_links_${index}_url">URL:</label><br>
      <input type="text" id="footer_links_${index}_url" name="footer[links][${index}][url]"><br><br>
      <button type="button" onclick="deleteElement('footerLink', ${index})">Delete</button><br><br>
  `;
  footerLinksContainer.appendChild(linkDiv);
}

function deleteElement(type, index) {
  // Confirm deletion
  if (confirm("Are you sure you want to delete this element?")) {
      // Get the element to delete
      const element = document.getElementById(`${type}_${index}`);
      
      // Remove the element from the DOM
      if (element) {
          element.parentNode.removeChild(element);
      }

  }
}

// JavaScript to control section display
function toggleSection(sectionId) {
  var section = document.getElementById(sectionId);
  
  // Get all sections
  var allSections = document.querySelectorAll('.section');
  
  // Hide all sections except the one we're showing
  allSections.forEach(function(item) {
      if (item.id !== sectionId) {
          item.style.display = 'none';
      }
  });
  
  // Change button text to reflect if the section is open or closed
  if (section.style.display === 'block') {
      section.style.display = 'none';
  } else {
      section.style.display = 'block';
  }
}


function send(){
  document.getElementById("saveForm").style.display = "none";
  var form = document.getElementById('myForm');
  form.submit();
}

function openForm() {
  send();
  document.getElementById("saveForm").style.display = "block";
}

function closeForm() {
  document.getElementById("saveForm").style.display = "none";
}

function generateGfy(value) {
  var regex = /^[a-zA-Z0-9_-]+$/; // Regular expression allowing letters, numbers, underscores, and hyphens
  if (regex.test(value)) {
      document.getElementById('gfy').innerHTML = 'https://my.gfy.dog/v1/' + value;
  } else {
      alert('The identifier contains invalid characters. Please only enter letters, numbers, underscores (_), and hyphens (-).');
  }
}
