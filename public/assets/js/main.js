/**
 * JavaScript Principal - MackAI OP-3
 */

// Configurações globais
const MackAI = {
    config: {
        animationDuration: 300,
        scrollOffset: 80,
        breakpoints: {
            mobile: 768,
            tablet: 1024
        }
    },
    
    // Inicialização
    init() {
        this.setupMobileMenu();
        this.setupSmoothScroll();
        this.setupLazyLoading();
        this.setupFormValidation();
        this.setupAccessibility();
        this.setupAnimations();
        
        console.log('MackAI OP-3 inicializado');
    },
    
    // Menu mobile
    setupMobileMenu() {
        const toggle = document.querySelector('.mobile-menu-toggle');
        const navLinks = document.querySelector('.nav-links');
        
        if (!toggle || !navLinks) return;
        
        toggle.addEventListener('click', () => {
            const isOpen = navLinks.classList.contains('active');
            
            if (isOpen) {
                navLinks.classList.remove('active');
                toggle.setAttribute('aria-expanded', 'false');
            } else {
                navLinks.classList.add('active');
                toggle.setAttribute('aria-expanded', 'true');
            }
        });
        
        // Fechar menu ao clicar em link
        navLinks.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                navLinks.classList.remove('active');
                toggle.setAttribute('aria-expanded', 'false');
            });
        });
        
        // Fechar menu ao redimensionar
        window.addEventListener('resize', () => {
            if (window.innerWidth > this.config.breakpoints.mobile) {
                navLinks.classList.remove('active');
                toggle.setAttribute('aria-expanded', 'false');
            }
        });
    },
    
    // Scroll suave
    setupSmoothScroll() {
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', (e) => {
                e.preventDefault();
                const target = document.querySelector(anchor.getAttribute('href'));
                
                if (target) {
                    const offsetTop = target.offsetTop - this.config.scrollOffset;
                    window.scrollTo({
                        top: offsetTop,
                        behavior: 'smooth'
                    });
                }
            });
        });
    },
    
    // Lazy loading para imagens
    setupLazyLoading() {
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        observer.unobserve(img);
                    }
                });
            });
            
            document.querySelectorAll('img[data-src]').forEach(img => {
                imageObserver.observe(img);
            });
        }
    },
    
    // Validação de formulários
    setupFormValidation() {
        const forms = document.querySelectorAll('form[data-validate]');
        
        forms.forEach(form => {
            form.addEventListener('submit', (e) => {
                if (!this.validateForm(form)) {
                    e.preventDefault();
                }
            });
            
            // Validação em tempo real
            form.querySelectorAll('input, textarea').forEach(field => {
                field.addEventListener('blur', () => {
                    this.validateField(field);
                });
            });
        });
    },
    
    // Validar formulário
    validateForm(form) {
        let isValid = true;
        const fields = form.querySelectorAll('input[required], textarea[required]');
        
        fields.forEach(field => {
            if (!this.validateField(field)) {
                isValid = false;
            }
        });
        
        return isValid;
    },
    
    // Validar campo individual
    validateField(field) {
        const value = field.value.trim();
        const type = field.type;
        let isValid = true;
        let message = '';
        
        // Campo obrigatório
        if (field.hasAttribute('required') && !value) {
            isValid = false;
            message = 'Este campo é obrigatório';
        }
        
        // Email
        if (type === 'email' && value) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(value)) {
                isValid = false;
                message = 'Digite um email válido';
            }
        }
        
        // Comprimento mínimo
        const minLength = field.getAttribute('minlength');
        if (minLength && value.length < parseInt(minLength)) {
            isValid = false;
            message = `Mínimo de ${minLength} caracteres`;
        }
        
        this.showFieldValidation(field, isValid, message);
        return isValid;
    },
    
    // Mostrar validação do campo
    showFieldValidation(field, isValid, message) {
        const errorElement = field.parentNode.querySelector('.field-error');
        
        if (isValid) {
            field.classList.remove('error');
            if (errorElement) {
                errorElement.remove();
            }
        } else {
            field.classList.add('error');
            
            if (!errorElement) {
                const error = document.createElement('div');
                error.className = 'field-error';
                error.textContent = message;
                field.parentNode.appendChild(error);
            } else {
                errorElement.textContent = message;
            }
        }
    },
    
    // Melhorias de acessibilidade
    setupAccessibility() {
        // Skip link
        const skipLink = document.createElement('a');
        skipLink.href = '#main';
        skipLink.textContent = 'Pular para o conteúdo principal';
        skipLink.className = 'skip-link';
        document.body.insertBefore(skipLink, document.body.firstChild);
        
        // Indicador de foco
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Tab') {
                document.body.classList.add('keyboard-navigation');
            }
        });
        
        document.addEventListener('mousedown', () => {
            document.body.classList.remove('keyboard-navigation');
        });
        
        // ARIA labels dinâmicos
        this.updateAriaLabels();
    },
    
    // Atualizar ARIA labels
    updateAriaLabels() {
        // Botões sem texto
        document.querySelectorAll('button:not([aria-label])').forEach(btn => {
            const icon = btn.querySelector('svg, i');
            if (icon && !btn.textContent.trim()) {
                btn.setAttribute('aria-label', 'Botão');
            }
        });
        
        // Links externos
        document.querySelectorAll('a[href^="http"]:not([target="_blank"])').forEach(link => {
            if (!link.hostname.includes(location.hostname)) {
                link.setAttribute('target', '_blank');
                link.setAttribute('rel', 'noopener noreferrer');
                link.setAttribute('aria-label', link.textContent + ' (abre em nova aba)');
            }
        });
    },
    
    // Animações
    setupAnimations() {
        if ('IntersectionObserver' in window) {
            const animationObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-in');
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            });
            
            document.querySelectorAll('.animate-on-scroll').forEach(el => {
                animationObserver.observe(el);
            });
        }
    },
    
    // Utilitários
    utils: {
        // Debounce
        debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        },
        
        // Throttle
        throttle(func, limit) {
            let inThrottle;
            return function() {
                const args = arguments;
                const context = this;
                if (!inThrottle) {
                    func.apply(context, args);
                    inThrottle = true;
                    setTimeout(() => inThrottle = false, limit);
                }
            };
        },
        
        // Formatação de data
        formatDate(date, format = 'dd/mm/yyyy') {
            const d = new Date(date);
            const day = String(d.getDate()).padStart(2, '0');
            const month = String(d.getMonth() + 1).padStart(2, '0');
            const year = d.getFullYear();
            
            return format
                .replace('dd', day)
                .replace('mm', month)
                .replace('yyyy', year);
        },
        
        // Scroll to top
        scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }
    }
};

