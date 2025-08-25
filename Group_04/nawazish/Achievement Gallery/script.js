
const form = document.getElementById("achievementForm");
const errorMsg = document.getElementById("error");
const gallery = document.getElementById("gallery");


form.addEventListener("submit", function(event) {
  event.preventDefault();

  let title = document.getElementById("title").value.trim();
  let date = document.getElementById("date").value;


  if (title === "" || date === "") {
    errorMsg.textContent = "⚠️ Please fill in all fields.";
    return;
  }

  let today = new Date().toISOString().split("T")[0];
  if (date > today) {
    errorMsg.textContent = "⚠️ Date cannot be in the future.";
    return;
  }

  errorMsg.textContent = ""; 


  let card = document.createElement("div");
  card.classList.add("card");

  let content = document.createElement("div");
  content.classList.add("card-content");
  content.textContent = `🏆 ${title} (${date})`;

  let shareBtn = document.createElement("button");
  shareBtn.classList.add("share-btn");
  shareBtn.textContent = "Share";
  shareBtn.addEventListener("click", function() {
    alert(`Shared your achievement: "${title}" on social media 🎉`);
  });

  card.appendChild(content);
  card.appendChild(shareBtn);
  gallery.appendChild(card);

  
  form.reset();
});
