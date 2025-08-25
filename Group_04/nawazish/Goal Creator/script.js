
const form = document.getElementById("goalForm");
const errorMsg = document.getElementById("error");
const goalList = document.getElementById("goalList");


form.addEventListener("submit", function(event) {
  event.preventDefault();

  let goalName = document.getElementById("goalName").value.trim();
  let target = document.getElementById("target").value;
  let deadline = document.getElementById("deadline").value;

  
  if (goalName === "" || target === "" || deadline === "") {
    errorMsg.textContent = "⚠️ Please fill in all fields.";
    return;
  }

  if (target <= 0) {
    errorMsg.textContent = "⚠️ Target must be greater than 0.";
    return;
  }

  let today = new Date().toISOString().split("T")[0];
  if (deadline < today) {
    errorMsg.textContent = "⚠️ Deadline cannot be in the past.";
    return;
  }

  errorMsg.textContent = ""; 

  
  let li = document.createElement("li");
  li.textContent = `🎯 ${goalName} → Target: ${target}, Deadline: ${deadline}`;
  goalList.appendChild(li);

  
  form.reset();
});
