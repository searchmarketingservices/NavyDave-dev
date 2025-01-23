@extends('dashboard.layouts.master')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    .main-box-navy .left-all-links ul li a.community-active,
    .main-box-navy .left-all-links ul li a:hover {
        background-color: white;
        font-weight: 600;
    }

    .main-box-navy .left-all-links ul li a.community-active span,
    .main-box-navy .left-all-links ul li a:hover span {
        background-color: #2CC374;
    }

    .main-box-navy .left-all-links ul li a.community-active span img,
    .main-box-navy .left-all-links ul li a:hover span img {
        filter: invert(0) hue-rotate(465deg) brightness(10.5);
    }

    #write-post-box {
        background-color: #f1f1f1;
        border-radius: 15px;
        padding: 20px;
    }

    #write-post-box img#uploaded-image {
        position: relative !important;
    }

    #write-post-box .img-box-with-img-icons {
        position: relative;
        width: 200px;
        height: 200px;
    }

    #write-post-box .img-box-with-img-icons .icon {
        position: absolute;
        right: 0 !important;
        background-color: #ffffff !important;
        border-radius: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 25px;
        height: 25px;
        top: 5px !important;
    }

    #write-post-box .img-box-with-img-icons img,
    #write-post-box .img-box-with-img-icons video {
        width: 200px;
        height: 200px;
        position: absolute;
        top: 0;
        right: 0;
        left: 0;
        margin: auto;
        object-fit: cover;
    }

    .shadow-box .large-input-box textarea {
        background-color: #F1F1F1;
        width: 100%;
        padding: 20px;
        border-radius: 10px;
        height: 100px;
        padding-left: 20px;
        border: 1px solid #0000003b;
    }

    .main-calendar-box.main-calendar-box-list.customers-box .two-boxes-inline {
        display: flex;
        column-gap: 15px;
        align-items: flex-end;
        flex-direction: column;
        row-gap: 10px;
    }

    .main-calendar-box.main-calendar-box-list.customers-box .two-boxes-inline button {
        background-color: #3bc476;
        border-radius: 5px;
        border: 1px solid #3bc476;
        transition: .3s;
    }

    .main-calendar-box.main-calendar-box-list.customers-box .two-boxes-inline button:hover {
        background-color: black;
        border-color: black;
    }

    .main-calendar-box.main-calendar-box-list.customers-box .three-things-align {
        margin-bottom: 36px;
    }

    .post-slider-box .three-images-align {
        margin: 0 !important;
    }

    .shadow-box .person-box {
        width: 100%;
    }

    .post-slider-box {
        position: relative;
        width: 100%;
        overflow: hidden;
    }

    .post-slider-imges-box {
        width: 1000px;
        max-width: 1000px;
        overflow: hidden;
        overflow-x: auto;
        white-space: nowrap;
        padding-bottom: 20px;
        margin-bottom: 30px;
    }

    .post-slider-imges-box .three-images-align {
        width: 345px;
        display: inline-block !important;
        max-width: 345px;
    }

    .shadow-box .person-box .text {
        width: 100%;
    }

    .post-slider-imges-box .three-images-align img,
    .post-slider-imges-box .three-images-align video {
        width: 300px;
        height: 300px;
        border: 1px solid #00000052;
        border-radius: 10px;
    }

    /* width */
    .post-slider-imges-box::-webkit-scrollbar {
        width: 5px;
        height: 5px;
    }

    /* Track */
    .post-slider-imges-box::-webkit-scrollbar-track {
        box-shadow: inset 0 0 5px grey;
        border-radius: 10px;
    }

    /* Handle */
    .post-slider-imges-box::-webkit-scrollbar-thumb {
        background: #2CC374;
        border-radius: 10px;
    }

    /* Handle on hover */
    .post-slider-imges-box::-webkit-scrollbar-thumb:hover {
        background: #000000;
    }

    .shadow-box .input-box-three-icons .large-input-box.large-input-box-small button#comment_post {
        background-color: #3bc476;
        border-radius: 5px;
        border: 1px solid #3bc476;
        transition: .3s;
        float: right;
        margin-top: 10px;
    }

    .shadow-box .input-box-three-icons .large-input-box.large-input-box-small button#comment_post:hover {
        background-color: black;
    }

    .shadow-box .input-box-three-icons .large-input-box.large-input-box-small {
        width: 80% !important;
    }

    .shadow-box .input-box-three-icons .three-things-align {
        width: 18% !important;
    }

    .shadow-box .input-box-three-icons {
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
    }

    .reply-box p {
        display: flex;
        flex-direction: column;
        font-size: 14px;
    }

    .reply-box p strong {
        font-size: 12px;
    }
    .shadow-box .large-input-box.large-input-box-small input {
    height: 60px;
    padding-right: 60px;
}
.shadow-box .input-box-three-icons .large-input-box.large-input-box-small button#comment_post {
    position: absolute;
    right: 10px;
    top: 5px;
}
.comment-box p.d-flex.gap-3.w-100 img.mt-1 {
    background-color: #000000;
    width: 35px;
    height: 35px;
    object-fit: none;
    border-radius: 5px;
    cursor: pointer;
    transition: .3s;
}

