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
  const statusMessages = document.querySelectorAll(".status-message")

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

  // Auto-hide success messages after 5 seconds
  if (statusMessages.length > 0) {
    statusMessages.forEach((message) => {
      if (message.classList.contains("success")) {
        setTimeout(() => {
          message.style.opacity = "0"
          setTimeout(() => {
            message.style.display = "none"
          }, 300)
        }, 5000)
      }
    })
  }

  // Initialize the form
  const form = document.querySelector(".form")
  if (form) {
    form.addEventListener("submit", (e) => {
      // Form validation can be added here if needed
    })
  }
})
