document.addEventListener("DOMContentLoaded", () => {
  // Sidebar toggle functionality
  const sidebarToggleBtn = document.getElementById("sidebarToggleBtn")
  const closeSidebarBtn = document.getElementById("closeSidebarBtn")
  const sidebar = document.getElementById("leftSidebar")

  if (sidebarToggleBtn) {
    sidebarToggleBtn.addEventListener("click", () => {
      sidebar.classList.add("expanded")
    })
  }

  if (closeSidebarBtn) {
    closeSidebarBtn.addEventListener("click", () => {
      sidebar.classList.remove("expanded")
    })
  }

  // Submenu toggle functionality
  const submenuToggles = document.querySelectorAll(".submenu-toggle")

  submenuToggles.forEach((toggle) => {
    toggle.addEventListener("click", function () {
      const parent = this.parentElement

      // Check if this item is already active
      const isActive = parent.classList.contains("active")

      // Close all other submenus
      document.querySelectorAll(".has-submenu").forEach((item) => {
        if (item !== parent) {
          item.classList.remove("active")
        }
      })

      // Toggle this submenu
      parent.classList.toggle("active", !isActive)
    })
  })

  // Auto-open submenu if a child is active
  const activeSubmenuItems = document.querySelectorAll(".submenu li.active")
  activeSubmenuItems.forEach((item) => {
    const parentLi = item.closest(".has-submenu")
    if (parentLi) {
      parentLi.classList.add("active")
    }
  })

  // Enhanced Delete confirmation
  const deleteButtons = document.querySelectorAll(".delete-btn")

  // Create modal elements
  const modalOverlay = document.createElement("div")
  modalOverlay.className = "modal-overlay"
  modalOverlay.style.display = "none"
  
  const modalContent = document.createElement("div")
  modalContent.className = "modal-content"
  
  const modalHeader = document.createElement("div")
  modalHeader.className = "modal-header"
  modalHeader.innerHTML = '<h3>Confirmation de suppression</h3>'
  
  const modalBody = document.createElement("div")
  modalBody.className = "modal-body"
  
  const modalFooter = document.createElement("div")
  modalFooter.className = "modal-footer"
  modalFooter.innerHTML = `
    <button class="modal-btn cancel-btn">Annuler</button>
    <button class="modal-btn confirm-btn">Supprimer</button>
  `
  
  modalContent.appendChild(modalHeader)
  modalContent.appendChild(modalBody)
  modalContent.appendChild(modalFooter)
  modalOverlay.appendChild(modalContent)
  document.body.appendChild(modalOverlay)
  
  // Add styles for the modal
  const modalStyle = document.createElement("style")
  modalStyle.textContent = `
    .modal-overlay {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: rgba(0, 0, 0, 0.5);
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 2000;
    }
    .modal-content {
      background-color: white;
      border-radius: 8px;
      width: 90%;
      max-width: 450px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
      animation: modalFadeIn 0.3s ease;
    }
    .modal-header {
      padding: 15px 20px;
      border-bottom: 1px solid #eee;
    }
    .modal-header h3 {
      margin: 0;
      font-size: 18px;
      color: #333;
    }
    .modal-body {
      padding: 20px;
      font-size: 16px;
    }
    .modal-footer {
      padding: 15px 20px;
      border-top: 1px solid #eee;
      display: flex;
      justify-content: flex-end;
      gap: 10px;
    }
    .modal-btn {
      padding: 8px 16px;
      border-radius: 4px;
      font-size: 14px;
      cursor: pointer;
      border: none;
    }
    .cancel-btn {
      background-color: #f5f5f5;
      color: #333;
    }
    .confirm-btn {
      background-color: #f44336;
      color: white;
    }
    .confirm-btn:hover {
      background-color: #e53935;
    }
    @keyframes modalFadeIn {
      from {
        opacity: 0;
        transform: translateY(-20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
  `
  document.head.appendChild(modalStyle)
  
  // Handle delete button clicks
  deleteButtons.forEach((button) => {
    button.addEventListener("click", function (e) {
      e.preventDefault()
      
      const form = this.closest("form")
      const numCarte = this.closest("tr").querySelector("td").textContent
      
      // Set modal content
      modalBody.innerHTML = `<p>Êtes-vous sûr de vouloir supprimer la carte <strong>${numCarte}</strong>?</p>
                            <p>Cette action est irréversible.</p>`
      
      // Show modal
      modalOverlay.style.display = "flex"
      
      // Handle cancel button
      const cancelBtn = modalOverlay.querySelector(".cancel-btn")
      cancelBtn.addEventListener("click", () => {
        modalOverlay.style.display = "none"
      })
      
      // Handle confirm button
      const confirmBtn = modalOverlay.querySelector(".confirm-btn")
      confirmBtn.addEventListener("click", () => {
        form.submit()
        modalOverlay.style.display = "none"
      })
    })
  })
  
  // Close modal when clicking outside
  modalOverlay.addEventListener("click", (e) => {
    if (e.target === modalOverlay) {
      modalOverlay.style.display = "none"
    }
  })

  // Auto-dismiss alerts after 5 seconds
  const alerts = document.querySelectorAll(".alert")

  if (alerts.length > 0) {
    setTimeout(() => {
      alerts.forEach((alert) => {
        alert.style.opacity = "0"
        alert.style.transform = "translateY(-10px)"
        alert.style.transition = "opacity 0.5s ease, transform 0.5s ease"
        setTimeout(() => {
          alert.style.display = "none"
        }, 500)
      })
    }, 5000)
  }

  // Check if we should collapse sidebar based on screen size
  function checkScreenSize() {
    if (window.innerWidth < 992) {
      sidebar.classList.remove("expanded")
    } else {
      sidebar.classList.add("expanded")
    }
  }

  // Initial check
  checkScreenSize()

  // Listen for window resize
  window.addEventListener("resize", checkScreenSize)

  // Add mobile toggle button if it doesn't exist
  if (!sidebarToggleBtn && window.innerWidth <= 991) {
    const headerLeft = document.querySelector(".header-left")
    if (headerLeft) {
      const toggleBtn = document.createElement("button")
      toggleBtn.id = "sidebarToggleBtn"
      toggleBtn.className = "sidebar-toggle-btn"
      toggleBtn.innerHTML = '<i class="fas fa-bars"></i>'

      headerLeft.prepend(toggleBtn)

      toggleBtn.addEventListener("click", () => {
        sidebar.classList.add("expanded")
      })
    }
  }

  // Add responsive table functionality
  const tables = document.querySelectorAll(".data-table")
  tables.forEach((table) => {
    if (table.scrollWidth > table.clientWidth) {
      table.parentElement.classList.add("table-scroll")
    }
  })
})