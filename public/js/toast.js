const toast = document.getElementById('toast');
            if (toast) {
                // Set Color based on type
                <?php if (isset($_SESSION['flash_success'])): ?>
                    toast.style.borderLeftColor = '#22c55e'; // Green
                <?php else: ?>
                    toast.style.borderLeftColor = '#ef4444'; // Red
                <?php endif; ?>

                // Auto dismiss
                setTimeout(() => {
                    toast.style.opacity = '0';
                    toast.style.transform = 'translateX(100%)';
                    toast.style.transition = 'all 0.5s ease';
                    setTimeout(() => toast.remove(), 500);
                }, 4000);
            }
        </script>