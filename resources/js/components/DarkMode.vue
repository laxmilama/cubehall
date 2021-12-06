<script>
export default {
  mounted() {
    const toggleSwitch = document.querySelector('.theme-switch input[type="checkbox"]');
    const currentTheme = localStorage.getItem("theme");

    if (currentTheme) {
      document.documentElement.setAttribute("data-theme", currentTheme);

      if (currentTheme === "dark") {
        toggleSwitch.checked = true;
      }
    }

    function switchTheme(e) {
      if (e.target.checked) {
        document.documentElement.setAttribute("data-theme", "dark");
        localStorage.setItem("theme", "dark");
      } else {
        document.documentElement.setAttribute("data-theme", "light");
        localStorage.setItem("theme", "light");
      }
    }

    toggleSwitch.addEventListener("change", switchTheme, false);
  },
};
</script>
<style>
.no-ico {
  padding-left: 10px;
  color: var(--secondary-color);
}
.ico-drowdown {
  width: 20px;
  height: 20px;
  stroke-width: 1.5px;
  stroke: var(--gray-dark);
  margin-right: 10px;
}
.user-dropdown {
  position: absolute;
  height: auto;
  width: 200px;
  background: var(--bg-color);
  top: 50px;
  right: 0;
  padding: 10px;
  box-shadow: 0 0 8px var(--gray-light);
}
.user-drop-card {
  display: block;
  padding: 0;
  width: 100%;
}
.user-drop-card li {
  display: block;
}
.user-drop-card li a {
  display: flex;
  width: 100%;
  justify-content: flex-start;
}
.user-drop-card li a:hover {
  background-color: var(--gray-very-light);
  border-radius: 0;
}
.nav-drop-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  opacity: 0;
  background-color: var(--bg-color);
  z-index: -10;
  pointer-events: all;
}
.droplist {
  padding: 0 10px;
  color: var(--gray-very-dark);
}
</style>
