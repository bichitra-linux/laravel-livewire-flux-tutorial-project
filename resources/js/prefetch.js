// lightweight intent prefetcher
const cache = new Set();
const queue = new Map();
const HEADER = "X-Purpose";

function isInternalLink(a) {
    if (!a || a.tagName !== "A") return false;
    if (a.target && a.target !== "_self") return false;
    if (a.hostname !== location.hostname) return false;
    const href = a.getAttribute("href") || "";
    if (
        !href ||
        href.startsWith("#") ||
        href.startsWith("mailto:") ||
        href.startsWith("tel:") ||
        href.startsWith("javascript:") ||
        href.startsWith("data:") ||
        href.startsWith("vbscript:")
    )
        return false;
    return true;
}
async function prefetch(url) {
    if (cache.has(url)) return;
    cache.add(url);
    try {
        await fetch(url, {
            method: "GET",
            credentials: "same-origin",
            headers: { [HEADER]: "prefetch" },
        });
    } catch (e) {
        console.debug("prefetch", url, "failed");
    }
}
function schedule(url, delay = 120) {
    if (cache.has(url) || queue.has(url)) return;
    const id = setTimeout(() => {
        prefetch(url);
        queue.delete(url);
    }, delay);
    queue.set(url, id);
}
document.addEventListener("mouseover", (e) => {
    const a = e.target.closest?.("a");
    if (isInternalLink(a)) schedule(a.href, 120);
});
document.addEventListener("touchstart", (e) => {
    const a = e.target.closest?.("a");
    if (isInternalLink(a)) schedule(a.href, 60);
});
window.addEventListener("load", () => {
    const meta = document.querySelector('meta[name="prefetch-routes"]');
    if (meta) {
        try {
            const list = JSON.parse(meta.content || "[]");
            for (const u of list.slice(0, 3))
                setTimeout(() => prefetch(u), Math.random() * 300 + 200);
        } catch (e) {}
    }
});
