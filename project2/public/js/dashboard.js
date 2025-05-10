document.addEventListener("DOMContentLoaded", () => {
  // DOM Elements
  const leftSidebar = document.getElementById("leftSidebar")
  const userSidebar = document.getElementById("userSidebar")
  const mobileToggle = document.getElementById("mobileToggle")
  const userMenuToggle = document.getElementById("userMenuToggle")
  const closeSidebarBtn = document.getElementById("closeSidebarBtn")
  const closeUserSidebarBtn = document.getElementById("closeUserSidebarBtn")
  const overlay = document.getElementById("overlay")
  const body = document.body
  const submenuToggles = document.querySelectorAll(".submenu-toggle")

  // Toggle left sidebar on mobile
  if (mobileToggle) {
    mobileToggle.addEventListener("click", () => {
      leftSidebar.classList.add("active")
      overlay.classList.add("active")
      body.classList.add("no-scroll")
    })
  }

  // Close left sidebar
  if (closeSidebarBtn) {
    closeSidebarBtn.addEventListener("click", () => {
      leftSidebar.classList.remove("active")
      overlay.classList.remove("active")
      body.classList.remove("no-scroll")
    })
  }

  // Toggle user sidebar
  if (userMenuToggle) {
    userMenuToggle.addEventListener("click", () => {
      userSidebar.classList.add("active")
      overlay.classList.add("active")
      body.classList.add("no-scroll")
    })
  }

  // Close user sidebar
  if (closeUserSidebarBtn) {
    closeUserSidebarBtn.addEventListener("click", () => {
      userSidebar.classList.remove("active")
      overlay.classList.remove("active")
      body.classList.remove("no-scroll")
    })
  }

  // Close sidebars when clicking on overlay
  if (overlay) {
    overlay.addEventListener("click", () => {
      leftSidebar.classList.remove("active")
      userSidebar.classList.remove("active")
      overlay.classList.remove("active")
      body.classList.remove("no-scroll")
    })
  }

  // Toggle submenu
  submenuToggles.forEach((toggle) => {
    toggle.addEventListener("click", function (e) {
      e.preventDefault()

      // Close all other open submenus first
      const allSubmenus = document.querySelectorAll(".has-submenu")
      allSubmenus.forEach((item) => {
        if (item !== this.parentElement && item.classList.contains("open")) {
          item.classList.remove("open")
        }
      })

      // Toggle the clicked submenu
      const parent = this.parentElement
      parent.classList.toggle("open")
    })
  })

  // Initialize the dashboard
  const initDashboard = () => {
    // Set initial state for left sidebar based on screen size
    if (window.innerWidth > 992) {
      leftSidebar.classList.add("active")
    }
  }

  // Initialize the dashboard
  initDashboard()
})
