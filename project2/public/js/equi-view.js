document.addEventListener("DOMContentLoaded", () => {
  // DOM Elements
  const leftSidebar = document.getElementById("leftSidebar")
  const userSidebar = document.getElementById("userSidebar")
  const overlay = document.getElementById("overlay")
  const mobileToggle = document.getElementById("mobileToggle")
  const closeSidebarBtn = document.getElementById("closeSidebarBtn")
  const userMenuToggle = document.getElementById("userMenuToggle")
  const closeUserSidebarBtn = document.getElementById("closeUserSidebarBtn")
  const deleteButtons = document.querySelectorAll(".delete-btn")
  const deleteModal = document.getElementById("deleteModal")
  const closeModalBtn = document.getElementById("closeModalBtn")
  const cancelDeleteBtn = document.getElementById("cancelDeleteBtn")
  const confirmDeleteBtn = document.getElementById("confirmDeleteBtn")
  const searchInput = document.getElementById("searchEquipment")
  const submenuToggles = document.querySelectorAll(".submenu-toggle")

  // Toggle left sidebar on mobile
  if (mobileToggle) {
    mobileToggle.addEventListener("click", () => {
      leftSidebar.classList.add("active")
      overlay.classList.add("active")
      document.body.classList.add("no-scroll")
    })
  }

  // Close left sidebar
  if (closeSidebarBtn) {
    closeSidebarBtn.addEventListener("click", () => {
      leftSidebar.classList.remove("active")
      overlay.classList.remove("active")
      document.body.classList.remove("no-scroll")
    })
  }

  // Toggle user sidebar
  if (userMenuToggle) {
    userMenuToggle.addEventListener("click", () => {
      userSidebar.classList.add("active")
      overlay.classList.add("active")
      document.body.classList.add("no-scroll")
    })
  }

  // Close user sidebar
  if (closeUserSidebarBtn) {
    closeUserSidebarBtn.addEventListener("click", () => {
      userSidebar.classList.remove("active")
      overlay.classList.remove("active")
      document.body.classList.remove("no-scroll")
    })
  }

  // Close sidebars when clicking on overlay
  if (overlay) {
    overlay.addEventListener("click", () => {
      leftSidebar.classList.remove("active")
      userSidebar.classList.remove("active")
      if (deleteModal) {
        deleteModal.classList.remove("active")
      }
      overlay.classList.remove("active")
      document.body.classList.remove("no-scroll")
    })
  }

  // Toggle submenu - improved click handling
  if (submenuToggles.length > 0) {
    submenuToggles.forEach((toggle) => {
      toggle.addEventListener("click", function (e) {
        e.preventDefault()
        e.stopPropagation()

        const parent = this.parentElement
        const isOpen = parent.classList.contains("open")

        // Close all other open submenus
        document.querySelectorAll(".has-submenu.open").forEach((item) => {
          if (item !== parent) {
            item.classList.remove("open")
          }
        })

        // Toggle current submenu
        if (isOpen) {
          parent.classList.remove("open")
        } else {
          parent.classList.add("open")
        }
      })
    })
  }

  // Delete confirmation modal
  if (deleteButtons.length > 0 && deleteModal) {
    deleteButtons.forEach((button) => {
      button.addEventListener("click", (e) => {
        e.preventDefault()

        // Get the form that contains the delete button
        const form = button.closest("form")

        // Show the modal
        deleteModal.classList.add("active")
        overlay.classList.add("active")
        document.body.classList.add("no-scroll")

        // Set up the confirm button to submit the form
        if (confirmDeleteBtn) {
          confirmDeleteBtn.onclick = () => {
            form.submit()
          }
        }
      })
    })
  }

  // Close modal
  if (closeModalBtn) {
    closeModalBtn.addEventListener("click", () => {
      deleteModal.classList.remove("active")
      overlay.classList.remove("active")
      document.body.classList.remove("no-scroll")
    })
  }

  // Cancel delete
  if (cancelDeleteBtn) {
    cancelDeleteBtn.addEventListener("click", () => {
      deleteModal.classList.remove("active")
      overlay.classList.remove("active")
      document.body.classList.remove("no-scroll")
    })
  }

  // Search functionality
  if (searchInput) {
    searchInput.addEventListener("keyup", function () {
      const searchTerm = this.value.toLowerCase()
      const tableRows = document.querySelectorAll("tbody tr")

      tableRows.forEach((row) => {
        const text = row.textContent.toLowerCase()
        if (text.includes(searchTerm)) {
          row.style.display = ""
        } else {
          row.style.display = "none"
        }
      })

      // Check if no results found
      const visibleRows = Array.from(tableRows).filter((row) => row.style.display !== "none")
      const emptyStateRow = document.querySelector(".empty-state-row")

      if (visibleRows.length === 0 && !emptyStateRow) {
        const tbody = document.querySelector("tbody")
        const columnsCount = document.querySelectorAll("thead th").length

        const newRow = document.createElement("tr")
        newRow.className = "empty-state-row"
        newRow.innerHTML = `
          <td colspan="${columnsCount}" class="text-center">
            <div class="empty-state">
              <i class="fas fa-search"></i>
              <p>Aucun résultat trouvé pour "${searchTerm}"</p>
            </div>
          </td>
        `

        tbody.appendChild(newRow)
      } else if (visibleRows.length > 0 && emptyStateRow) {
        emptyStateRow.remove()
      }
    })
  }

  // Auto-hide success messages after 5 seconds
  const successMessages = document.querySelectorAll(".status-message.success")
  if (successMessages.length > 0) {
    successMessages.forEach((message) => {
      setTimeout(() => {
        message.style.opacity = "0"
        setTimeout(() => {
          message.style.display = "none"
        }, 300)
      }, 5000)
    })
  }
})
