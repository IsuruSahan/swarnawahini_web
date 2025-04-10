<div class="split-layout">
    <div class="split-left">
    <?php require 'components/video_player.php'; ?>
    </div>
    <div class="split-right">
    <?php require 'components/facebook_feed.php'; ?>
    </div>
</div>

<style>
    .split-layout {
        display: flex;
        width: 100%;
        max-width: 1200px; /* Matches banner slider and video player */
        margin: 20px auto; /* Consistent spacing */
        gap: 20px; /* Space between sections */
    }

    .split-left {
        flex: 2; /* 2/3 of the width */
        background: rgba(255, 255, 255, 0.1); /* Glassmorphism */
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border-radius: 20px; /* Curved corners */
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.2);
        padding: 20px; /* Inner spacing */
        min-height: 300px; /* Matches banner slider height */
    }

    .split-right {
        flex: 1; /* 1/3 of the width */
        background: rgba(255, 255, 255, 0.1); /* Glassmorphism */
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border-radius: 20px; /* Curved corners */
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.2);
        padding: 20px; /* Inner spacing */
        min-height: 300px; /* Matches banner slider height */
    }

    /* Responsive adjustments */
    @media (max-width: 991px) {
        .split-layout {
            flex-direction: column; /* Stack vertically on smaller screens */
            margin: 15px auto;
            gap: 15px;
        }
        .split-left, .split-right {
            border-radius: 15px;
            min-height: 200px;
        }
    }

    @media (max-width: 576px) {
        .split-layout {
            margin: 10px auto;
            gap: 10px;
        }
        .split-left, .split-right {
            border-radius: 10px;
            min-height: 150px;
            padding: 15px;
        }
    }
</style>