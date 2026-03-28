function toggleSidebar() {
                                const sidebar = document.getElementById('sidebar');
                                const overlay = document.querySelector('.sidebar-overlay');
                                sidebar.classList.toggle('active');
                                overlay.classList.toggle('active');
                            }
                            // Check if mobile, show toggle button
                            if (window.innerWidth <= 768) {
                                document.querySelector('.nav-toggle').style.display = 'block';
                            }
                            window.addEventListener('resize', () => {
                                if (window.innerWidth <= 768) {
                                    document.querySelector('.nav-toggle').style.display = 'block';
                                } else {
                                    document.querySelector('.nav-toggle').style.display = 'none';
                                    document.getElementById('sidebar').classList.remove('active');
                                    document.querySelector('.sidebar-overlay').classList.remove('active');
                                }
                            });