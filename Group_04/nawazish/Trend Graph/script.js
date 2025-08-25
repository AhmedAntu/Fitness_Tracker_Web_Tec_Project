
const form = document.getElementById("trendForm");
const errorMsg = document.getElementById("error");


const ctx = document.getElementById("trendChart").getContext("2d");
let chart = new Chart(ctx, {
  type: "line",
  data: {
    labels: [], 
    datasets: [
      {
        label: "Strength (kg)",
        data: [],
        borderColor: "blue",
        backgroundColor: "rgba(0,0,255,0.1)",
        fill: true
      },
      {
        label: "Cardio (minutes)",
        data: [],
        borderColor: "green",
        backgroundColor: "rgba(0,255,0,0.1)",
        fill: true
      }
    ]
  },
  options: {
    responsive: true,
    plugins: {
      legend: {
        position: "top"
      },
      title: {
        display: true,
        text: "Current vs. Past Performance"
      }
    },
    scales: {
      y: {
        beginAtZero: true
      }
    }
  }
});


form.addEventListener("submit", function(event) {
  event.preventDefault();

  let date = document.getElementById("date").value;
  let strength = document.getElementById("strength").value;
  let cardio = document.getElementById("cardio").value;

  
  if (date === "" || strength === "" || cardio === "") {
    errorMsg.textContent = "⚠️ Please fill in all fields.";
    return;
  }

  if (strength < 0 || cardio < 0) {
    errorMsg.textContent = "⚠️ Values cannot be negative.";
    return;
  }

  errorMsg.textContent = ""; 

  
  chart.data.labels.push(date);
  chart.data.datasets[0].data.push(strength);
  chart.data.datasets[1].data.push(cardio);
  chart.update();

 
  form.reset();
});
