const form = document.getElementById("achievementForm");
const errorMsg = document.getElementById("error");
const gallery = document.getElementById("gallery");

form.addEventListener("submit", function(event) {
  let title = document.getElementById("title").value.trim();
  let date = document.getElementById("date").value;

  // Validation
  if (title === "" || date === "") {
    event.preventDefault();
    errorMsg.textContent = "⚠️ Please fill in all fields.";
    return;
  }

  let today = new Date().toISOString().split("T")[0];
  if (date > today) {
    event.preventDefault();
    errorMsg.textContent = "⚠️ Date cannot be in the future.";
    return;
  }

  // Clear error
  errorMsg.textContent = "";

  // Create card
  let card = document.createElement("div");
  card.classList.add("card");

  let content = document.createElement("div");
  content.classList.add("card-content");
  content.textContent = `🏆 ${title} (${date})`;

  let shareBtn = document.createElement("button");
  shareBtn.classList.add("share-btn");
  shareBtn.textContent = "Share";

  shareBtn.addEventListener("click", function() {
    alert(`🎉 Shared your achievement: "${title}" on social media!`);
  });

  card.appendChild(content);
  card.appendChild(shareBtn);
  gallery.appendChild(card);

  // Reset form
  form.reset();

  // Prevent actual submission (for demo only)
  event.preventDefault();
});
