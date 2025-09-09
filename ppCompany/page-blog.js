// filtry kategorii
document.addEventListener('DOMContentLoaded', function() {
    const categoryFilters = document.querySelectorAll('.category-filter');
    const blogCards = document.querySelectorAll('.blog-post-card');
    const postsCountNumber = document.getElementById('posts-count-number');
    
    // Funkcja filtrowania kategorii
    function filterByCategory(category) {
        let visibleCount = 0;
        
        blogCards.forEach(card => {
            const cardCategory = card.getAttribute('data-category');
            
            if (category === 'all' || cardCategory === category) {
                card.style.display = 'block';
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                
                // Animacja pojawiania się
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, visibleCount * 100);
                
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });
        
        // Aktualizacja licznika postów
        if (postsCountNumber) {
            postsCountNumber.textContent = visibleCount;
        }
        
        // Sprawdź czy są widoczne posty
        const noPostsFound = document.querySelector('.no-posts-found');
        if (visibleCount === 0 && !noPostsFound) {
            showNoPostsMessage();
        } else if (visibleCount > 0 && noPostsFound) {
            hideNoPostsMessage();
        }
    }
    
    // Event listeners dla filtrów kategorii
    categoryFilters.forEach(filter => {
        filter.addEventListener('click', function() {
            // Usuń aktywną klasę z wszystkich filtrów
            categoryFilters.forEach(f => f.classList.remove('active'));
            
            // Dodaj aktywną klasę do klikniętego filtra
            this.classList.add('active');
            
            // Filtruj posty
            const category = this.getAttribute('data-category');
            filterByCategory(category);
        });
    });

    // sortowanie postów
    const sortSelect = document.getElementById('blog-sort-select');
    const postsGrid = document.getElementById('blog-posts-grid');
    
    if (sortSelect && postsGrid) {
        sortSelect.addEventListener('change', function() {
            const sortValue = this.value;
            const cards = Array.from(postsGrid.querySelectorAll('.blog-post-card:not([style*="display: none"])'));
            
            cards.sort((a, b) => {
                switch (sortValue) {
                    case 'date-desc':
                        return new Date(b.querySelector('.post-date').getAttribute('datetime')) - new Date(a.querySelector('.post-date').getAttribute('datetime'));
                    case 'date-asc':
                        return new Date(a.querySelector('.post-date').getAttribute('datetime')) - new Date(b.querySelector('.post-date').getAttribute('datetime'));
                    case 'title-asc':
                        return a.querySelector('.blog-card-title').textContent.localeCompare(b.querySelector('.blog-card-title').textContent);
                    case 'title-desc':
                        return b.querySelector('.blog-card-title').textContent.localeCompare(a.querySelector('.blog-card-title').textContent);
                    case 'popular':
                        // Sortuj według liczby komentarzy (jeśli dostępne)
                        const aComments = parseInt(a.querySelector('.comments-count')?.textContent || '0');
                        const bComments = parseInt(b.querySelector('.comments-count')?.textContent || '0');
                        return bComments - aComments;
                    default:
                        return 0;
                }
            });
            
            // Przebuduj grid z animacją
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    postsGrid.appendChild(card);
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 50);
            });
        });
    }
    
