let paso=1;function mostrarSeccion(){let t=document.querySelector(".mostrar");t&&t.classList.remove("mostrar"),document.querySelector(`#paso-${paso}`).classList.add("mostrar");let e=document.querySelector(".actual");e&&e.classList.remove("actual"),document.querySelector(`[data-paso="${paso}"]`).classList.add("actual")}function iniciarApp(){mostrarSeccion(),document.querySelectorAll(".tabs button").forEach((t=>t.addEventListener("click",(function(t){paso=parseInt(t.target.dataset.paso),mostrarSeccion()}))))}document.addEventListener("DOMContentLoaded",(function(){iniciarApp()}));