// CSS para animações e estados
const styles = `
    .skip-link {
        position: absolute;
        top: -40px;
        left: 6px;
        background: var(--primary-red);
        color: white;
        padding: 8px;
        text-decoration: none;
        border-radius: 4px;
        z-index: 9999;
        transition: top 0.3s;
    }
    
    .skip-link:focus {
        top: 6px;
    }
    
    .keyboard-navigation *:focus {
        outline: 2px solid var(--primary-red) !important;
        outline-offset: 2px;
    }
    
    .field-error {
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
    
    .error {
        border-color: #dc3545 !important;
    }
    
    .lazy {
        opacity: 0;
        transition: opacity 0.3s;
    }
    
    .animate-on-scroll {
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.6s ease;
    }
    
    .animate-in {
        opacity: 1;
        transform: translateY(0);
    }
    
    @media (max-width: 768px) {
        .nav-links {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            flex-direction: column;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            padding: 1rem;
        }
        
        .nav-links.active {
            display: flex;
        }
        
        .mobile-menu-toggle {
            display: flex !important;
        }
    }
`;

// Adicionar estilos ao documento
const styleSheet = document.createElement('style');
styleSheet.textContent = styles;
document.head.appendChild(styleSheet);

// Inicializar quando o DOM estiver pronto
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => MackAI.init());
} else {
    MackAI.init();
}

// Expor globalmente para uso em outras páginas
window.MackAI = MackAI;
