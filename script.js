        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();

                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Navbar scroll effect and active link highlighting
        const navbar = document.getElementById('navbar');
        const sections = document.querySelectorAll('section');
        const navLinks = document.querySelectorAll('.nav-links a');

        window.addEventListener('scroll', () => {
            // Navbar shadow on scroll
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }

            // Highlight active nav link
            let current = '';
            sections.forEach(section => {
                const sectionTop = section.offsetTop - navbar.offsetHeight; // Adjust for fixed navbar
                const sectionHeight = section.clientHeight;
                if (pageYOffset >= sectionTop && pageYOffset < sectionTop + sectionHeight) {
                    current = section.getAttribute('id');
                }
            });

            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href').includes(current)) {
                    link.classList.add('active');
                }
            });
        });

        // FAQ toggle functionality
        document.querySelectorAll('.faq-question').forEach(question => {
            question.addEventListener('click', function () {
                const answer = this.nextElementSibling;
                this.classList.toggle('active');
                if (answer.style.display === 'block') {
                    answer.style.display = 'none';
                } else {
                    answer.style.display = 'block';
                }
            });
        });

        // Form submission (basic example, replace with actual backend logic)
        document.querySelector('.application-form').addEventListener('submit', function (e) {
            e.preventDefault();
            alert('¡Postulación enviada con éxito! Nos pondremos en contacto contigo pronto.');
            this.reset(); // Clear the form
        });