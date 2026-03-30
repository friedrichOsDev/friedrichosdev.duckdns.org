<?php
if (isset($_GET['data'])) {
    header("Content-Type: application/json");

    function getCPU() {
        $stat1 = file('/proc/stat');
        $cpu1 = preg_split('/\s+/', trim($stat1[0]));
        $total1 = array_sum(array_slice($cpu1, 1));
        $idle1 = $cpu1[4];

        usleep(250000);

        $stat2 = file('/proc/stat');
        $cpu2 = preg_split('/\s+/', trim($stat2[0]));
        $total2 = array_sum(array_slice($cpu2, 1));
        $idle2 = $cpu2[4];

        $totalDiff = $total2 - $total1;
        $idleDiff = $idle2 - $idle1;

        if ($totalDiff == 0) return 0;
        return round((1 - ($idleDiff / $totalDiff)) * 100, 1);
    }

    $meminfo = file_get_contents("/proc/meminfo");
    preg_match('/MemTotal:\s+(\d+)/', $meminfo, $total);
    preg_match('/MemAvailable:\s+(\d+)/', $meminfo, $available);

    $totalMem = $total[1] ?? 1;
    $freeMem = $available[1] ?? 0;
    $ramPercent = round((($totalMem - $freeMem) / $totalMem) * 100, 1);

    $diskTotal = disk_total_space("/");
    $diskFree = disk_free_space("/");
    $diskPercent = round((($diskTotal - $diskFree) / $diskTotal) * 100, 1);

    $uptime = shell_exec("uptime -p");
    $kernel = php_uname('r');

    echo json_encode([
        "cpu" => getCPU(),
        "ram" => $ramPercent,
        "disk" => $diskPercent,
        "uptime" => trim($uptime),
        "kernel" => $kernel,
        "time" => date("H:i:s")
    ]);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FriedrichOsDev</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="header">
        <p>Monitor</p>
        <div>
            <a class="button-link" href="index.html">Home</a>
            <a class="button-link" href="projects.html">Projects</a>
            <a class="button-link header-link-active" href="monitor.php">Monitor</a>
            <a class="button-link header-link-last" href="contact.html">Contact</a>
        </div>
    </header>
    <main>
        <section class="monitor-section">
            <div class="monitor-grid">
                <div class="monitor-card">
                    <div class="terminal-header">
                        <span class="dot red"></span>
                        <span class="dot yellow"></span>
                        <span class="dot green"></span>
                        <span class="terminal-title">cpu_usage.sh</span>
                    </div>
                    <div class="card-content">
                        <div id="cpuText" class="monitor-value">0%</div>
                        <div class="progress-container">
                            <div id="cpuBar" class="progress-bar"></div>
                        </div>
                    </div>
                </div>
                <div class="monitor-card">
                    <div class="terminal-header">
                        <span class="dot red"></span>
                        <span class="dot yellow"></span>
                        <span class="dot green"></span>
                        <span class="terminal-title">mem_info.py</span>
                    </div>
                    <div class="card-content">
                        <div id="ramText" class="monitor-value">0%</div>
                        <div class="progress-container">
                            <div id="ramBar" class="progress-bar"></div>
                        </div>
                    </div>
                </div>
                <div class="monitor-card">
                    <div class="terminal-header">
                        <span class="dot red"></span>
                        <span class="dot yellow"></span>
                        <span class="dot green"></span>
                        <span class="terminal-title">disk_status.asm</span>
                    </div>
                    <div class="card-content">
                        <div id="diskText" class="monitor-value">0%</div>
                        <div class="progress-container">
                            <div id="diskBar" class="progress-bar"></div>
                        </div>
                    </div>
                </div>
                <div class="monitor-card sys-info-card">
                    <div class="terminal-header">
                        <span class="dot red"></span>
                        <span class="dot yellow"></span>
                        <span class="dot green"></span>
                        <span class="terminal-title">system_info.sh</span>
                    </div>
                    <div class="card-content system-info">
                        <p><span class="prompt">OS:</span> <span>Linux</span></p>
                        <p><span class="prompt">Kernel:</span> <span id="kernelName">...</span></p>
                        <p><span class="prompt">Uptime:</span> <span id="uptimeText">...</span></p>
                        <p><span class="prompt">Server Time:</span> <span id="timeText">...</span></p>
                        <p><span class="prompt">Status:</span> <span style="color: #50fa7b;">Online</span></p>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <footer class="footer">
        <p>&copy; 2026 FriedrichOsDev. All rights reserved.</p>
    </footer>
    <script>
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
    </script>
</body>
</html>