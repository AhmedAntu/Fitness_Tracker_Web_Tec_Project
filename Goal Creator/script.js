const form = document.getElementById("goalForm");
const errorMsg = document.getElementById("error");
const goalList = document.getElementById("goalList");

form.addEventListener("submit", function(event) {
  let goalName = document.getElementById("goalName").value.trim();
  let target = document.getElementById("target").value;
  let deadline = document.getElementById("deadline").value;

  // Validation
  if (goalName === "" || target === "" || deadline === "") {
    event.preventDefault();
    errorMsg.textContent = "⚠️ Please fill in all fields.";
    return;
  }

  if (target <= 0) {
    event.preventDefault();
    errorMsg.textContent = "⚠️ Target must be greater than 0.";
    return;
  }

  let today = new Date().toISOString().split("T")[0];
  if (deadline < today) {
    event.preventDefault();
    errorMsg.textContent = "⚠️ Deadline cannot be in the past.";
    return;
  }

  // Clear error
  errorMsg.textContent = "";

  // Add to list dynamically
  let li = document.createElement("li");
  li.textContent = `🎯 ${goalName} → Target: ${target}, Deadline: ${deadline}`;
  goalList.appendChild(li);

  // Reset form
  form.reset();

  // Stop actual submission (for demo only)
  event.preventDefault();
});
