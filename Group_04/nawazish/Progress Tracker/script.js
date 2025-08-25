
const form = document.getElementById("progressForm");
const errorMsg = document.getElementById("error");
const progressFill = document.getElementById("progressFill");


form.addEventListener("submit", function(event) {
  event.preventDefault();

  let goal = document.getElementById("goal").value;
  let current = document.getElementById("current").value;

  
  if (goal === "" || current === "") {
    errorMsg.textContent = "⚠️ Please fill in all fields.";
    return;
  }

  if (goal <= 0) {
    errorMsg.textContent = "⚠️ Goal must be greater than 0.";
    return;
  }

  if (current < 0) {
    errorMsg.textContent = "⚠️ Current progress cannot be negative.";
    return;
  }

  if (Number(current) > Number(goal)) {
    errorMsg.textContent = "⚠️ Progress cannot exceed the goal.";
    return;
  }

  errorMsg.textContent = ""; // clear error

  
  let percent = Math.round((current / goal) * 100);

  
  progressFill.style.width = percent + "%";
  progressFill.textContent = percent + "%";
});