//   wyszukiwarka
    
    const searchForm = document.querySelector('.search-form');
    const searchField = document.querySelector('.search-field');
    
    if (searchForm && searchField) {
        let searchTimeout;
        
        // Live search podczas pisania
        searchField.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const query = this.value.toLowerCase().trim();
            
            searchTimeout = setTimeout(() => {
                filterBySearch(query);
            }, 300);
        });
        
        // Funkcja wyszukiwania
        function filterBySearch(query) {
            let visibleCount = 0;
            
            blogCards.forEach(card => {
                const title = card.querySelector('.blog-card-title').textContent.toLowerCase();
                const excerpt = card.querySelector('.blog-card-excerpt').textContent.toLowerCase();
                const category = card.querySelector('.blog-card-category')?.textContent.toLowerCase() || '';
                
                const matches = title.includes(query) || excerpt.includes(query) || category.includes(query);
                
                if (query === '' || matches) {
                    card.style.display = 'block';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });
            
            // Aktualizacja licznika
            if (postsCountNumber) {
                postsCountNumber.textContent = visibleCount;
            }
            
            // Sprawdź czy są rezultaty
            if (visibleCount === 0 && query !== '') {
                showNoResultsMessage(query);
            } else {
                hideNoPostsMessage();
            }
        }
    }
    
    // ==========================================================================
    // LOAD MORE FUNCTIONALITY
    // ==========================================================================
    
    const loadMoreBtn = document.getElementById('load-more-posts');
    let currentPage = 1;
    let isLoading = false;
    
    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function() {
            if (isLoading) return;
            
            isLoading = true;
            this.textContent = 'Ładowanie...';
            this.disabled = true;
            
            // Symulacja ładowania (w rzeczywistości użyj AJAX)
            setTimeout(() => {
                // Tutaj byłby kod AJAX do ładowania więcej postów
                loadMorePosts();
                
                isLoading = false;
                this.textContent = 'Załaduj więcej artykułów';
                this.disabled = false;
            }, 1000);
        });
    }
    
    function loadMorePosts() {
        // Przykładowa implementacja - w rzeczywistości użyj WordPress AJAX
        currentPage++;
        
        // Fetch więcej postów przez AJAX
        fetch(`/wp-admin/admin-ajax.php`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `action=load_more_posts&page=${currentPage}&nonce=${blogAjax.nonce}`
        })
        .then(response => response.text())
        .then(data => {
            if (data.trim()) {
                const postsGrid = document.getElementById('blog-posts-grid');
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = data;
                
                // Dodaj nowe posty z animacją
                const newPosts = tempDiv.querySelectorAll('.blog-post-card');
                newPosts.forEach((post, index) => {
                    post.style.opacity = '0';
                    post.style.transform = 'translateY(30px)';
                    postsGrid.appendChild(post);
                    
                    setTimeout(() => {
                        post.style.opacity = '1';
                        post.style.transform = 'translateY(0)';
                    }, index * 100);
                });
            } else {
                // Brak więcej postów
                loadMoreBtn.style.display = 'none';
                showEndMessage();
            }
        })
        .catch(error => {
            console.error('Error loading more posts:', error);
            loadMoreBtn.textContent = 'Błąd ładowania';
        });
    }
    
    // ==========================================================================
    // NEWSLETTER FORM
    // ==========================================================================
    
    const newsletterForm = document.querySelector('.newsletter-form');
    
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const email = this.querySelector('.newsletter-email').value;
            const submitBtn = this.querySelector('.newsletter-submit');
            
            if (!validateEmail(email)) {
                showMessage('Wprowadź prawidłowy adres email', 'error');
                return;
            }
            
            // Disable form
            submitBtn.textContent = 'Zapisuję...';
            submitBtn.disabled = true;
            
            // Symulacja wysyłania (w rzeczywistości użyj AJAX)
            setTimeout(() => {
                showMessage('Dziękujemy za zapisanie się do newslettera!', 'success');
                this.reset();
                submitBtn.textContent = 'Zapisz się';
                submitBtn.disabled = false;
            }, 1500);
        });
    }
    
    // ==========================================================================
    // FUNKCJE POMOCNICZE
    // ==========================================================================
    
    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }
    
    function showMessage(message, type) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `blog-message ${type}`;
        messageDiv.textContent = message;
        messageDiv.style.cssText = `
            position: fixed;
            top: 100px;
            right: 20px;
            background: ${type === 'success' ? '#00ff9d' : '#ff4757'};
            color: ${type === 'success' ? '#1a1a1a' : '#ffffff'};
            padding: 1rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            z-index: 10000;
            transform: translateX(100%);
            transition: transform 0.3s ease;
        `;
        
        document.body.appendChild(messageDiv);
        
        setTimeout(() => {
            messageDiv.style.transform = 'translateX(0)';
        }, 100);
        
        setTimeout(() => {
            messageDiv.style.transform = 'translateX(100%)';
            setTimeout(() => {
                document.body.removeChild(messageDiv);
            }, 300);
        }, 3000);
    }
    
    function showNoPostsMessage() {
        const postsGrid = document.getElementById('blog-posts-grid');
        const noPostsDiv = document.createElement('div');
        noPostsDiv.className = 'no-posts-found';
        noPostsDiv.innerHTML = `
            <h3>Nie znaleziono artykułów</h3>
            <p>Spróbuj zmienić kryteria wyszukiwania lub przeglądaj wszystkie kategorie.</p>
        `;
        postsGrid.appendChild(noPostsDiv);
    }
    
    function showNoResultsMessage(query) {
        hideNoPostsMessage();
        const postsGrid = document.getElementById('blog-posts-grid');
        const noResultsDiv = document.createElement('div');
        noResultsDiv.className = 'no-posts-found';
        noResultsDiv.innerHTML = `
            <h3>Brak wyników dla "${query}"</h3>
            <p>Spróbuj użyć innych słów kluczowych lub przeglądaj wszystkie artykuły.</p>
        `;
        postsGrid.appendChild(noResultsDiv);
    }
    
    function hideNoPostsMessage() {
        const noPostsFound = document.querySelector('.no-posts-found');
        if (noPostsFound) {
            noPostsFound.remove();
        }
    }
    
    function showEndMessage() {
        const loadMoreContainer = document.querySelector('.load-more-container');
        const endMessage = document.createElement('div');
        endMessage.className = 'end-message';
        endMessage.innerHTML = `
            <p style="text-align: center; color: var(--text-color-dim); margin-top: 2rem;">
                🎉 To wszystkie artykuły! Śledź nasz blog, aby nie przegapić nowych treści.
            </p>
        `;
        loadMoreContainer.appendChild(endMessage);
    }
    
    // ==========================================================================
    // SMOOTH SCROLL DLA LINKÓW WEWNĘTRZNYCH
    // ==========================================================================
    
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // ==========================================================================
    // LAZY LOADING IMAGES
    // ==========================================================================
    
    const images = document.querySelectorAll('img[data-src]');
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.remove('lazy');
                imageObserver.unobserve(img);
            }
        });
    });
    
    images.forEach(img => imageObserver.observe(img));
    
    // ==========================================================================
    // KEYBOARD NAVIGATION
    // ==========================================================================
    
    document.addEventListener('keydown', function(e) {
        // ESC - wyczyść wyszukiwanie
        if (e.key === 'Escape' && searchField) {
            searchField.value = '';
            filterBySearch('');
            searchField.blur();
        }
        
        // Ctrl/Cmd + K - focus na wyszukiwanie
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            if (searchField) {
                searchField.focus();
            }
        }
    });
});