</style>
@section('content')
    <div class="col-lg-10">
        <div class="main-calendar-box main-calendar-box-list customers-box">
            <h5> Community Feeds</h5>
            <div class="shadow-box">
                <div class="three-link-align">
                    <div class="box">
                        <button id="write-post" style="background: #ffffff!important;"> <img
                                src="{{ asset('assets/images/write-a-post.png') }}" alt=""></button>
                    </div>
                    <div class="box">
                        <label id="upload-photo" for="file-input" style="cursor: pointer">
                            <img src="{{ asset('assets/images/upload-media.png') }}" width="100%" height="40px"
                                alt="">
                        </label>
                        <input type="file" id="file-input" class="d-none" multiple name="image[]" />
                    </div>
                    {{-- <div class="box">
                        <label id="upload-video" for="video-input" style="cursor: pointer">
                            <img src="{{ asset('assets/images/upload-video.png') }}" alt="">
                        </label>
                        <input type="file" id="video-input" class="d-none" multiple name="video" />
                    </div> --}}

                </div>
                <div class="large-input-box d-none" id="write-post-box">
                    <div class="two-boxes-inline">
                        <textarea placeholder="Write something here..." id="post_text" name="post_text"></textarea>
                        <button id="post" class="btn btn-primary"><i class="fa fa-paper-plane"
                                aria-hidden="true"></i></button>
                    </div>
                    <div id="uploaded-images" class="d-flex flex-wrap">
                        <!-- Uploaded images will be displayed here -->
                    </div>
                </div>

            </div>
            <div id="post-container"></div>

            <button id="load-more" onclick="loadMore()" class="btn btn-secondary text-center mt-3">Show More</button>
        </div>
    </div>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        $(document).ready(function() {
            Pusher.logToConsole = false;

            var pusher = new Pusher('3af0341c542582fe2550', {
                cluster: "ap2",
                encrypted: false,
                useTls: true,
            });

            var channel = pusher.subscribe('community-feed');
            channel.bind('post-created', function(data) {
                console.log("Hamamd", data);
                // APPEND
                const postContainer = document.getElementById('post-container');

                if (data.post) {
                    let imageSection = '';
                    let videoSection = '';

                    // Loop through images
                    if (data.post.images) {
                        data.post.images.forEach(image => {
                            imageSection += `
                                <div class="three-images-align">
                                        <img src="{{ Storage::url('${image.path}') }}" width="100px" height="100px" alt="" >
                                </div>`;
                        });
                    }

                    // Loop through videos
                    if (data.post.videos) {
                        data.post.videos.forEach(video => {
                            videoSection += `
                            <div class="three-images-align">
                                <video poster="{{ Storage::url('${video.path}') }}" controls preload="none">
                                <source src="{{ Storage::url('${video.path}') }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>

                            </div>`;
                        });
                    }

                    const likeButtonImage = data.post.hasLiked ?
                        "{{ asset('assets/images/liked.png') }}" // Colorful image for liked state
                        :
                        "{{ asset('assets/images/thums.png') }}"; // Default image for not liked

                    postContainer.insertAdjacentHTML('afterbegin', `
                    <div class="shadow-box">
                        <div class="person-box">
                            <img src="{{ asset('assets/images/tony-stark-img.png') }}" alt="">
                            <div class="text">
                                <div class="two-text-align">
                                    <h6>${data.post.user.name}</h6>
                                </div>
                                <p>${data.post.content}</p>
                                <div class="post-slider-box">
                                    <div class="post-slider-imges-box">
                                        ${imageSection}
                                        </div>
                                        <div class="post-slider-imges-box post-slider-videos-box">
                                            ${videoSection}
                                        </div>

                                </div>
                            </div>
                        </div>
                        <div class="input-box-three-icons">
                            <div class="large-input-box large-input-box-small">
                                <input type="text" placeholder="Write something here..." id="comment_input" class="d-none">
                                <img class="flow-img" src="{{ asset('assets/images/input-box-edit.png') }}" alt="" id="comment_png" style="display: none">
                                <button id="comment_post" class="btn btn-primary d-none" onclick="submitComment(${data.post.id}, this)">
                                    <i class="fa fa-paper-plane" aria-hidden="true"></i>
                                </button>
                            </div>
                            <div class="three-things-align">
                                <ul>
                                <li>
                                    <button style="background: #ffffff!important;">
                                        <img src="${likeButtonImage}" alt="Like" id="like-btn-${data.post.id}" onclick="like(${data.post.id}, this)">
                                    </button>
                                    <span id="like-count-${data.post.id}">0</span> Likes
                                </li>
                                <li>
                                    <button style="background: #ffffff!important;"><img src="{{ asset('assets/images/message.png') }}" alt="Comment" id="comment" onclick="comment(${data.post.id}, this)"></button>
                                    <span id="comment-count-${data.post.id}">0</span> Comments
                                </li>
                            </ul>
                            </div>
                            <div class="reply-container"></div>
                        </div>
                    </div>`);
                }
                // APPEND

            });

            writepost();
            uploadimage();
            removeImage();

            function writepost() {
                $("#write-post").click(function() {
                    $("#write-post-box").toggleClass("d-block");
                });
            }

            function uploadimage() {
                $("#file-input").on("change", function() {
                    var files = this.files;

                    $("#uploaded-images").empty();

                    if (files.length > 0) {
                        $("#write-post-box").toggleClass("d-none").addClass("d-block");

                        for (var i = 0; i < files.length; i++) {
                            var file = files[i];

                            if (file.type.startsWith('image/')) {
                                var reader = new FileReader();

                                reader.onload = (function(file) {
                                    return function(e) {
                                        $("#uploaded-images").append(`
                                    <div class="position-relative m-2 image-container">
                                        <div class="img-box-with-img-icons">
                                            <div class="icon remove-icon" style="top: 0.5rem; right: 0.5rem; z-index: 10; background: rgba(225, 225, 225, 0.856); cursor: pointer;">
                                                <i class="fa fa-times" data-file-name="` + file.name + `"></i>
                                            </div>
                                            <img class="flow-img" src="` + e.target.result + `" alt="Uploaded Image">
                                        </div>
                                    </div>
                                `);
                                    };
                                })(file);

                                reader.readAsDataURL(file);
                            }

                            if (file.type.startsWith('video/')) {
                                $("#uploaded-images").append(`
                                    <div class="position-relative m-2 image-container">
                                        <div class="img-box-with-img-icons">
                                            <div class="icon remove-icon" style="top: 0.5rem; right: 0.5rem; z-index: 10; background: rgba(225, 225, 225, 0.856); cursor: pointer;">
                                                <i class="fa fa-times" data-file-name="` + file.name + `"></i>
                                            </div>
                                            <video class="flow-img" controls preload="none">
                                                <source src="` + URL.createObjectURL(file) + `" type="video/mp4">
                                            </video>
                                        </div>
                                    </div>
                                `);
                            }

                        }
                    }
                });
            }

            function removeImage() {
                $("#uploaded-images").on("click", ".remove-icon", function() {
                    $(this).closest(".image-container").remove();
                });
            }

            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            // Include CSRF token in AJAX setup
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            // Upload Image and content
            $("#post").click(function() {
                var formData = new FormData();
                formData.append('content', $("#post_text").val());

                var imageInput = $("#file-input")[0];
                var videoInput = $("#video-input")[0];

                if (imageInput && imageInput.files) {
                    var imageFiles = imageInput.files;
                    for (var i = 0; i < imageFiles.length; i++) {
                        formData.append('files[]', imageFiles[i]);
                    }
                }

                if (videoInput && videoInput.files) {
                    var videoFiles = videoInput.files;
                    for (var i = 0; i < videoFiles.length; i++) {
                        formData.append('files[]', videoFiles[i]);
                    }
                }

                $.ajax({
                    url: '/post',
                    type: 'POST',
                    data: formData, // Pass formData directly here
                    contentType: false, // Let the browser set the content type
                    processData: false, // Prevent jQuery from processing data
                    success: function(response) {
                        toastr.success('Post submitted successfully!');
                        $("#write-post-box").addClass("d-none");
                        $("#post_text").val('');
                        $("#file-input").val('');
                        $("#video-input").val('');
                        $("#uploaded-files").empty();
                        $("#uploaded-images").empty();
                    },
                    error: function(error) {
                        // Check if the error response contains JSON (validation errors)
                        if (error.status === 400 && error.responseJSON) {
                            let errors = error.responseJSON;

                            // Iterate over the error content and print each message
                            if (errors.content && Array.isArray(errors.content)) {
                                errors.content.forEach(function(message) {
                                    toastr.error(
                                        message
                                    ); // Use toastr or console.log(message) to display the errors
                                });
                            } else {
                                toastr.error('An unexpected error occurred.');
                            }
                        } else {
                            toastr.error('An unexpected error occurred.');
                        }
                    }
                });
            });
        });

        // Fetch Post
        let currentPage = 0;
        let lastPage = 0;

        // Load more posts
        function loadMore() {
            $.ajax({
                url: `/post/get?page=${currentPage + 1}`,
                type: 'GET',
                success: function(response) {
                    const postContainer = document.getElementById('post-container');

                    lastPage = response.last_page;

                    if (currentPage >= lastPage) {
                        document.getElementById('load-more').style.display = 'none';
                    }

                    response.data.forEach(post => {
                        let imageSection = '';
                        let videoSection = '';

                        // Loop through images
                        if (post.images) {
                            post.images.forEach(image => {
                                imageSection += `
                                <div class="three-images-align">
                                        <img src="{{ Storage::url('${image.path}') }}" width="100px" height="100px" alt="" >
                                </div>`;
                            });
                        }

                        // Loop through videos
                        if (post.videos) {
                            post.videos.forEach(video => {
                                videoSection += `
                            <div class="three-images-align">
                                <video poster="{{ Storage::url('${video.path}') }}" controls preload="none">
                                <source src="{{ Storage::url('${video.path}') }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>

                            </div>`;
                            });
                        }

                        const likeButtonImage = post.hasLiked ?
                            "{{ asset('assets/images/liked.png') }}" // Colorful image for liked state
                            :
                            "{{ asset('assets/images/thums.png') }}"; // Default image for not liked

                        postContainer.innerHTML += `
                    <div class="shadow-box">
                        <div class="person-box">
                            <img src="{{ asset('assets/images/tony-stark-img.png') }}" alt="">
                            <div class="text">
                                <div class="two-text-align">
                                    <h6>${post.user.name}</h6>
                                </div>
                                <p>${post.content}</p>
                                <div class="post-slider-box">
                                    <div class="post-slider-imges-box">
                                        ${imageSection}
                                        </div>
                                        <div class="post-slider-imges-box post-slider-videos-box">
                                            ${videoSection}
                                        </div>

                                </div>
                            </div>
                        </div>
                        <div class="input-box-three-icons">
                            <div class="large-input-box large-input-box-small">
                                <input type="text" placeholder="Write something here..." id="comment_input" class="d-none">
                                <img class="flow-img" src="{{ asset('assets/images/input-box-edit.png') }}" alt="" id="comment_png" style="display: none">
                                <button id="comment_post" class="btn btn-primary d-none" onclick="submitComment(${post.id}, this)">
                                    <i class="fa fa-paper-plane" aria-hidden="true"></i>
                                </button>
                            </div>
                            <div class="three-things-align">
                                <ul>
                                <li>
                                    <button style="background: #ffffff!important;">
                                        <img src="${likeButtonImage}" alt="Like" id="like-btn-${post.id}" onclick="like(${post.id}, this)">
                                    </button>
                                    <span id="like-count-${post.id}">${post.likeCount}</span> Likes
                                </li>
                                <li>
                                    <button style="background: #ffffff!important;"><img src="{{ asset('assets/images/message.png') }}" alt="Comment" id="comment" onclick="comment(${post.id}, this)"></button>
                                    <span id="comment-count-${post.id}">${post.comments.length}</span> Comments
                                </li>
                            </ul>
                            </div>
                            <div class="reply-container"></div>
                        </div>
                    </div>`;
                    });
                    currentPage++;
                },
                error: function(xhr) {
                    alert('An error occurred while loading more posts.');
                }
            });
        }

        // Function to toggle comment input and fetch replies
        function comment(id, element) {
            const parentBox = $(element).closest('.input-box-three-icons');
            const authUserId = {{ auth()->user()->id }};
            const isAdmin = {{ auth()->user()->hasRole('admin') ? 'true' : 'false' }};
            // Toggle comment input
            parentBox.find("#comment_input").toggleClass("d-block d-none");
            parentBox.find("#comment_post").toggleClass("d-block d-none");
            parentBox.find("#comment_png").toggle();

            // Fetch existing replies and display them under the comment
            $.ajax({
                url: `/comments/${id}`, // Endpoint to fetch replies for the post
                type: 'GET',
                success: function(response) {
                    let repliesHtml = '';
                    response.comments.forEach(reply => {
                        repliesHtml += `

                        <div class="comment-box">
                            <strong>${reply.user.name}</strong>
                            <p class="d-flex gap-3 w-100">${reply.comment}`;

                        // Check if the current user is the owner of the comment or an admin
                        if (reply.user_id === authUserId || isAdmin) {
                            repliesHtml += `
                        <img src="/assets/images/delete.png" alt="" width="15px" height="15px"
                        onclick="deleteReply(${reply.id},this)" class="mt-1">`;
                        }

                        repliesHtml += `</p></div>`;
                    });

                    // Append replies under the comment input box
                    parentBox.find(".reply-container").html(repliesHtml);
                },
                error: function(xhr) {
                    alert('An error occurred while fetching replies.');
                }
            });
        }

        // delete comment
        function deleteReply(id, element) {
            const deleteUrl = `{{ route('comment.delete', ':id') }}`;
            const finalUrl = deleteUrl.replace(':id', id);

            $.ajax({
                url: finalUrl,
                type: 'POST',
                success: function(response) {
                    console.log("Comment deleted successfully:", response.comment.post_id);
                    comment(response.comment.post_id, element);
                },
                error: function(xhr) {
                    alert('An error occurred: ' + xhr.responseJSON.message);
                }
            });
        }


        function like(id, element) {
            const parentBox = $(element).closest('.input-box-three-icons');

            $.ajax({
                url: `/like/${id}`,
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // Update like count dynamically
                    const likeCountElement = document.getElementById(`like-count-${id}`);
                    likeCountElement.textContent = response.likes;

                    // Change the like button image based on whether the post was liked or unliked
                    const likeButton = document.getElementById(`like-btn-${id}`);
                    if (response.liked) {
                        likeButton.src = "{{ asset('assets/images/liked.png') }}"; // Set colorful liked image
                    } else {
                        likeButton.src = "{{ asset('assets/images/thums.png') }}"; // Set default like image
                    }
                },
                error: function(xhr) {
                    alert('An error occurred while liking/unliking the post.');
                }
            });
        }




        // Function to submit comment
        function submitComment(postId, element) {
            const parentBox = $(element).closest('.input-box-three-icons');
            const commentContent = parentBox.find("#comment_input").val();

            $.ajax({
                url: `/comment/${postId}`, // Post comment endpoint
                type: 'POST',
                data: {
                    content: commentContent,
                    post_id: postId,
                    _token: '{{ csrf_token() }}' // Add CSRF token for Laravel
                },
                success: function(response) {
                    $('#comment-count-' + postId).text(response.count);
                    // Optionally, append the new comment directly under the post
                    parentBox.find(".reply-container").append(`
                        <div class="comment-box">
                                <strong>${response.comment.user.name} </strong> <p class="d-flex gap-3 w-100">${response.comment.comment}  <img src="{{ asset('assets/images/delete.png') }}" alt=""  width="15px" height="15px" onclick="deleteReply(${response.comment.id},this)" class="mt-1"></p>
                            </div>
                    `);

                    // Clear the input field
                    parentBox.find("#comment_input").val('').toggleClass("d-none d-block");
                    parentBox.find("#comment_post").toggleClass("d-block d-none");
                    parentBox.find("#comment_png").hide();
                },
                error: function(xhr) {
                    alert('An error occurred while submitting the comment.');
                }
            });
        }

        loadMore();
    </script>
@endsection
