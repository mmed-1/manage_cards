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
  const submenuToggles = document.querySelectorAll(".submenu-toggle")

  // Delete confirmation elements
  const deleteModal = document.getElementById("deleteModal")
  const deleteMessage = document.getElementById("deleteMessage")
  const confirmDeleteBtn = document.getElementById("confirmDeleteBtn")
  const cancelDeleteBtn = document.getElementById("cancelDeleteBtn")
  const closeModalBtn = document.getElementById("closeModalBtn")
  const deleteTriggers = document.querySelectorAll(".delete-trigger")

  // State
  let isLeftSidebarOpen = window.innerWidth > 992
  let isUserSidebarOpen = false
  let currentDeleteForm = null

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

  // Toggle Submenu
  const toggleSubmenu = (e) => {
    e.preventDefault()
    const parent = e.currentTarget.parentElement
    const isActive = parent.classList.contains("active")

    // Close all other open submenus
    document.querySelectorAll(".has-submenu.active").forEach((item) => {
      if (item !== parent) {
        item.classList.remove("active")
      }
    })

    // Toggle current submenu
    parent.classList.toggle("active", !isActive)
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

  // Show Delete Modal
  const showDeleteModal = (form) => {
    currentDeleteForm = form
    const accountName = form.dataset.accountName
    deleteMessage.textContent = `Êtes-vous sûr de vouloir supprimer le compte de ${accountName}?`

    deleteModal.classList.add("active")
    overlay.classList.add("active")
    body.classList.add("no-scroll")

    // Add animation class to modal content
    setTimeout(() => {
      deleteModal.querySelector(".modal-content").classList.add("active")
    }, 10)
  }

  // Hide Delete Modal
  const hideDeleteModal = () => {
    deleteModal.querySelector(".modal-content").classList.remove("active")

    setTimeout(() => {
      deleteModal.classList.remove("active")
      if (!isLeftSidebarOpen && !isUserSidebarOpen) {
        overlay.classList.remove("active")
        body.classList.remove("no-scroll")
      }
    }, 300)
  }

  // Confirm Delete
  const confirmDelete = () => {
    if (currentDeleteForm) {
      currentDeleteForm.submit()
    }
    hideDeleteModal()
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

  // Event Listeners for Delete Confirmation
  deleteTriggers.forEach((trigger) => {
    trigger.addEventListener("click", (e) => {
      e.preventDefault()
      const form = trigger.closest(".delete-form")
      showDeleteModal(form)
    })
  })

  // Event Listeners for Submenu Toggles
  submenuToggles.forEach((toggle) => {
    toggle.addEventListener("click", toggleSubmenu)
  })

  confirmDeleteBtn.addEventListener("click", confirmDelete)

  cancelDeleteBtn.addEventListener("click", hideDeleteModal)
  closeModalBtn.addEventListener("click", hideDeleteModal)

  // Event Listeners for Sidebar
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

  overlay.addEventListener("click", () => {
    hideDeleteModal()
    closeAllSidebars()
  })

  // Prevent clicks inside sidebars from closing them
  leftSidebar.addEventListener("click", (e) => {
    e.stopPropagation()
  })

  userSidebar.addEventListener("click", (e) => {
    e.stopPropagation()
  })

  // Prevent clicks inside modal from closing it
  deleteModal.querySelector(".modal-content").addEventListener("click", (e) => {
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
      if (overlay.classList.contains("active") && !isUserSidebarOpen && !deleteModal.classList.contains("active")) {
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

  // Animation handlers
  const animateElements = (elements, baseDelay = 0) => {
    elements.forEach((el, index) => {
      el.style.animationDelay = `${baseDelay + index * 0.1}s`
      el.classList.add("animate-in")
    })
  }

  // Initialize the dashboard
  const initDashboard = () => {
    // Set initial state for left sidebar based on screen size
    if (window.innerWidth > 992) {
      leftSidebar.classList.add("active")
    }

    // Initialize animations
    animateElements(document.querySelectorAll(".status-message"))
  }

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
  initDashboard()
})
