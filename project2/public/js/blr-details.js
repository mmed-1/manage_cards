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
  const cards = document.querySelectorAll(".card")
  const submenuToggles = document.querySelectorAll(".submenu-toggle")
  const submenuItems = document.querySelectorAll(".submenu a")

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

  // Toggle Submenu
  const toggleSubmenu = (e) => {
    e.preventDefault()
    const parent = e.currentTarget.parentElement
    const menuId =
      parent.getAttribute("data-menu-id") || parent.querySelector(".submenu-toggle span").textContent.trim()
    const isActive = parent.classList.contains("active")

    // Close all other open submenus
    document.querySelectorAll(".has-submenu.active").forEach((item) => {
      if (item !== parent) {
        const itemMenuId =
          item.getAttribute("data-menu-id") || item.querySelector(".submenu-toggle span").textContent.trim()
        item.classList.remove("active")
        localStorage.removeItem(`submenu_${itemMenuId}`)
      }
    })

    // Toggle current submenu
    parent.classList.toggle("active", !isActive)

    // Save state to localStorage
    if (!isActive) {
      localStorage.setItem(`submenu_${menuId}`, "open")
    } else {
      localStorage.removeItem(`submenu_${menuId}`)
    }
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

  // Initialize table sorting and filtering
  const initTable = (tableId, searchId) => {
    const table = document.getElementById(tableId)
    if (!table) return

    const headers = table.querySelectorAll("th")
    const tbody = table.querySelector("tbody")
    const rows = Array.from(tbody.querySelectorAll("tr"))

    // Skip if table is empty or only has empty message
    if (rows.length === 0 || (rows.length === 1 && rows[0].querySelector(".empty-message"))) {
      return
    }

    // Initialize sorting
    headers.forEach((header) => {
      header.addEventListener("click", () => {
        const sortBy = header.getAttribute("data-sort")
        const isAsc = !header.classList.contains("sort-asc")

        // Reset all headers
        headers.forEach((h) => {
          h.classList.remove("sort-asc", "sort-desc")
        })

        // Set new sort direction
        header.classList.add(isAsc ? "sort-asc" : "sort-desc")

        // Sort the table
        sortTable(tableId, Array.from(headers).indexOf(header), isAsc)
      })
    })

    // Initialize search
    const searchInput = document.getElementById(searchId)
    if (searchInput) {
      searchInput.addEventListener("input", () => {
        filterTable(tableId, searchInput.value.toLowerCase())
      })
    }
  }

  // Sort table
  const sortTable = (tableId, columnIndex, asc) => {
    const table = document.getElementById(tableId)
    const tbody = table.querySelector("tbody")
    const rows = Array.from(tbody.querySelectorAll("tr"))

    // Skip if table is empty or only has empty message
    if (rows.length === 0 || (rows.length === 1 && rows[0].querySelector(".empty-message"))) {
      return
    }

    // Sort rows
    const sortedRows = rows.sort((a, b) => {
      const cellA = a.querySelectorAll("td")[columnIndex]?.textContent.trim() || ""
      const cellB = b.querySelectorAll("td")[columnIndex]?.textContent.trim()?.toLowerCase() || ""

      // Check if we're sorting dates
      if (columnIndex === 0) {
        // Assuming date format is consistent
        const dateA = new Date(cellA)
        const dateB = new Date(cellB)
        return asc ? dateA - dateB : dateB - dateA
      }

      // Check if we're sorting numbers (like montant)
      if (columnIndex === 1) {
        const numA = Number.parseFloat(cellA.replace(/[^\d.-]/g, ""))
        const numB = Number.parseFloat(cellB.replace(/[^\d.-]/g, ""))
        if (!isNaN(numA) && !isNaN(numB)) {
          return asc ? numA - numB : numB - numA
        }
      }

      // Default string comparison
      return asc
        ? cellA.localeCompare(cellB, undefined, { numeric: true, sensitivity: "base" })
        : cellB.localeCompare(cellA, undefined, { numeric: true, sensitivity: "base" })
    })

    // Remove existing rows
    rows.forEach((row) => tbody.removeChild(row))

    // Add sorted rows
    sortedRows.forEach((row) => tbody.appendChild(row))
  }

  // Filter table
  const filterTable = (tableId, query) => {
    const table = document.getElementById(tableId)
    const rows = table.querySelectorAll("tbody tr")

    // Skip if table is empty or only has empty message
    if (rows.length === 0 || (rows.length === 1 && rows[0].querySelector(".empty-message"))) {
      return
    }

    let allHidden = true

    rows.forEach((row) => {
      const text = row.textContent.toLowerCase()
      const display = text.includes(query) ? "" : "none"
      row.style.display = display

      if (display === "") {
        allHidden = false
      }
    })

    // Check if we already have a "no results" row
    let noResultsRow = table.querySelector(".no-results-row")

    if (allHidden) {
      if (!noResultsRow) {
        noResultsRow = document.createElement("tr")
        noResultsRow.className = "no-results-row"
        const td = document.createElement("td")
        td.colSpan = table.querySelectorAll("th").length
        td.className = "empty-message"
        td.innerHTML = '<i class="fas fa-search"></i> Aucun résultat trouvé'
        noResultsRow.appendChild(td)
        table.querySelector("tbody").appendChild(noResultsRow)
      }
    } else if (noResultsRow) {
      noResultsRow.remove()
    }
  }

  // Event Listeners for Submenu Toggles
  submenuToggles.forEach((toggle) => {
    toggle.addEventListener("click", toggleSubmenu)
  })

  // Event Listeners for Submenu Items
  submenuItems.forEach((item) => {
    item.addEventListener("click", (e) => {
      // Find parent submenu
      const submenu = item.closest(".submenu")
      if (submenu) {
        const parent = submenu.closest(".has-submenu")
        const menuId =
          parent.getAttribute("data-menu-id") || parent.querySelector(".submenu-toggle span").textContent.trim()
        // Save state to localStorage before navigation
        localStorage.setItem(`submenu_${menuId}`, "open")
      }
    })
  })

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

  // Initialize the dashboard
  const initDashboard = () => {
    // Set initial state for left sidebar based on screen size
    if (window.innerWidth > 992) {
      leftSidebar.classList.add("active")
    }

    // Initialize tables
    initTable("rechargesTable", "searchRecharges")

    // Animate cards
    cards.forEach((card, index) => {
      setTimeout(() => {
        card.style.opacity = "1"
        card.style.transform = "translateY(0)"
        card.style.transition = "opacity 0.4s ease, transform 0.4s ease"
      }, 150 * index)
    })

    // Restore submenu state from localStorage
    document.querySelectorAll(".has-submenu").forEach((submenuParent) => {
      const menuId =
        submenuParent.getAttribute("data-menu-id") ||
        submenuParent.querySelector(".submenu-toggle span").textContent.trim()
      if (localStorage.getItem(`submenu_${menuId}`) === "open") {
        submenuParent.classList.add("active")
      }

      // Also check if any submenu item is active
      const activeSubmenuItem = submenuParent.querySelector(".submenu li.active")
      if (activeSubmenuItem) {
        submenuParent.classList.add("active")
        localStorage.setItem(`submenu_${menuId}`, "open")
      }
    })
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
