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
    const statusMessages = document.querySelectorAll(".status-message")
  
    // State
    let isLeftSidebarOpen = window.innerWidth > 992
    let isUserSidebarOpen = false
  
    // Toggle Left Sidebar
    const toggleLeftSidebar = () => {
      isLeftSidebarOpen = !isLeftSidebarOpen
      leftSidebar.classList.toggle("active", isLeftSidebarOpen)
      overlay.classList.toggle("active", isLeftSidebarOpen && window.innerWidth <= 992)
      body.classList.toggle("no-scroll", isLeftSidebarOpen && window.innerWidth <= 992)
    }
  
    // Toggle User Sidebar
    const toggleUserSidebar = () => {
      isUserSidebarOpen = !isUserSidebarOpen
      userSidebar.classList.toggle("active", isUserSidebarOpen)
      overlay.classList.toggle("active", isUserSidebarOpen)
      body.classList.toggle("no-scroll", isUserSidebarOpen)
    }
  
    // Close All Sidebars
    const closeAllSidebars = () => {
      // Only close the left sidebar on mobile
      if (window.innerWidth <= 992 && isLeftSidebarOpen) {
        isLeftSidebarOpen = false
        leftSidebar.classList.remove("active")
      }
  
      // Always close the user sidebar
      if (isUserSidebarOpen) {
        isUserSidebarOpen = false
        userSidebar.classList.remove("active")
      }
  
      // Hide overlay and restore scrolling
      overlay.classList.remove("active")
      body.classList.remove("no-scroll")
    }
  
    // Auto-hide status messages after delay
    if (statusMessages.length > 0) {
      setTimeout(() => {
        statusMessages.forEach((message) => {
          message.style.opacity = "0"
          message.style.transform = "translateY(-10px)"
          message.style.transition = "all 0.5s ease"
  
          setTimeout(() => {
            message.style.display = "none"
          }, 500)
        })
      }, 5000)
    }
  
    // Event Listeners
    mobileToggle.addEventListener("click", (e) => {
      e.stopPropagation()
      // Close user sidebar if open
      if (isUserSidebarOpen) {
        toggleUserSidebar()
      }
      toggleLeftSidebar()
    })
  
    userMenuToggle.addEventListener("click", (e) => {
      e.stopPropagation()
      // Close left sidebar on mobile if open
      if (window.innerWidth <= 992 && isLeftSidebarOpen) {
        toggleLeftSidebar()
      }
      toggleUserSidebar()
    })
  
    closeSidebarBtn.addEventListener("click", () => {
      toggleLeftSidebar()
    })
  
    closeUserSidebarBtn.addEventListener("click", () => {
      toggleUserSidebar()
    })
  
    overlay.addEventListener("click", closeAllSidebars)
  
    // Prevent clicks inside sidebars from closing them
    leftSidebar.addEventListener("click", (e) => {
      e.stopPropagation()
    })
  
    userSidebar.addEventListener("click", (e) => {
      e.stopPropagation()
    })
  
    // Handle window resize
    window.addEventListener("resize", () => {
      if (window.innerWidth > 992) {
        // On desktop
        if (!isLeftSidebarOpen) {
          isLeftSidebarOpen = true
          leftSidebar.classList.add("active")
        }
        // Remove overlay if it was active due to mobile sidebar
        if (overlay.classList.contains("active") && !isUserSidebarOpen) {
          overlay.classList.remove("active")
          body.classList.remove("no-scroll")
        }
      } else {
        // On mobile
        if (isLeftSidebarOpen) {
          overlay.classList.add("active")
        }
      }
    })
  
    // Logout handler
    const logoutBtn = document.querySelector(".logout-btn")
    if (logoutBtn) {
      logoutBtn.addEventListener("click", (e) => {
        e.preventDefault()
        // Add your logout logic here
        console.log("Logout initiated")
        window.location.href = "/logout"
      })
    }
  
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
  