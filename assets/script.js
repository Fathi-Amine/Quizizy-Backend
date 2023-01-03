const progressBar = document.getElementById("progress-bar");
const progressNext = document.getElementById("progress-next");
const progressPrev = document.getElementById("progress-prev");
const steps = document.querySelectorAll(".step");
const infoBlock = document.querySelector(".info-block");
const inputBlock = document.querySelector(".input-block");
const startBlock = document.querySelector(".start-block");
const startBtn = document.querySelector(".start");
let active = 1;
progressNext.addEventListener("click", () => {
    console.log("eeeee");
    active++;
    if (active > steps.length) {
        active = steps.length;
    }
    updateProgress();
});

  progressPrev.addEventListener("click", () => {
    active--;
    if (active < 1) {
      active = 1;
    }
    updateProgress();
  });

  const updateProgress = () => {
    // toggle active class on list items
    steps.forEach((step, i) => {
      if (i < active) {
        step.classList.add("active");
      } 
      else {
        step.classList.remove("active");
      }
    });
    // set progress bar width  
    progressBar.style.width = 
      ((active - 1) / (steps.length - 1)) * 100 + "%";
    // enable disable prev and next buttons
    if (active === 1) {
      progressNext.disabled = false;
      progressPrev.disabled = true;
      infoBlock.style.display="none";
      inputBlock.style.display = "block";
    }else if(active === steps.length - 1) {
      progressPrev.disabled = false;
      startBlock.style.display = "none";
      infoBlock.style.display="block";
      inputBlock.style.display = "none";

    }
    else if (active === steps.length) {
      progressNext.disabled = true;
      startBlock.style.display = "block";
      infoBlock.style.display="none";
      inputBlock.style.display = "none";
    } else {
      progressPrev.disabled = false;
      progressNext.disabled = false;
      startBlock.style.display = "none";
    }
  };
