// Menú hamburguesa funcional para móvil
document.addEventListener('DOMContentLoaded', function() {
    const hamburger = document.getElementById('hamburger');
    const navLinks = document.getElementById('navLinks');
    if (hamburger && navLinks) {
        hamburger.addEventListener('click', function() {
            navLinks.classList.toggle('open');
            hamburger.classList.toggle('open');
        });
        // Cerrar menú al hacer clic en un enlace
        navLinks.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', function() {
                navLinks.classList.remove('open');
                hamburger.classList.remove('open');
            });
        });
    }
});
// Mejoras para móviles - navegación y comportamiento
document.addEventListener('DOMContentLoaded', function() {
    // Cerrar menú al hacer clic en un enlace (para móviles)
    const navLinks = document.querySelectorAll('.nav-links a');
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            if (window.innerWidth <= 768) {
                // Ocultar menú si está visible en móvil
                // Si implementas un menú hamburguesa, aquí iría el código
            }
        });
    });

    // Detectar scroll para manejar la navegación sticky
    let lastScrollTop = 0;
    const navbar = document.getElementById('navbar');
    
    window.addEventListener('scroll', function() {
        let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        
        // Si scrolleamos hacia abajo más de 100px, esconder la barra
        if (scrollTop > lastScrollTop && scrollTop > 100) {
            navbar.style.top = '-60px'; // Ocultar navbar
        } else {
            navbar.style.top = '0'; // Mostrar navbar
        }
        
        lastScrollTop = scrollTop;
    });

    // Inicialización para FAQ en móvil - mejor touch
    const faqQuestions = document.querySelectorAll('.faq-question');
    
    faqQuestions.forEach(question => {
        question.addEventListener('click', function() {
            // Cierra todas las demás respuestas
            faqQuestions.forEach(q => {
                if (q !== question && q.classList.contains('active')) {
                    q.classList.remove('active');
                    q.nextElementSibling.style.maxHeight = null;
                }
            });
            
            // Toggle la actual
            this.classList.toggle('active');
            const answer = this.nextElementSibling;
            
            if (this.classList.contains('active')) {
                answer.style.maxHeight = answer.scrollHeight + "px";
            } else {
                answer.style.maxHeight = null;
            }
        });
    });

    // Mejora para formulario en móviles - scroll al campo con error
    const form = document.querySelector('.application-form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const invalidField = form.querySelector(':invalid');
            if (invalidField) {
                invalidField.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        });
    }
});
