const siteStats = {
    /**
     * Shows or hides the Site Stats section
     * @param {Element} el 
     * @param {Element} toggleElement 
     * 
     * @returns
     */
    toggleStats: (el, toggleElement) => {
        if (siteStats.isVisible(el)) {
            siteStats.hideStats(el);
            toggleElement.innerHTML = "Show Site Stats Info";
            return;
        }
        toggleElement.innerHTML = "Hide Site Stats Info";
        siteStats.showStats(el);
    },
    /**
     * Sets el to display='block'
     * @param {Element} el 
     */
    showStats: (el) => {
        el.style.display = "block";
    },
    /**
     * Sets el to display='none'
     * @param {Element} el 
     */
    hideStats: (el) => {
        el.style.display = "none";
    },
    /**
     * Returns true if el is display = 'block'
     * @param {Element} el 
     * @returns {bool}
     */
    isVisible: (el) => {
        return (window.getComputedStyle(el).display === "block");
    }
};

document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("site-stats-toggle").addEventListener("click", function(event) {
        event.preventDefault();
        siteStats.toggleStats(document.getElementById("site-stats-demo"), this);
    });
});
