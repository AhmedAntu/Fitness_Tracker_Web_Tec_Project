const form = document.getElementById("metricsForm");
const errorMsg = document.getElementById("error");
const tableBody = document.querySelector("#progressTable tbody");

form.addEventListener("submit", function(event) {
  let date = document.getElementById("date").value;
  let strength = document.getElementById("strength").value;
  let cardio = document.getElementById("cardio").value;

  
  if (date === "" || strength === "" || cardio === "") {
    event.preventDefault();
    errorMsg.textContent = "⚠️ Please fill in all fields.";
    return;
  }

  if (strength < 0 || cardio < 0) {
    
    event.preventDefault();
    errorMsg.textContent = "⚠️ Values cannot be negative.";
    return;
  }

  
  errorMsg.textContent = "";

  
  let newRow = document.createElement("tr");
  newRow.innerHTML = `
    <td>${date}</td>
    <td>${strength}</td>
    <td>${cardio}</td>
  `;
  tableBody.appendChild(newRow);

  
  form.reset();

  
  event.preventDefault();
});
