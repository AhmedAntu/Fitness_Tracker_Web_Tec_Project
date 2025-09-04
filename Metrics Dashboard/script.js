const form = document.getElementById("metricsForm");
const errorMsg = document.getElementById("error");
const tableBody = document.querySelector("#progressTable tbody");

form.addEventListener("submit", function(event) {
  let date = document.getElementById("date").value;
  let strength = document.getElementById("strength").value;
  let cardio = document.getElementById("cardio").value;

  // Prevent form submission if validation fails
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

  // Clear error if all good
  errorMsg.textContent = "";

  // Add to table dynamically
  let newRow = document.createElement("tr");
  newRow.innerHTML = `
    <td>${date}</td>
    <td>${strength}</td>
    <td>${cardio}</td>
  `;
  tableBody.appendChild(newRow);

  // Reset form
  form.reset();

  // Stop actual form submission (for demo only)
  event.preventDefault();
});
