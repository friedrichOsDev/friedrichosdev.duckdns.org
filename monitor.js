async function updateStats() {
    try {
        const response = await fetch("monitor.php?data=1");
        const data = await response.json();

        updateDisplay("cpu", data.cpu);
        updateDisplay("ram", data.ram);
        updateDisplay("disk", data.disk);
        document.getElementById("kernelName").innerText = data.kernel;
        document.getElementById("uptimeText").innerText = data.uptime.replace('uptime ', '');
        document.getElementById("timeText").innerText = data.time;
        if (data.visitors === 1) {
            document.getElementById("visitorCount").innerText = data.visitors + " visitor";
        } else {
            document.getElementById("visitorCount").innerText = data.visitors + " visitors";
        }
    } catch (error) {
        console.error("Monitor Error:", error);
    }
}

function updateDisplay(id, value) {
    const textEl = document.getElementById(id + "Text");
    const barEl = document.getElementById(id + "Bar");
    
    if (textEl && barEl) {
        animateValue(textEl, value);
        barEl.style.width = value + "%";
        
        if (value > 85) barEl.style.background = "#ff5f56";
        else if (value > 60) barEl.style.background = "#ffbd2e";
        else barEl.style.background = "linear-gradient(90deg, #50fa7b, #8be9fd)";
    }
}

function animateValue(el, newValue) {
    el.innerText = newValue + "%";
}

setInterval(updateStats, 1000);
updateStats();