<div class="facebook-feed">
    <iframe 
        src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Fswarnavahini%2F&tabs=timeline&width=364px&height=600px&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId"
        width="364px" 
        height="600px" 
        style="border:none;overflow:hidden" 
        scrolling="no" 
        frameborder="0" 
        allowtransparency="true" 
        allow="encrypted-media"
        class="facebook-iframe"
    ></iframe>
</div>

<style>
    .facebook-feed {
        position: relative;
        width: 100%;
        max-width: 364px; /* Matches iframe width */
        margin: 20px auto; /* Consistent spacing */
        border-radius: 20px; /* Curved corners */
        background: rgba(255, 255, 255, 0.1); /* Glassmorphism background */
        backdrop-filter: blur(10px); /* Blur effect */
        -webkit-backdrop-filter: blur(10px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2); /* Shadow */
        border: 1px solid rgba(255, 255, 255, 0.2); /* Border */
        overflow: hidden; /* Prevents iframe overflow */
        height: 600px; /* Matches iframe height */
    }

    .facebook-iframe {
        width: 100%;
        height: 100%;
        border: none; /* Ensures no default border */
    }

    /* Responsive adjustments */
    @media (max-width: 991px) {
        .facebook-feed {
            margin: 15px auto;
            border-radius: 15px;
            height: 500px; /* Slightly smaller for tablet */
        }
    }

    @media (max-width: 576px) {
        .facebook-feed {
            max-width: 100%; /* Full width on mobile */
            margin: 10px auto;
            border-radius: 10px;
            height: 400px; /* Smaller for mobile */
        }
    }
</style>