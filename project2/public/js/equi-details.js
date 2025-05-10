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
  
    // Delete confirmation elements
    const deleteModal = document.getElementById("deleteModal")
    const deleteMessage = document.getElementById("deleteMessage")
    const confirmDeleteBtn = document.getElementById("confirmDeleteBtn")
    const cancelDeleteBtn = document.getElementById("cancelDeleteBtn")
    const closeModalBtn = document.getElementById("closeModalBtn")
    const deleteTriggers = document.querySelectorAll(".delete-trigger")
  
    // Table elements
    const searchInput = document.getElementById("searchEquipment")
    const table = document.getElementById("equipmentTable")
    const tableHeaders = table ? table.querySelectorAll("th") : []
  
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
      const equipmentIp = form.dataset.equipmentIp
      deleteMessage.textContent = `Êtes-vous sûr de vouloir supprimer l'équipement ${equipmentIp}?`
  
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
  
    // Sort Table
    const sortTable = (headerIndex, ascending) => {
      const tbody = table.querySelector("tbody")
      const rows = Array.from(tbody.querySelectorAll("tr:not(.empty-row):not(.no-results-row)"))
  
      if (rows.length <= 1) return
  
      rows.sort((a, b) => {
        const aValue = a.cells[headerIndex].textContent.trim()
        const bValue = b.cells[headerIndex].textContent.trim()
  
        // Check if values are numbers
        const aNum = Number.parseFloat(aValue)
        const bNum = Number.parseFloat(bValue)
  
        if (!isNaN(aNum) && !isNaN(bNum)) {
          return ascending ? aNum - bNum : bNum - aNum
        }
  
        // Otherwise sort as strings
        return ascending
          ? aValue.localeCompare(bValue, undefined, { sensitivity: "base" })
          : bValue.localeCompare(aValue, undefined, { sensitivity: "base" })
      })
  
      // Remove all rows
      rows.forEach((row) => tbody.removeChild(row))
  
      // Add sorted rows
      rows.forEach((row) => tbody.appendChild(row))
    }
  
    // Filter Table
    const filterTable = () => {
      const query = searchInput.value.toLowerCase()
      const tbody = table.querySelector("tbody")
      const rows = Array.from(tbody.querySelectorAll("tr:not(.no-results-row)"))
      const emptyRow = tbody.querySelector(".empty-row")
  
      // Skip if table is empty
      if (rows.length === 0 || (rows.length === 1 && emptyRow)) return
  
      let allHidden = true
  
      rows.forEach((row) => {
        if (row.classList.contains("empty-row")) return
  
        const text = row.textContent.toLowerCase()
        const shouldShow = text.includes(query)
  
        row.style.display = shouldShow ? "" : "none"
  
        if (shouldShow) {
          allHidden = false
        }
      })
  
      // Check if we already have a "no results" row
      let noResultsRow = tbody.querySelector(".no-results-row")
  
      if (allHidden) {
        if (!noResultsRow) {
          noResultsRow = document.createElement("tr")
          noResultsRow.className = "no-results-row"
          const td = document.createElement("td")
          td.colSpan = table.querySelectorAll("th").length
          td.className = "empty-state"
          td.innerHTML = '<i class="fas fa-search"></i><p>Aucun résultat trouvé</p>'
          noResultsRow.appendChild(td)
          tbody.appendChild(noResultsRow)
        }
      } else if (noResultsRow) {
        noResultsRow.remove()
      }
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
    if (deleteTriggers) {
      deleteTriggers.forEach((trigger) => {
        trigger.addEventListener("click", (e) => {
          e.preventDefault()
          const form = trigger.closest(".delete-form")
          showDeleteModal(form)
        })
      })
    }
  
    if (confirmDeleteBtn) {
      confirmDeleteBtn.addEventListener("click", confirmDelete)
    }
  
    if (cancelDeleteBtn) {
      cancelDeleteBtn.addEventListener("click", hideDeleteModal)
    }
  
    if (closeModalBtn) {
      closeModalBtn.addEventListener("click", hideDeleteModal)
    }
  
    // Event Listeners for Table Sorting
    if (tableHeaders) {
      tableHeaders.forEach((header, index) => {
        if (header.querySelector("i.fa-sort")) {
          header.addEventListener("click", () => {
            const isAscending = !header.classList.contains("sort-asc")
  
            // Reset all headers
            tableHeaders.forEach((h) => {
              h.classList.remove("sort-asc", "sort-desc")
            })
  
            // Set current header sort state
            header.classList.add(isAscending ? "sort-asc" : "sort-desc")
  
            // Sort the table
            sortTable(index, isAscending)
          })
        }
      })
    }
  
    // Event Listener for Search
    if (searchInput) {
      searchInput.addEventListener("input", filterTable)
    }
  
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
    if (deleteModal) {
      deleteModal.querySelector(".modal-content").addEventListener("click", (e) => {
        e.stopPropagation()
      })
    }
  
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
  