<div class="loading-screen" id="loadingScreen">
    <div class="loader"></div>
</div>

<style>
    .loading-screen {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(224, 234, 252, 0.8);
        backdrop-filter: blur(5px);
        -webkit-backdrop-filter: blur(5px);
        display: none; /* Hidden by default */
        justify-content: center;
        align-items: center;
        z-index: 9999;
        opacity: 1;
        transition: opacity 0.5s ease;
    }

    .loading-screen.visible {
        display: flex; /* Shown when visible class is added */
    }

    .loading-screen.hidden {
        opacity: 0;
        pointer-events: none;
    }

    .loader {
        width: 60px;
        height: 60px;
        border: 6px solid rgba(255, 255, 255, 0.3);
        border-top: 6px solid #FFC107;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        box-shadow: 0 0 10px rgba(255, 193, 7, 0.5);
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    @media (max-width: 576px) {
        .loader {
            width: 40px;
            height: 40px;
            border-width: 4px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const loadingScreen = document.getElementById('loadingScreen');

        // Show loader on link clicks
        document.querySelectorAll('a[href]').forEach(link => {
            link.addEventListener('click', (e) => {
                // Ignore clicks that don't navigate (e.g., same-page anchors or external links)
                if (link.getAttribute('href').startsWith('#') || 
                    link.getAttribute('href').startsWith('http') || 
                    link.target === '_blank') return;

                loadingScreen.classList.remove('hidden');
                loadingScreen.classList.add('visible');
            });
        });

        // Hide loader when page fully loads
        window.addEventListener('load', () => {
            setTimeout(() => {
                loadingScreen.classList.remove('visible');
                loadingScreen.classList.add('hidden');
            }, 500); // Delay for smoother transition
        });

        // Initial hide (for first load)
        loadingScreen.classList.add('hidden');
    });
</script>