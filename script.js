document.addEventListener("DOMContentLoaded", function() {
    const github_lang_links = {
        "asm": "https://github.com/friedrichOsDev?tab=repositories&q=&language=assembly&type=source",
        "c": "https://github.com/friedrichOsDev?tab=repositories&q=&language=c&type=source",
        "python": "https://github.com/friedrichOsDev?tab=repositories&q=&language=python&type=source",
        "css": "https://github.com/friedrichOsDev?tab=repositories&q=&language=css&type=source",
        "html": "https://github.com/friedrichOsDev?tab=repositories&q=&language=html&type=source",
        "js": "https://github.com/friedrichOsDev?tab=repositories&q=&language=javascript&type=source"
    };

    document.addEventListener("click", function(e) {
        for (const [lang, link] of Object.entries(github_lang_links)) {
            if (e.target && e.target.classList.contains(`language-${lang}`)) {
                window.open(link, '_blank');
            }
        }
    });

    const lines = [
        { command: "whoami", response: "Ich bin Friedrich, ein 15 Jahre alter Schüler, der Spaß am Programmieren und der Betriebssystementwicklung hat.", isTags: false },
        { command: "ls skills/", response: "<a class=\"language-asm\">asm</a> <a class=\"language-c\">c</a> <a class=\"language-python\">python</a> <span class='ls-folder'>web-development/</span>", isTags: true },
        { command: "ls skills/web-development/", response: "<a class=\"language-css\">css</a> <a class=\"language-html\">html</a> <a class=\"language-js\">js</a>", isTags: true },
        { command: "cat goals.txt", response: "Aktuell arbeite ich an NanoOS, einem Hobby-Betriebssystem, das von Grund auf in C und Assembly geschrieben wird. Außerdem natürlich an dieser Website, um meine Projekte und Fortschritte zu dokumentieren.", isTags: false }
    ];

    const commandElements = document.querySelectorAll('.terminal-body .command');
    const responseElements = document.querySelectorAll('.terminal-body .response, .terminal-body .response-tags');
    const finalPrompt = document.querySelector('.cursor').parentElement;

    const typingSpeed = 100;
    const responseDelay = 300;

    for (let i = 0; i < commandElements.length; i++) {
        commandElements[i].parentElement.style.display = 'none';
        responseElements[i].style.display = 'none';
    }
    finalPrompt.style.display = 'none';

    async function typeText(element, text) {
        element.parentElement.style.display = 'block';
        for (let i = 0; i < text.length; i++) {
            element.textContent += text[i];
            await new Promise(resolve => setTimeout(resolve, typingSpeed));
        }
    }

    async function showResponse(element, responseText, isTags) {
        await new Promise(resolve => setTimeout(resolve, responseDelay));
        element.style.display = 'block';

        if (isTags) {
            element.innerHTML = responseText;
        } else {
            for (let i = 0; i < responseText.length; i++) {
                element.textContent += responseText[i];
                await new Promise(resolve => setTimeout(resolve, typingSpeed / 4));
            }
        }
    }

    async function runTerminalAnimation() {
        for (let i = 0; i < lines.length; i++) {
            const line = lines[i];
            const cmdElement = commandElements[i];
            const resElement = responseElements[i];

            await typeText(cmdElement, line.command);
            await showResponse(resElement, line.response, line.isTags);
        }
        finalPrompt.style.display = 'block';
    }

    runTerminalAnimation();
});
