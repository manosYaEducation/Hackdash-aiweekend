// Mobile Navigation Toggle
document.addEventListener("DOMContentLoaded", () => {
  const navToggle = document.getElementById("navToggle") // Cambiado de 'hamburger'
  const mobileNav = document.getElementById("mobileNav")
  const closeNav = document.getElementById("closeNav")

  // Open mobile navigation
  if (navToggle && mobileNav) {
    navToggle.addEventListener("click", () => {
      mobileNav.classList.add("active")
      navToggle.classList.add("active") // Cambiado de 'hamburger'
      document.body.style.overflow = "hidden" // Prevent scrolling
    })
  }

  // Close mobile navigation
  if (closeNav && mobileNav) {
    closeNav.addEventListener("click", () => {
      mobileNav.classList.remove("active")
      navToggle.classList.remove("active") // Cambiado de 'hamburger'
      document.body.style.overflow = "" // Restore scrolling
    })
  }

  // Close menu when clicking on a link
  const navLinks = document.querySelectorAll(".nav-link")
  navLinks.forEach((link) => {
    link.addEventListener("click", () => {
      mobileNav.classList.remove("active")
      navToggle.classList.remove("active") // Cambiado de 'hamburger'
      document.body.style.overflow = ""
    })
  })

  // Close menu when clicking outside
  mobileNav?.addEventListener("click", (e) => {
    if (e.target === mobileNav) {
      mobileNav.classList.remove("active")
      navToggle.classList.remove("active") // Cambiado de 'hamburger'
      document.body.style.overflow = ""
    }
  })

  // File input handling
  const fileInput = document.getElementById("attachment")
  const fileInputText = document.querySelector(".file-input-text")

  if (fileInput && fileInputText) {
    fileInput.addEventListener("change", function () {
      if (this.files && this.files.length > 0) {
        fileInputText.textContent = `Archivo seleccionado: ${this.files[0].name}`
      } else {
        fileInputText.textContent = "Examinar... Ningún archivo seleccionado."
      }
    })
  }

  // Form submission
  const capitalsForm = document.getElementById("capitalsForm")
  if (capitalsForm) {
    capitalsForm.addEventListener("submit", function (e) {
      e.preventDefault()

      // Get form data
      const formData = new FormData(this)
      const data = Object.fromEntries(formData)

      // Simple validation
      if (!data.projectName || !data.teamSize || !data.description) {
        alert("Por favor, completa todos los campos requeridos.")
        return
      }

      // Simulate form submission
      const submitButton = this.querySelector(".submit-button")
      const originalText = submitButton.textContent

      submitButton.textContent = "Enviando..."
      submitButton.disabled = true

      setTimeout(() => {
        alert("¡Formulario enviado exitosamente!")
        submitButton.textContent = originalText
        submitButton.disabled = false
        this.reset()
        if (fileInputText) {
          fileInputText.textContent = "Examinar... Ningún archivo seleccionado."
        }
      }, 2000)
    })
  }

  // CTA Button functionality
  const ctaButtons = document.querySelectorAll(".cta-button")
  ctaButtons.forEach((button) => {
    button.addEventListener("click", function (e) {
      e.preventDefault()

      const originalText = this.textContent
      this.textContent = "Cargando..."
      this.disabled = true

      setTimeout(() => {
        this.textContent = originalText
        this.disabled = false
        // Navigate to relevant section or page
        window.location.href = "projects.html"
      }, 1000)
    })
  })

  // Project button functionality
  const projectButtons = document.querySelectorAll(".project-button")
  projectButtons.forEach((button) => {
    button.addEventListener("click", function (e) {
      e.preventDefault()

      const originalText = this.textContent
      this.textContent = "Cargando..."
      this.disabled = true

      setTimeout(() => {
        this.textContent = originalText
        this.disabled = false
        // Here you would typically navigate to the project detail page
        alert("¡Proyecto seleccionado! Redirigiendo...")
      }, 1500)
    })
  })

  // Bottom Navigation Active State
  const currentPage = window.location.pathname.split("/").pop() || "index.html"
  const bottomNavItems = document.querySelectorAll(".bottom-nav-item")

  bottomNavItems.forEach((item) => {
    const href = item.getAttribute("href")
    if (href === currentPage || (currentPage === "" && href === "index.html")) {
      item.classList.add("active")
    } else {
      item.classList.remove("active")
    }
  })

  // Smooth scrolling for anchor links
  document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener("click", function (e) {
      e.preventDefault()
      const target = document.querySelector(this.getAttribute("href"))
      if (target) {
        target.scrollIntoView({
          behavior: "smooth",
          block: "start",
        })
      }
    })
  })

  // Add scroll effect to header
  let lastScrollTop = 0
  const header = document.querySelector(".header")

  window.addEventListener("scroll", () => {
    const scrollTop = window.pageYOffset || document.documentElement.scrollTop

    if (scrollTop > lastScrollTop && scrollTop > 100) {
      // Scrolling down
      header.style.transform = "translateY(-100%)"
    } else {
      // Scrolling up
      header.style.transform = "translateY(0)"
    }

    lastScrollTop = scrollTop
  })
})

// Utility function for responsive behavior
function handleResize() {
  const mobileNav = document.getElementById("mobileNav")
  const navToggle = document.getElementById("navToggle") // Cambiado de 'hamburger'

  if (window.innerWidth >= 768 && mobileNav) {
    mobileNav.classList.remove("active")
    if (navToggle) {
      navToggle.classList.remove("active") // Cambiado de 'hamburger'
    }
    document.body.style.overflow = ""
  }
}

window.addEventListener("resize", handleResize)

// Add intersection observer for animations
const observerOptions = {
  threshold: 0.1,
  rootMargin: "0px 0px -50px 0px",
}

const observer = new IntersectionObserver((entries) => {
  entries.forEach((entry) => {
    if (entry.isIntersecting) {
      entry.target.style.opacity = "1"
      entry.target.style.transform = "translateY(0)"
    }
  })
}, observerOptions)

// Observe elements for animation
document.addEventListener("DOMContentLoaded", () => {
  const animatedElements = document.querySelectorAll(".project-card, .form-group, .feature-card")
  animatedElements.forEach((el, index) => {
    el.style.opacity = "0"
    el.style.transform = "translateY(20px)"
    el.style.transition = `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`
    observer.observe(el)
  })
})

// Keyboard navigation support
document.addEventListener("keydown", (e) => {
  const mobileNav = document.getElementById("mobileNav")
  const navToggle = document.getElementById("navToggle") // Cambiado de 'hamburger'

  // Close mobile nav with Escape key
  if (e.key === "Escape" && mobileNav?.classList.contains("active")) {
    mobileNav.classList.remove("active")
    navToggle?.classList.remove("active") // Cambiado de 'hamburger'
    document.body.style.overflow = ""
  }
})


