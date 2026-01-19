    <!-- Footer -->
    <footer class="footer">
      <div class="footer-content">
        <div class="footer-links">
          <a href="index.php#about">About Us</a>
          <a href="index.php#contact">Contact</a>
          <a href="index.php#faq">FAQ</a>
          <a href="index.php#shipping">Shipping & Returns</a>
        </div>
        <div class="footer-bottom">
          <p>&copy; <?php echo date('Y'); ?> Soumis Collections. All rights reserved.</p>
          <p style="margin-top: 10px; font-size: 12px; opacity: 0.8;">🌍 Your Trusted Jewellery Partner | 🚚 Free Shipping on Orders Over ₹5000 | ✨ 30-Day Returns</p>
        </div>
      </div>
    </footer>

    <!-- Theme Toggle Button -->
    <button class="theme-toggle" id="theme-toggle" title="Toggle dark mode" aria-label="Toggle dark mode">🌙</button>

    <script>
      // Dark mode toggle functionality
      const themeToggle = document.getElementById('theme-toggle');
      const htmlElement = document.documentElement;
      const body = document.body;
      
      // Check saved theme preference
      const savedTheme = localStorage.getItem('theme') || 'light';
      const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
      
      function applyTheme(theme) {
        if (theme === 'dark') {
          body.classList.add('dark-mode');
          themeToggle.textContent = '☀️';
          themeToggle.title = 'Switch to light mode';
          localStorage.setItem('theme', 'dark');
        } else {
          body.classList.remove('dark-mode');
          themeToggle.textContent = '🌙';
          themeToggle.title = 'Switch to dark mode';
          localStorage.setItem('theme', 'light');
        }
      }
      
      // Initialize theme
      if (savedTheme === 'dark') {
        applyTheme('dark');
      } else if (savedTheme === 'auto' && prefersDark) {
        applyTheme('dark');
      } else {
        applyTheme('light');
      }
      
      // Toggle on button click
      themeToggle.addEventListener('click', () => {
        const isDarkMode = body.classList.contains('dark-mode');
        applyTheme(isDarkMode ? 'light' : 'dark');
      });
      
      // Listen for system theme changes
      window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
        if (localStorage.getItem('theme') === 'auto' || !localStorage.getItem('theme')) {
          applyTheme(e.matches ? 'dark' : 'light');
        }
      });
    </script>
  </body>
</html>
