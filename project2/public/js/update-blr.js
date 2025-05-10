document.addEventListener("DOMContentLoaded", () => {
  // Sidebar toggle functionality
  const sidebarToggleBtn = document.querySelector(".sidebar-toggle-btn")
  const closeSidebarBtn = document.querySelector(".close-sidebar-btn")
  const sidebar = document.querySelector(".sidebar")

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

      // Close all other open submenus
      document.querySelectorAll(".has-submenu.active").forEach((item) => {
        if (item !== parent) {
          item.classList.remove("active")
        }
      })

      // Toggle current submenu
      parent.classList.toggle("active")
    })
  })

  // Form validation
  const form = document.querySelector("form")

  if (form) {
    form.addEventListener("submit", (e) => {
      let valid = true
      const requiredInputs = form.querySelectorAll("[required]")

      requiredInputs.forEach((input) => {
        if (!input.value.trim()) {
          valid = false
          input.classList.add("error")
        } else {
          input.classList.remove("error")
        }
      })

      if (!valid) {
        e.preventDefault()
        showAlert("Please fill in all required fields", "danger")
      }
    })

    // Remove error class on input
    const inputs = form.querySelectorAll(".form-control")
    inputs.forEach((input) => {
      input.addEventListener("focus", function () {
        this.classList.remove("error")
        this.closest(".form-group")?.classList.add("focused")
      })

      input.addEventListener("blur", function () {
        this.closest(".form-group")?.classList.remove("focused")
      })
    })
  }

  // Auto-dismiss alerts after 5 seconds
  const alerts = document.querySelectorAll(".alert")
  if (alerts.length > 0) {
    setTimeout(() => {
      alerts.forEach((alert) => {
        alert.style.opacity = "0"
        alert.style.transform = "translateY(-10px)"
        setTimeout(() => {
          alert.remove()
        }, 300)
      })
    }, 5000)
  }

  // Helper function to show alerts
  function showAlert(message, type = "danger") {
    const alertContainer = document.createElement("div")
    alertContainer.className = `alert alert-${type}`
    alertContainer.innerHTML = `
            <i class="fas fa-${type === "danger" ? "exclamation-circle" : "check-circle"}"></i>
            <div>${message}</div>
        `

    document.querySelector(".content-container").appendChild(alertContainer)

    setTimeout(() => {
      alertContainer.style.opacity = "0"
      alertContainer.style.transform = "translateY(-10px)"
      setTimeout(() => {
        alertContainer.remove()
      }, 300)
    }, 5000)
  }
})
