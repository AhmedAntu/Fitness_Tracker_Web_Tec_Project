const form = document.getElementById("progressForm");
const errorMsg = document.getElementById("error");
const progressFill = document.getElementById("progressFill");

form.addEventListener("submit", function(event) {
  let goal = document.getElementById("goal").value;
  let current = document.getElementById("current").value;

  
  if (goal === "" || current === "") {
    event.preventDefault();
    errorMsg.textContent = "⚠️ Please fill in all fields.";
    return;
  }

  if (goal <= 0) {
    event.preventDefault();
    errorMsg.textContent = "⚠️ Goal must be greater than 0.";
    return;
  }

  if (current < 0) {
    event.preventDefault();
    errorMsg.textContent = "⚠️ Current progress cannot be negative.";
    return;
  }

  if (Number(current) > Number(goal)) {
    event.preventDefault();
    errorMsg.textContent = "⚠️ Progress cannot exceed the goal.";
    return;
  }

  
  errorMsg.textContent = "";

  
  let percent = Math.round((current / goal) * 100);

  
  progressFill.style.width = percent + "%";
  progressFill.textContent = percent + "%";

  
  event.preventDefault();
});
