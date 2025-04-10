<div class="video-player">
    <iframe 
        src="https://iframes.5centscdn.com/videojs/hls/aHR0cHM6Ly9qazNsejh4a2x3NzktaGxzLWxpdmUuNWNlbnRzY2RuLmNvbS9saXZlLzYyMjZmN2NiZTU5ZTk5YTkwYjVjZWY2Zjk0Zjk2NmZkLnNkcC9wbGF5bGlzdC5tM3U4P21kNT1GV3NKT0RrT0JvVjkxNXpycWlYcWZ3JmV4cGlyZXM9MTc0NDI3MjAzMw=="
        frameborder="0" 
        allow="autoplay; encrypted-media" 
        allowfullscreen
        class="video-iframe"
    ></iframe>
</div>

<style>
    .video-player {
        position: relative;
        width: 100%;
        max-width: 1200px; /* Matches banner slider */
        margin: 20px auto; /* Consistent spacing */
        border-radius: 20px; /* Curved corners */
        background: rgba(255, 255, 255, 0.1); /* Glassmorphism background */
        backdrop-filter: blur(10px); /* Blur effect */
        -webkit-backdrop-filter: blur(10px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2); /* Shadow */
        border: 1px solid rgba(255, 255, 255, 0.2); /* Border */
        overflow: hidden; /* Prevents iframe overflow */
        padding-top: 56.25%; /* 16:9 aspect ratio (height = width * 9/16) */
    }

    .video-iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: none; /* Removes any default iframe border */
    }

    /* Responsive adjustments */
    @media (max-width: 991px) {
        .video-player {
            margin: 15px auto;
            border-radius: 15px;
        }
    }

    @media (max-width: 576px) {
        .video-player {
            margin: 10px auto;
            border-radius: 10px;
        }
    }
</style>