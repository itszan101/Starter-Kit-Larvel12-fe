const THEME_KEY = "theme";

function toggleDarkTheme() {
    setTheme(
        document.documentElement.getAttribute("data-bs-theme") === "dark"
            ? "light"
            : "dark",
        true
    );
}

function setTheme(theme, persist = false) {
    document.body.classList.add(theme);
    document.documentElement.setAttribute("data-bs-theme", theme);

    // Ubah tombol sesuai mode
    const btn = document.getElementById("toggle-dark");
    const icon = document.getElementById("dark-icon");
    if (btn && icon) {
        if (theme === "dark") {
            // Dark mode aktif → tampilkan icon Sun (switch ke light)
            btn.classList.remove("btn-dark");
            btn.classList.add("btn-light");
            icon.classList.remove("bi-moon", "text-white");
            icon.classList.add("bi-sun", "text-dark");
        } else {
            // Light mode aktif → tampilkan icon Moon (switch ke dark)
            btn.classList.remove("btn-light");
            btn.classList.add("btn-dark");
            icon.classList.remove("bi-sun", "text-dark");
            icon.classList.add("bi-moon", "text-white");
        }
    }

    if (persist) {
        localStorage.setItem(THEME_KEY, theme);
    }
}

function initTheme() {
    const storedTheme = localStorage.getItem(THEME_KEY);
    if (storedTheme) {
        return setTheme(storedTheme);
    }
    if (!window.matchMedia) return;

    const mediaQuery = window.matchMedia("(prefers-color-scheme: dark)");
    mediaQuery.addEventListener("change", (e) =>
        setTheme(e.matches ? "dark" : "light", true)
    );

    return setTheme(mediaQuery.matches ? "dark" : "light", true);
}

window.addEventListener("DOMContentLoaded", () => {
    const toggler = document.getElementById("toggle-dark");
    if (toggler) {
        toggler.addEventListener("click", toggleDarkTheme);
    }
});

initTheme();
