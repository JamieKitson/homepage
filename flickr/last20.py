import instaloader

L = instaloader.Instaloader(
    dirname_pattern="/srv/http/192.168.1.4/py/instagram/",  # --dirname-pattern
    download_videos=False,                                   # --no-videos
    compress_json=False,                                     # --no-compress-json
)
L.load_session_from_file("rudolphjoshua2025")                # --login rudolphjoshua2025

# Build the profile directly from its user id, avoiding the broken web_profile_info lookup.
profile = instaloader.Profile(L.context, {"id": 34072014, "username": "jamiekitson"})

L.posts_download_loop(
    profile.get_posts(), profile.username,
    fast_update=True,       # --fast-update
    max_count=20,           # -c 20
    possibly_pinned=3,      # same pinned-post handling the CLI uses with --fast-update
)
# --no-profile-pic: nothing to do, since the script never downloads it

