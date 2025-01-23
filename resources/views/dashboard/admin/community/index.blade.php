            @extends('dashboard.layouts.master')
            @section('content')




                <div class="col-lg-10">
                    <div class="main-calendar-box main-calendar-box-list customers-box community-new ">
                        <div class="two-align-things">
                            <h5> Community Feeds</h5>

                            <div class="two-btns-inline">
                                <a class="btn filter-button" id="latest-btn" data-filter="latest">
                                    <img src="{{ asset('assets/images/filter.png') }}" width="20px" height="20px"
                                        alt="">
                                    Latest</a>
                                <a class="btn filter-button" id="popular-btn" data-filter="popular">
                                    <svg width="25" height="25" viewBox="0 0 25 25" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M6.78818 14.9198L5.2361 21.6406C5.18803 21.8441 5.20246 22.0574 5.2775 22.2526C5.35253 22.4478 5.48468 22.6158 5.65669 22.7347C5.8287 22.8536 6.03257 22.9179 6.24167 22.9191C6.45078 22.9204 6.65539 22.8585 6.8288 22.7416L12.5007 18.9604L18.1726 22.7416C18.35 22.8595 18.5592 22.9201 18.7722 22.9154C18.9851 22.9108 19.1915 22.841 19.3636 22.7155C19.5357 22.5901 19.6652 22.4149 19.7348 22.2136C19.8044 22.0123 19.8106 21.7945 19.7528 21.5896L17.8476 14.9229L22.5726 10.6708C22.7239 10.5346 22.832 10.3569 22.8834 10.1599C22.9349 9.96286 22.9274 9.75507 22.862 9.56221C22.7966 9.36936 22.6762 9.1999 22.5155 9.0748C22.3548 8.9497 22.161 8.87443 21.958 8.85831L16.0194 8.3854L13.4496 2.69686C13.3677 2.51369 13.2345 2.35814 13.0661 2.249C12.8977 2.13986 12.7013 2.08179 12.5007 2.08179C12.3 2.08179 12.1036 2.13986 11.9353 2.249C11.7669 2.35814 11.6337 2.51369 11.5517 2.69686L8.98193 8.3854L3.04339 8.85727C2.84386 8.87308 2.65311 8.94603 2.49396 9.06741C2.33482 9.18879 2.214 9.35344 2.14598 9.54168C2.07796 9.72992 2.06561 9.93377 2.11041 10.1288C2.15521 10.3239 2.25526 10.5019 2.3986 10.6416L6.78818 14.9198Z"
                                            fill="white" />
                                    </svg>
                                    Popular</a>
                                <a class="btn filter-button" id="hot-btn" data-filter="hot">
                                    <svg width="25" height="25" viewBox="0 0 25 25" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M17.1875 8.33328C17.1875 9.89578 16.6667 11.9791 14.1667 12.8124C14.8958 11.0416 15 9.27078 14.4792 7.60411C13.75 5.41661 11.3542 3.74995 9.6875 2.81245C9.27083 2.49995 8.54167 2.91661 8.64583 3.54161C8.64583 4.68745 8.33333 6.35411 6.5625 8.12495C4.27083 10.4166 3.125 12.8124 3.125 15.1041C3.125 18.1249 5.20833 21.8749 9.375 21.8749C5.20833 17.7083 8.33333 14.0624 8.33333 14.0624C9.16667 20.2083 13.5417 21.8749 15.625 21.8749C17.3958 21.8749 20.8333 20.6249 20.8333 15.2083C20.8333 11.9791 19.4792 9.47911 18.3333 8.02078C18.0208 7.49995 17.2917 7.81245 17.1875 8.33328Z"
                                            fill="#222222" />
                                    </svg>
                                    Hot</a>
                            </div>

                        </div>

                        <div class="shadow-box">
                            <div class="input-post-inline">
                                <input type="text" id="post_text" placeholder="What's on your mind?">
                                <button id="post-submit-button">Post</button>
                            </div>

                            <div class="three-link-align">
                                <div class="box">
                                    <label id="upload-photo" for="image-input" style="cursor: pointer">
                                        <img src="{{ asset('assets/images/upload-images.png') }}" width="100%"
                                            height="40px" alt="">
                                    </label>
                                    <input type="file" id="image-input" class="d-none" multiple name="image[]"
                                        accept="image/*" />
                                </div>

                                <div class="box">
                                    <label id="upload-video" for="video-input" style="cursor: pointer">
                                        <img src="{{ asset('assets/images/upload-videos.png') }}" width="100%"
                                            height="40px" alt="">
                                    </label>
                                    <input type="file" id="video-input" class="d-none" multiple name="image[]"
                                        accept="video/*" />
                                </div>

                            </div>

                            <!-- Container for previewing uploaded files -->
                            <div id="preview-container" style="display:none; margin-top: 20px;">
                                <h5>Preview:</h5>
                                <div id="preview-box" class="preview-box"
                                    style="display: flex; gap: 10px; flex-wrap: wrap;">
                                </div>
                            </div>


                        </div>

                        <div id="post-detaling">
                            <!-- Loading Spinner -->
                            <div id="loading-spinner" style="display:none; text-align:center;">
                                <img src="{{ asset('assets/images/loading.gif') }}" width="100px"
                                    height="100px" class="img-fluid mb-3 mt-3" alt="Loading..." />
                            </div>
                        </div>

                        <button id="load-more" onclick="loadPosts('latest')" class="btn btn-secondary text-center mt-3">Show
                            More</button>

                    </div>
                </div>

                <!-- Modal For Edit -->
                <div class="modal fade comment-edit" id="exampleModal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Edit Your Comment</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="editCommentForm">
                                    <textarea id="editCommentInput" placeholder="Edit your comment"></textarea>
                                    <input type="hidden" id="commentId" />
                                    <button type="submit">Save Changes</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Comments Modal -->
                <div class="modal fade comment-edit main-calendar-box main-calendar-box-list customers-box community-new"
                    id="CommentsModal" tabindex="-1" role="dialog" aria-labelledby="CommentsModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content shadow-box">
                            <div class="modal-header">
                                <h5 class="modal-title" id="CommentsModalLabel">Comments</h5>
                                <button type="button" class="close" onclick="closeCommentsModal()"
                                    data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div id="comments-container">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

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

                    .community-new .two-align-things {
                        display: flex;
                        justify-content: space-between;
                        margin-bottom: 40px;
                        align-items: center;
                    }

                    .community-new .two-align-things h5 {
                        margin: 0;
                    }

                    .community-new .two-align-things .two-btns-inline {
                        display: flex;
                        column-gap: 20px;
                    }


                    .main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box .main-admin-blog .detalingsread-more .content {
                        margin: 20px 0;
                    }

                    .main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box .main-admin-blog .detalingsread-more .content p {
                        font-size: 17px;
                        color: #888888;
                    }

                    .main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box .main-admin-blog .detalingsread-more .content p a.read-more-btn {
                        display: block;
                        color: #2CC374;
                        font-weight: 700;
                        transition: .3s;
                        margin: 10px 0;
                        text-decoration: underline;
                    }

                    .main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box .main-admin-blog .detalingsread-more .content p a.read-more-btn:hover {
                        color: black;
                    }


                    .btn {
                        /* Your default anchor styles here */
                        text-decoration: none;
                        color: gray;
                    }

                    .btn.active {
                        /* Active state styles */
                        color: black;
                    }

                    .community-new .two-align-things .two-btns-inline .btn {
                        background-color: #F0F0F0;
                        border-radius: 10px;
                        border: none;
                        color: #222222;
                        font-size: 20px;
                        font-weight: 500;
                        padding: 10px 20px;
                        display: flex;
                        align-items: center;
                        column-gap: 10px;
                        transition: .3s;
                    }

                    .community-new .two-align-things .two-btns-inline .btn svg path {
                        fill: #222222;
                        transition: .3s;
                    }

                    .community-new .two-align-things .two-btns-inline .btn.active {
                        background-color: #2CC374;
                        color: white;
                    }

                    .community-new .two-align-things .two-btns-inline .btn.active svg path {
                        fill: white;
                    }

                    .community-new .two-align-things .two-btns-inline .btn.active img {
                        filter: invert(1);
                    }

                    .community-new .two-align-things .two-btns-inline .btn:hover {
                        color: white;
                        background-color: #2CC374;
                    }

                    .community-new .two-align-things .two-btns-inline .btn:hover svg path {
                        fill: white;
                    }

                    .community-new .two-align-things .two-btns-inline .btn:hover img {
                        filter: invert(1);
                    }

                    .main-calendar-box.main-calendar-box-list.customers-box.community-new {
                        padding: 20px 50px;
                    }

                    .main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box {
                        border: 1px solid #0000002b;
                    }

                    .main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box .input-post-inline {
                        display: flex;
                        justify-content: space-between;
                    }

                    .main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box .input-post-inline input {
                        width: 90%;
                        border: 1px solid #00000030;
                        background-color: #EEEEEE;
                        height: 50px;
                        padding: 20px;
                        border-radius: 50px;
                        color: #999999;
                        font-size: 17px;
                        font-weight: 500;
                    }

                    .main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box .input-post-inline input button {
                        color: white !important;
                    }

                    .main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box .input-post-inline button {
                        background-color: #2CC374;
                        color: white;
                        font-weight: 400;
                        border: none;
                        padding: 10px 0px;
                        border-radius: 10px;
                        font-size: 16px;
                        transition: .3s;
                        width: 120px;
                        text-align: center;
                    }

                    .main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box .input-post-inline button:hover {
                        background-color: black;
                        color: white;
                    }

                    .main-calendar-box.main-calendar-box-list.customers-box.community-new .three-link-align .box label img {
                        width: 153px;
                        height: 24px;
                    }

                    .main-calendar-box.main-calendar-box-list.customers-box.community-new .three-link-align .box label {
                        margin: 0;
                    }

                    .main-calendar-box.main-calendar-box-list.customers-box.community-new .three-link-align {
                        margin-bottom: 0;
                    }

                    .shadow-box.post-detaling .parent-person-box {
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                    }


                    .shadow-box.post-detaling .parent-person-box .person-details {
                        display: flex;
                        align-items: center;
                        column-gap: 20px;
                    }

                    .shadow-box.post-detaling .parent-person-box .person-details .content h6 {
                        color: #0F191A;
                        font-size: 20px;
                        font-weight: 500;
                    }

                    .shadow-box.post-detaling .parent-person-box .person-details .content h5 {
                        font-size: 15px;
                        color: #2CC374;
                        font-weight: 400;
                        margin: 0;
                    }

                    .shadow-box.post-detaling .parent-person-box .person-details-date h4 {
                        color: #777777;
                        font-size: 20px;
                    }

                    .more-text {
                        display: none;
                    }

                    .read-more-btn {
                        color: blue;
                        cursor: pointer;
                    }

                    .dots {
                        display: inline;
                    }

                    .main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box .scroll-full-box {
                        display: flex;
                        flex-direction: row;
                        flex-wrap: nowrap;
                        overflow: scroll;
                        width: 100% !important;
                        max-width: 100% !important;
                        overflow-x: auto;
                        overflow-y: hidden;
                        gap: 30px;
                        padding-bottom: 20px;
                    }

                    .main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box .scroll-full-box .box.imge.video {
                        width: 310px;
                        max-width: 310px;
                        display: contents;
                    }

                    .main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box .scroll-full-box .box.imge.video img,
                    .main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box .scroll-full-box .box.imge.video video {
                        width: 310px;
                        height: 310px;
                        border-radius: 30px;
                        border: 1px solid #0000001a;
                        object-fit: cover;
                        object-position: center;
                    }


                    /* width */
                    .main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box .scroll-full-box::-webkit-scrollbar {
                        width: 5px;
                        height: 5px;
                    }

                    /* Track */
                    .main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box .scroll-full-box::-webkit-scrollbar-track {
                        box-shadow: inset 0 0 5px grey;
                        border-radius: 10px;
                    }

                    /* Handle */
                    .main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box .scroll-full-box::-webkit-scrollbar-thumb {
                        background: #2CC374;
                        border-radius: 10px;
                    }

                    /* Handle on hover */
                    .main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box .scroll-full-box::-webkit-scrollbar-thumb:hover {
                        background: black;
                    }

                    .main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box .comment-input-box {
                        display: flex;
                        justify-content: space-between;
                        margin: 20px 0;
                        align-items: center;
                    }

                    .main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box .comment-input-box .box.input-box {
                        width: 70%;
                        position: relative;
                    }

                    .main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box .comment-input-box .box.input-box input {
                        width: 100%;
                        border: 1px solid #00000030;
                        background-color: #EEEEEE;
                        height: 50px;
                        padding: 20px;
                        border-radius: 50px;
                        color: #999999;
                        font-size: 17px;
                        font-weight: 500;
                    }

                    .main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box .comment-input-box .box.input-box button {
                        position: absolute;
                        right: 10px;
                        color: white;
                        background-color: #2CC374;
                        padding: 7px 20px;
                        border-radius: 50px;
                        top: 6px;
                    }

                    .main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box .comment-input-box .two-btns-inline {
                        display: flex;
                        gap: 20px;
                    }

                    .main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box .comment-input-box .two-btns-inline .box button {
                        background-color: #F0F0F0;
                        font-size: 20px;
                        color: #222222;
                        padding: 8px 20px;
                        display: flex;
                        border-radius: 15px;
                        transition: .3s;
                        align-items: center;
                        gap: 7px;
                    }

                    .main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box .comment-input-box .two-btns-inline .box button:hover {
                        background-color: #2CC374;
                        color: white;
                    }

                    .main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box .comment-input-box .two-btns-inline .box button:hover svg path {
                        fill: white;
                    }

                    .main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box .comment-input-box .two-btns-inline .box button.liked {
                        background-color: #2CC374;
                        color: white;
                    }

                    .main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box .comment-input-box .two-btns-inline .box button.liked svg path {
                        fill: white;
                    }

                    .main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box .person-comment-box {
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                    }

                    .main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box .person-comment-box .img-box {
                        display: flex;
                        align-items: center;
                        column-gap: 10px;
                    }

                    .main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box .person-comment-box .img-box .content-name h6 {
                        color: #0F191A;
                        font-size: 14px;
                        font-weight: 600;
                        margin-bottom: 3px;
                        display: flex !important;
                        align-items: center !important;
                        align-items: center !important;
                    }

                    .main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box .person-comment-box .img-box .content-name h5 {
                        color: #2CC374;
                        font-size: 11px;
                        margin: 0;
                    }

                    .main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box .person-comment-box .two-btns-inline {
                        display: flex;
                        gap: 20px;
                    }

                    .main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box .person-comment-box .two-btns-inline button {
                        background-color: #CCCCCC;
                        padding: 5px 20px;
                        display: flex;
                        gap: 4px;
                        align-items: center;
                        color: white;
                        font-weight: 500;
                        border-radius: 10px;
                        transition: .3s;
                    }

                    .main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box .person-comment-box .two-btns-inline button:hover {
                        background-color: #2cc374;
                    }

                    .main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box .person-comment-content .content-area-comment p {
                        margin: 20px 0;
                    }

                    .person-comments-section button#toggleBtn {
                        float: right;
                        margin-bottom: 0px !important;
                        margin-top: -20px;
                        background-color: #ff000000;
                        color: #2CC374;
                        font-weight: 700;
                        text-decoration: underline;
                        font-size: 17px;
                        transition: .3s;
                    }

                    .person-comments-section button#toggleBtn:hover {
                        color: black;
                    }

                    .comment-edit .modal-body form {
                        width: 100%;
                    }

                    .comment-edit .modal-body form textarea {
                        width: 100%;
                        height: 150px;
                        padding: 15px;
                        border-radius: 10px;
                        margin-bottom: 20px;
                    }

                    .comment-edit .modal-body form button {
                        background-color: #2CC374;
                        display: inline-block;
                        margin-right: 10px;
                        padding: 7px 20px;
                        border-radius: 10px;
                        border: none;
                        color: white;
                        font-size: 16px;
                        transition: .3s;
                    }

                    button {
                        box-shadow: none !important;
                        outline: none !important;
                        stroke: none !important;
                        border: none !important;
                    }

                    .comment-edit .modal-body form button:hover {
                        background-color: black;
                    }

                    .comment-edit .modal-body form button.btn.btn-secondary {
                        background-color: gray !important;
                    }

                    .shadow-box.post-detaling .parent-person-box .person-details img {
                        border-radius: 100%;
                        width: 50px;
                        height: 50px;
                        border: 2px solid #2cc374;
                    }

                    .main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box .person-comment-box .img-box .img img {
                        width: 40px;
                        height: 40px;
                        border-radius: 100%;
                        border: 1px solid #00000026;
                        object-fit: cover;
                    }


                    #preview-box div {
                        position: relative;
                        display: inline-block;
                        margin-bottom: 10px;
                    }

                    #preview-box img,
                    #preview-box video {
                        border-radius: 5px;
                        border: 1px solid #ddd;
                    }

                    .remove-file {
                        position: absolute;
                        top: -10px;
                        right: -10px;
                        color: white;
                        border: none;
                        border-radius: 50%;
                        width: 20px;
                        height: 20px;
                        cursor: pointer;
                        font-size: 12px;
                    }


                    .main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box div#preview-container div#preview-box div {
                        border: none !important;
                        background-color: #ff000000;
                        margin: 0;
                        padding-bottom: 0 !important;
                    }

                    .main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box div#preview-container div#preview-box div {
                        display: flex !important;
                        width: 150px;
                        height: 100px;
                    }

                    .main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box div#preview-container div#preview-box div img {
                        width: 100% !important;
                        height: 100% !important;
                    }

                    .main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box div#preview-container div#preview-box div button.remove-file {
                        border: none !important;
                        background-color: #2cc374 !important;
                        width: 30px;
                        height: 30px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        transition: .3s;
                    }

                    .main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box div#preview-container div#preview-box div button.remove-file img {
                        border: none !important;
                        width: 12px !important;
                        height: 12px !important;
                        transition: .3s;
                    }

                    .main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box div#preview-container div#preview-box div button.remove-file:hover {
                        background-color: black !important;
                    }

                    .main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box div#preview-container div#preview-box div button.remove-file:hover img {
                        filter: invert(1);
                    }

                    .main-calendar-box.main-calendar-box-list.customers-box.community-new button#load-more {
                        background-color: #2cc374;
                        color: white;
                        font-weight: 600;
                        border-radius: 50px;
                        width: 150px;
                        padding: 10px;
                        transition: .3s;
                        display: block;
                        margin: auto;
                        margin-top: 30px !important;
                    }

                    .main-calendar-box.main-calendar-box-list.customers-box.community-new button#load-more:hover {
                        background-color: black;
                        color: white;
                    }

                    div#CommentsModal {
                        background-color: #00000042;
                        padding: 0;
                    }

                    div#exampleModal {
                        z-index: 9999;
                    }

                    div#CommentsModal .modal-dialog {
                        max-width: 60%;
                    }

                    div#exampleModal .modal-dialog {
                        height: 100%;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                    }

                    div#exampleModal .modal-dialog .modal-content {
                        display: block;
                        margin: auto !important;
                    }

                    .no-comments {
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        margin-top: 25px;
                    }

                    #CommentsModal .content-area-comment p {
                        font-size: 20px;
                    }

                    #CommentsModal .reply-box {
                        margin: 20px 0;
                        position: relative;
                        display: flex;
                    }

                    #CommentsModal .reply-box input {
                        border: 1px solid black;
                        border-radius: 50px;
                        width: 100%;
                        height: 50px;
                        padding: 15px;
                        padding-right: 130px;
                    }

                    #CommentsModal .reply-box button {
                        position: absolute;
                        right: 10px;
                        height: 40px;
                        background-color: #2CC374;
                        color: white;
                        padding: 0 40px;
                        border-radius: 50px;
                        top: 5px;
                        transition: .3s;
                    }

                    #CommentsModal .reply-box button:hover {
                        background-color: black;
                    }

                    #CommentsModal .person-comment-content {
                        position: relative;
                    }

                    #CommentsModal .person-comment-content {
                        position: relative;
                        margin: 10px 0 20px 0;
                    }

                    #CommentsModal .person-comment-content.person-comment-content-parent {
                        border-bottom: 2px solid #2cc374;

                    }

                    .like-class-parent {
                        background-color: #2CC374 !important;
                    }

                    #CommentsModal .two-btns-inline button {
                        position: relative;
                        background-color: #ff000000 !important;
                        padding: 0;
                    }

                    #CommentsModal .two-btns-inline button svg path {
                        fill: black !important;
                    }

                    #CommentsModal .two-btns-inline button {
                        color: #000000;
                    }

                    #CommentsModal .two-btns-inline button.like-class-parent {
                        fill: #2CC374 !important;
                    }

                    #CommentsModal .two-btns-inline button.like-class-parent svg path {
                        background-color: #2CC374 !important;
                        fill: #2CC374ed !important;
                    }

                    #CommentsModal .two-btns-inline button.like-class-parent svg path {
                        fill: #2CC374 !important;
                    }

                    @media only screen and (max-width: 1199px){

                        .community-new .two-align-things .two-btns-inline .btn {
        font-size: 14px !important;
        padding: 6px 10px !important;
        column-gap: 5px !important;
    }

    .main-calendar-box.main-calendar-box-list.customers-box.community-new .three-link-align .box label img {
    width: 120px;
    height: 18px;
}
.shadow-box.post-detaling .parent-person-box .person-details {

    column-gap: 10px;
}

.shadow-box.post-detaling .parent-person-box .person-details .content h6 {
    font-size: 16px;
    margin: 0;
}

.main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box .input-post-inline button {
    padding: 10px 0px;
    font-size: 13px;
    width: 100px;
}

.main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box .scroll-full-box .box.imge.video img, .main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box .scroll-full-box .box.imge.video video {
    width: 250px;
    height: 250px;
}

.main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box .comment-input-box .two-btns-inline .box button svg {
    width: 20px;
    height: 20px;
}



                    }

                    @media only screen and (max-width: 1024px){

                        .shadow-box.post-detaling .parent-person-box .person-details-date h4 {
        font-size: 14px !important;
    }
    .person-details-date button.btn.btn-danger {
        font-size: 14px !important;
        gap: 0px;
    }
    .person-details-date button.btn.btn-danger svg {
    width: 20px;
    height: 20px;
}



                    }

                    @media only screen and (max-width: 991px){

                        .main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box .scroll-full-box .box.imge.video img, .main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box .scroll-full-box .box.imge.video video {
                            height: 150px;
                            width: 150px;
                        }

                        div#CommentsModal .modal-dialog {
    max-width: 95%;
    margin-left: 0;
}



                    }

                    @media only screen and (max-width: 767px){
                        .main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box .comment-input-box {
                            display: flex;
                            flex-direction: column;
                            align-items: stretch;
                            justify-content: center;
                            row-gap: 20px;
                        }

                        .main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box .comment-input-box .box.input-box {
                            width: 100% !important;
                        }

                        .main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box .main-admin-blog .detalingsread-more .content p {
                            font-size: 15px;
                        }

                        .main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box .person-comment-content .content-area-comment p {
                            font-size: 15px;
                        }

                        .main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box .person-comment-box .two-btns-inline button {
                            padding: 5px 18px;
                            font-size: 14px;
                        }

                        .main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box .input-post-inline input {
                            padding: 0px 15px;
                        }

                        .shadow-box.post-detaling .parent-person-box .person-details .content h5 {
                        font-size: 13px;
                    }


                    }


                    @media only screen and (max-width: 575px){

                        .main-calendar-box.main-calendar-box-list.customers-box.community-new {
                            padding: 15px !important;
                        }


                        .main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box .input-post-inline {
                            display: flex;
                            flex-direction: column;
                            gap: 10px;
                            justify-content: center;
                            align-items: stretch;
                        }

                    .shadow-box .three-link-align {
                        display: flex;
                        column-gap: 30px;
                        margin: 15px 0;
                        flex-direction: column;
                        align-items: center;
                        justify-content: center;
                        gap: 5px;
                    }

                    .main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box .input-post-inline input, .main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box .input-post-inline button {
                        width: 100% !important;
                    }

                    .community-new .two-align-things {
                        display: flex;
                        flex-direction: column;
                        row-gap: 10px;
                    }

                    .community-new .two-align-things .two-btns-inline .btn svg, .community-new .two-align-things .two-btns-inline .btn img {
                        width: 16px;
                        max-width: 16px;
                    }

                    .shadow-box.post-detaling .parent-person-box {
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                        flex-direction: column;
                        row-gap: 10px;
                    }

                    .community-new .two-align-things .two-btns-inline .btn {
                        font-size: 12px !important;
                    }

                    .person-details-date button.btn.btn-danger {
                        font-size: 12px !important;
                    }

                    .main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box .scroll-full-box .box.imge.video img, .main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box .scroll-full-box .box.imge.video video {
                        width: 100px;
                        height: 100px;
                    }

                    .main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box .main-admin-blog .detalingsread-more .content p {
                        font-size: 14px;
                        text-align: center;
                    }

                    .main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box .comment-input-box .two-btns-inline {
                        display: flex;
                        flex-direction: column;
                        align-items: stretch;
                        justify-content: center;
                    }

                    .main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box .comment-input-box .two-btns-inline .box button {
                        width: 100%;
                        margin: 0;
                    }

                    .main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box .comment-input-box .box.input-box button {
                        position: relative;
                        width: 100%;
                        right: 0;
                    }

                    .main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box .person-comment-box {
                        display: flex;
                        flex-direction: column;
                        row-gap: 10px;
                    }

                    .main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box .person-comment-box .img-box .content-name h6 {
                        display: flex;
                        flex-direction: column;
                        align-items: flex-start !important;
                        justify-content: center;
                        font-size: 15px !important;
                        text-transform: capitalize;
                    }

                    .main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box .person-comment-box .img-box .content-name h6 span {
                        font-size: 12px !important;
                        margin-left: -5px;
                    }

                    .main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box .person-comment-box .img-box .content-name h5 {
                        font-size: 12px;
                    }

                    .main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box .person-comment-box .two-btns-inline button {
                        width: 100%;
                        display: flex;
                        flex-direction: row;
                        justify-content: center;
                    }

                    .main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box .person-comment-box .two-btns-inline {
                        display: contents;
                    }

                    .main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box .person-comment-content .content-area-comment p {
                        font-size: 13px;
                        text-align: center;
                    }

                    .main-calendar-box.main-calendar-box-list.customers-box.community-new {
                        padding: 15px 0px !important;
                    }

                    .main-calendar-box h5 {
                        font-size: 20px;
                    }

                    .main-calendar-box.main-calendar-box-list.customers-box.community-new .shadow-box .comment-input-box .two-btns-inline .box button {
    width: 100%;
    margin: 0;
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-content.shadow-box {
    padding: 10px;
}

.modal-content.shadow-box {
    padding: 10px;
}

.modal-content.shadow-box .reply-box button {
    position: relative !important;
    margin: auto;
    font-size: 12px;
}

.modal-content.shadow-box .reply-box {
    display: flex !important;
    align-items: center;
    justify-content: center;
    flex-direction: column;
}

.modal-content.shadow-box .reply-box input {
    width: 100% !important;
    max-width: 100% !important;
    font-size: 12px;
}

.modal-content.shadow-box .content-area-comment p {
    font-size: 12px !important;
    margin-bottom: 0 !important;
}


                            }

                </style>








                <!-- jQuery -->
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
                <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

                <script>
                    let currentPage = 0;
                    let lastPage = 0;
                    const currentUserId = {{ auth()->user()->id }};
                    const isAdmin = {{ auth()->user()->hasRole('admin') ? 'true' : 'false' }};

                    // Media Preview
                    // Store uploaded files to prevent duplicates
                    let uploadedFiles = new Set();

                    // Function to handle image and video preview
                    function previewFiles(input, type) {
                        const files = input.files;
                        const previewBox = document.getElementById('preview-box');
                        let hasFiles = previewBox.childElementCount > 0; // Check if preview already has files

                        Array.from(files).forEach(file => {
                            const fileName = file.name;

                            // Check if the file is already uploaded
                            if (uploadedFiles.has(fileName)) {
                                // alert('This file has already been uploaded!');
                                return; // Skip the file if it's already uploaded
                            }

                            const fileReader = new FileReader();
                            fileReader.onload = function(e) {
                                let previewElement;

                                // Determine whether it's an image or video and create appropriate element
                                if (type === 'image') {
                                    previewElement = document.createElement('div');
                                    previewElement.innerHTML = `
                                        <img src="${e.target.result}" style="width: 100px; height: 100px; object-fit: cover;" />
                                        <button class="remove-file" data-file-name="${fileName}"><img src="{{ asset('assets/images/close.png') }}" width="20px" height="20px" alt=""></button>
                                    `;
                                } else if (type === 'video') {
                                    previewElement = document.createElement('div');
                                    previewElement.innerHTML = `
                                        <video src="${e.target.result}" controls style="width: 150px; height: 100px;"></video>
                                        <button class="remove-file" data-file-name="${fileName}"><img src="{{ asset('assets/images/close.png') }}" width="20px" height="20px" alt=""></button>
                                    `;
                                }

                                previewElement.style.position = 'relative';
                                previewElement.style.display = 'inline-block';
                                previewElement.style.marginRight = '10px';
                                previewElement.style.border = '1px solid #ddd';
                                previewElement.style.borderRadius = '5px';
                                previewElement.style.textAlign = 'center';

                                // Add file name to the set of uploaded files to avoid duplicates
                                uploadedFiles.add(fileName);

                                // Append the preview element to the preview box
                                previewBox.appendChild(previewElement);
                            };

                            fileReader.readAsDataURL(file);
                        });

                        // Show the preview container if it was hidden
                        if (!hasFiles) {
                            document.getElementById('preview-container').style.display = 'block';
                        }
                    }

                    // Remove file event handler
                    $(document).on('click', '.remove-file', function() {
                        const fileName = $(this).data('file-name');

                        // Remove the file from the set of uploaded files
                        uploadedFiles.delete(fileName);

                        // Remove the preview element from the DOM
                        $(this).parent().remove();

                        // Hide the preview container if there are no more files left
                        if ($('#preview-box').children().length === 0) {
                            $('#preview-container').hide();
                        }
                    });

                    // Image input change event
                    document.getElementById('image-input').addEventListener('change', function() {
                        previewFiles(this, 'image');
                    });

                    // Video input change event
                    document.getElementById('video-input').addEventListener('change', function() {
                        previewFiles(this, 'video');
                    });

                    // Media Preview


                    $("#post-submit-button").click(function() {
                        $("#post-submit-button").prop("disabled", true);
                        $("#post-submit-button").text("Posting...");

                        var formData = new FormData();
                        formData.append('content', $("#post_text").val());
                        formData.append('_token', '{{ csrf_token() }}');

                        var imageInput = $("#image-input")[0];
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
                            data: formData,
                            contentType: false,
                            processData: false,
                            success: function(response) {
                                $("#post-submit-button").prop("disabled", false);
                                $("#post-submit-button").text("Post");
                                toastr.success('Post submitted successfully!');
                                // Clear the preview container and hide it
                                document.getElementById('preview-box').innerHTML = '';
                                document.getElementById('preview-container').style.display = 'none';

                                // Reset the file input fields
                                document.getElementById('image-input').value = '';
                                document.getElementById('video-input').value = '';

                                // Clear the uploaded files set
                                uploadedFiles.clear();

                                // Clear the input field
                                $("#post_text").val('');
                            },
                            error: function(error) {
                                $("#post-submit-button").prop("disabled", false);
                                $("#post-submit-button").text("Post");
                                // Check if the error response contains JSON (validation errors)
                                if (error.status === 400 && error.responseJSON) {
                                    let errors = error.responseJSON;

                                    // Iterate over the error content and print each message
                                    if (errors.content && Array.isArray(errors.content)) {
                                        errors.content.forEach(function(message) {
                                            toastr.error(
                                                message
                                            );
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

                    function timeAgo(dateString) {
                        const now = new Date();
                        const past = new Date(dateString);
                        const seconds = Math.floor((now - past) / 1000);
                        const minutes = Math.floor(seconds / 60);
                        const hours = Math.floor(minutes / 60);
                        const days = Math.floor(hours / 24);

                        if (seconds < 60) return `${seconds} seconds ago`;
                        if (minutes < 60) return `${minutes} minutes ago`;
                        if (hours < 24) return `${hours} hours ago`;
                        return `${days} days ago`;
                    }

                    function formatCount(count) {
                        if (count >= 1000) {
                            return (count / 1000).toFixed(1) + 'K'; // e.g., 1200 becomes "1.2K"
                        }
                        return count.toString(); // Return the count as a string
                    }


                    function loadPosts(filter) {
                        // Check if the current page is already the last page
                        if (currentPage >= lastPage && lastPage !== 0) {
                            // Hide the load more button if we are on the last page
                            document.getElementById('load-more').style.display = 'none';
                            return;
                        }
                        $('#loading-spinner').show();
                        $.ajax({
                            url: `/post/get?page=${currentPage + 1}`,
                            type: 'GET',
                            data: {
                                filter: filter
                            },
                            success: function(response) {
                                $('#loading-spinner').hide();

                                lastPage = response.last_page; // Update last page value

                                if (response.data.length > 0) {


                                    $("#post-detaling").html('');

                                    if (response.data.length > 0) {
                                        response.data.forEach(post => {

                                            let imageSection = '';
                                            let videoSection = '';
                                            let commentSection = '';
                                            let moreComments = '';

                                            // Loop through images
                                            if (post.images) {
                                                post.images.forEach(image => {
                                                    imageSection += `
                                                    <div class="box imge video">
                                                            <img src="{{ Storage::url('${image.path}') }}" width="100px" height="100px" alt="" >
                                                    </div>
                                                `;
                                                });
                                            }

                                            // Loop through videos
                                            if (post.videos) {
                                                post.videos.forEach(video => {
                                                    videoSection += `
                                                    <div class="box imge video">
                                                        <video poster="{{ Storage::url('${video.path}') }}" controls preload="none">
                                                            <source src="{{ Storage::url('${video.path}') }}" type="video/mp4">
                                                            Your browser does not support the video tag.
                                                        </video>
                                                    </div>
                                                `;
                                                });
                                            }

                                            // Loop through comments
                                            if (post.comments && post.comments.length > 0) {
                                                // Show the first comment
                                                let firstComment = post.comments[0];
                                                let img = firstComment.user.image;
                                                let canDeleteComment = firstComment.user_id == currentUserId ||
                                                    isAdmin;
                                                let canEditComment = firstComment.user_id == currentUserId;
                                                let hasLiked = firstComment.commentHasLiked ? 'like-class-parent' :
                                                    '';
                                                let likeCount = firstComment.commentLikeCount || 0;
                                                commentSection += `
                                                <div class="person-comment-content" id="parent-comment-box-in-box-${firstComment.id}">
                                                    <div class="person-comment-box">
                                                        <div class="img-box">
                                                            <div class="img">
                                                                <img ${img ? `src="{{ Storage::url('${img}') }}"` : 'src="{{ asset('assets/images/tony-stark-img.png') }}"'} width="100%" height="40px" alt="">
                                                            </div>
                                                            <div class="content-name">
                                                                <h6>${firstComment.user.name} <span style="font-size: 10px; font-weight: 400; color: #777777;">&nbsp | ${timeAgo(firstComment.created_at)}</span></h6>
                                                                <h5>${firstComment.user.email}</h5>
                                                            </div>
                                                        </div>
                                                        <div class="two-btns-inline">
                                                            ${canEditComment ? `
                                                            <button type="button" class="btn btn-primary" data-comment-id="${firstComment.id}" data-toggle="modal"
                                                                data-target="#exampleModal"><svg width="20" height="19"
                                                                    viewBox="0 0 20 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M15.2451 1.63672L17.5293 3.9209L15.788 5.66297L13.5038 3.37879L15.2451 1.63672ZM6.87891 12.2871H9.16309L14.7114 6.73882L12.4272 4.45464L6.87891 10.0029V12.2871Z"
                                                                        fill="white"></path>
                                                                    <path
                                                                        d="M15.2526 14.5715H6.99758C6.97778 14.5715 6.95723 14.5791 6.93743 14.5791C6.91231 14.5791 6.88718 14.5722 6.86129 14.5715H4.5931V3.91195H9.80636L11.3291 2.38916H4.5931C3.75328 2.38916 3.07031 3.07137 3.07031 3.91195V14.5715C3.07031 15.412 3.75328 16.0942 4.5931 16.0942H15.2526C15.6565 16.0942 16.0438 15.9338 16.3294 15.6482C16.615 15.3627 16.7754 14.9753 16.7754 14.5715V7.9717L15.2526 9.49449V14.5715Z"
                                                                        fill="white"></path>
                                                                </svg>
                                                                Edit</button> ` : ''}
                                                            ${canDeleteComment ? `
                                                            <button type="button" class="delete-comment" data-comment-id="${firstComment.id}"><svg width="19" height="19" viewBox="0 0 19 19" fill="none"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M4.3154 15.331C4.3154 15.7348 4.4758 16.1221 4.76131 16.4076C5.04682 16.6931 5.43406 16.8535 5.83784 16.8535H13.45C13.8538 16.8535 14.241 16.6931 14.5265 16.4076C14.812 16.1221 14.9724 15.7348 14.9724 15.331V6.19645H16.4949V4.67402H13.45V3.15158C13.45 2.74781 13.2896 2.36057 13.0041 2.07506C12.7186 1.78955 12.3313 1.62915 11.9276 1.62915H7.36027C6.95649 1.62915 6.56926 1.78955 6.28375 2.07506C5.99823 2.36057 5.83784 2.74781 5.83784 3.15158V4.67402H2.79297V6.19645H4.3154V15.331ZM7.36027 3.15158H11.9276V4.67402H7.36027V3.15158ZM6.59905 6.19645H13.45V15.331H5.83784V6.19645H6.59905Z"
                                                                        fill="white"></path>
                                                                    <path
                                                                        d="M7.35938 7.71899H8.88181V13.8087H7.35938V7.71899ZM10.4042 7.71899H11.9267V13.8087H10.4042V7.71899Z"
                                                                        fill="white"></path>
                                                                </svg>
                                                                Delete</button>` : ''}
                                                            </div>
                                                    </div>
                                                    <div class="content-area-comment">
                                                        <p>${firstComment.comment}</p>
                                                    </div>
                                                </div>
                                                `;

                                                // Prepare the rest of the comments, but keep them hidden initially
                                                if (post.comments.length > 1) {
                                                    moreComments +=
                                                        `<div class="more-comments" style="display:none;">`;
                                                    post.comments.slice(1).forEach(comment => {
                                                        let canDeleteComment = comment.user.id ==
                                                            currentUserId || isAdmin;
                                                        let canEditComment = comment.user.id ==
                                                            currentUserId;
                                                        let img = comment.user.image;
                                                        moreComments += `
                                                        <div class="person-comment-content">
                                                            <div class="person-comment-box">
                                                                <div class="img-box">
                                                                    <div class="img">
                                                                        <img ${img ? `src="{{ Storage::url('${img}') }}"` : 'src="{{ asset('assets/images/tony-stark-img.png') }}"'} width="100%" height="40px" alt="">
                                                                    </div>
                                                                    <div class="content-name">
                                                                        <h6>${comment.user.name} <span style="font-size: 10px; font-weight: 400; color: #777777;">&nbsp | ${timeAgo(comment.created_at)}</span></h6>
                                                                        <h5>${comment.user.email}</h5>
                                                                    </div>
                                                                </div>
                                                                <div class="two-btns-inline">
                                                                    ${canEditComment ? `
                                                                    <button type="button" class="btn btn-primary" data-comment-id="${comment.id}" data-toggle="modal"
                                                                        data-target="#exampleModal"><svg width="20" height="19"
                                                                            viewBox="0 0 20 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                            <path
                                                                                d="M15.2451 1.63672L17.5293 3.9209L15.788 5.66297L13.5038 3.37879L15.2451 1.63672ZM6.87891 12.2871H9.16309L14.7114 6.73882L12.4272 4.45464L6.87891 10.0029V12.2871Z"
                                                                                fill="white"></path>
                                                                            <path
                                                                                d="M15.2526 14.5715H6.99758C6.97778 14.5715 6.95723 14.5791 6.93743 14.5791C6.91231 14.5791 6.88718 14.5722 6.86129 14.5715H4.5931V3.91195H9.80636L11.3291 2.38916H4.5931C3.75328 2.38916 3.07031 3.07137 3.07031 3.91195V14.5715C3.07031 15.412 3.75328 16.0942 4.5931 16.0942H15.2526C15.6565 16.0942 16.0438 15.9338 16.3294 15.6482C16.615 15.3627 16.7754 14.9753 16.7754 14.5715V7.9717L15.2526 9.49449V14.5715Z"
                                                                                fill="white"></path>
                                                                        </svg>
                                                                        Edit</button> `: ''}
                                                                    ${canDeleteComment ? `
                                                                    <button type="button" class="delete-comment" data-comment-id="${comment.id}"><svg width="19" height="19" viewBox="0 0 19 19" fill="none"
                                                                            xmlns="http://www.w3.org/2000/svg">
                                                                            <path
                                                                                d="M4.3154 15.331C4.3154 15.7348 4.4758 16.1221 4.76131 16.4076C5.04682 16.6931 5.43406 16.8535 5.83784 16.8535H13.45C13.8538 16.8535 14.241 16.6931 14.5265 16.4076C14.812 16.1221 14.9724 15.7348 14.9724 15.331V6.19645H16.4949V4.67402H13.45V3.15158C13.45 2.74781 13.2896 2.36057 13.0041 2.07506C12.7186 1.78955 12.3313 1.62915 11.9276 1.62915H7.36027C6.95649 1.62915 6.56926 1.78955 6.28375 2.07506C5.99823 2.36057 5.83784 2.74781 5.83784 3.15158V4.67402H2.79297V6.19645H4.3154V15.331ZM7.36027 3.15158H11.9276V4.67402H7.36027V3.15158ZM6.59905 6.19645H13.45V15.331H5.83784V6.19645H6.59905Z"
                                                                                fill="white"></path>
                                                                            <path
                                                                                d="M7.35938 7.71899H8.88181V13.8087H7.35938V7.71899ZM10.4042 7.71899H11.9267V13.8087H10.4042V7.71899Z"
                                                                                fill="white"></path>
                                                                        </svg>
                                                                        Delete</button>` : ''}
                                                                </div>
                                                            </div>
                                                            <div class="content-area-comment">
                                                                <p>${comment.comment}</p>
                                                            </div>
                                                        </div>
                                                        `;
                                                    });
                                                    moreComments += `</div>`;
                                                }
                                            }

                                            // Define a character limit for the displayed text
                                            const contentLimit = 300;
                                            const isLongContent = post.content.length > contentLimit;
                                            const truncatedContent = isLongContent ? post.content.substring(0,contentLimit) + '...' : post.content;
                                            const likedStyle = post.hasLiked ? "liked" : "";
                                            const canDeletePost = isAdmin || post.user_id == currentUserId;
                                            const image = post.user.image;


                                            $("#post-detaling").append(`
                                            <div class="shadow-box post-detaling" id="post-box-${post.id}">
                                                <div class="main-admin-blog">
                                                        <div class="parent-person-box">
                                                            <div class="person-details">
                                                                <img ${image ? `src="{{ Storage::url('${image}') }}"` : 'src="{{ asset('assets/images/tony-stark-img.png') }}"'} alt="">
                                                                <div class="content">
                                                                    <h6>${post.user.name}</h6>
                                                                    <h5>${post.user.email}</h5>
                                                                </div>
                                                            </div>
                                                            <div class="person-details-date">
                                                                <h4>${timeAgo(post.created_at)}</h4>
                                                                ${canDeletePost ? `
                                                                <button class="btn btn-danger" onclick="deletePost(${post.id})"><svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M5.20833 20.8334C5.20833 21.3859 5.42783 21.9158 5.81853 22.3065C6.20923 22.6972 6.73913 22.9167 7.29167 22.9167H17.7083C18.2609 22.9167 18.7908 22.6972 19.1815 22.3065C19.5722 21.9158 19.7917 21.3859 19.7917 20.8334V8.33337H21.875V6.25004H17.7083V4.16671C17.7083 3.61417 17.4888 3.08427 17.0981 2.69357C16.7074 2.30287 16.1775 2.08337 15.625 2.08337H9.375C8.82247 2.08337 8.29256 2.30287 7.90186 2.69357C7.51116 3.08427 7.29167 3.61417 7.29167 4.16671V6.25004H3.125V8.33337H5.20833V20.8334ZM9.375 4.16671H15.625V6.25004H9.375V4.16671ZM8.33333 8.33337H17.7083V20.8334H7.29167V8.33337H8.33333Z" fill="#222222"/>
                                                                <path d="M9.375 10.4166H11.4583V18.75H9.375V10.4166ZM13.5417 10.4166H15.625V18.75H13.5417V10.4166Z" fill="#222222"/>
                                                                </svg>
                                                                Delete</button>` : ''}
                                                            </div>
                                                        </div>
                                                        <div class="detalingsread-more">
                                                            <div class="content">
                                                                <p>
                                                                    <span class="less-text">${truncatedContent}
                                                                    </span> <span class="more-text" style="display:none;">${post.content}</span>
                                                                    ${isLongContent ? '<a href="javascript:void(0);" class="read-more-btn" onclick="toggleText(this)">Read more...</a>' : ''}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="scroll-full-box">
                                                            ${imageSection}
                                                            ${videoSection}
                                                        </div>
                                                        <div class="comment-input-box">
                                                            <div class="box input-box">
                                                                    <input type="text" id="commentInput" placeholder="What’s on your mind?">
                                                                    <button onclick="addComment(${post.id}, this)">Comment</button>
                                                            </div>
                                                            <div class="two-btns-inline">
                                                                <div class="box like-btn">
                                                                    <button id="likeButton" class="${likedStyle}" onclick="likePost(${post.id}, this)" data-post-id="${post.id}">
                                                                        <svg width="25" height="26" viewBox="0 0 25 26" fill="none"
                                                                            xmlns="http://www.w3.org/2000/svg">
                                                                            <path
                                                                                d="M20.834 8.83325H14.9882L16.1579 5.32596C16.3684 4.69263 16.2621 3.99054 15.8715 3.44888C15.4809 2.90721 14.8475 2.58325 14.1798 2.58325H12.5007C12.1913 2.58325 11.8986 2.72075 11.6996 2.95825L6.80378 8.83325H4.16732C3.01836 8.83325 2.08398 9.76763 2.08398 10.9166V20.2916C2.08398 21.4405 3.01836 22.3749 4.16732 22.3749H18.0288C18.4526 22.3735 18.8661 22.2435 19.2144 22.0021C19.5628 21.7607 19.8297 21.4192 19.9798 21.0228L22.8517 13.3655C22.8953 13.2486 22.9175 13.1247 22.9173 12.9999V10.9166C22.9173 9.76763 21.9829 8.83325 20.834 8.83325ZM4.16732 10.9166H6.25065V20.2916H4.16732V10.9166ZM20.834 12.8114L18.0288 20.2916H8.33398V10.252L12.9882 4.66659H14.1819L12.5548 9.54471C12.502 9.70129 12.4873 9.8682 12.5118 10.0316C12.5364 10.195 12.5996 10.3502 12.6961 10.4843C12.7927 10.6185 12.9198 10.7276 13.067 10.8028C13.2141 10.878 13.3771 10.917 13.5423 10.9166H20.834V12.8114Z"
                                                                                fill="#222222" />
                                                                        </svg>
                                                                        <span id="like-count-${post.id}">${formatCount(post.likeCount)}</span> Likes
                                                                    </button>
                                                                </div>
                                                                <div class="box like-btn">
                                                                    <button id="commentButton" onclick="showCommentsModal(${post.id}, this)"><svg width="25" height="26" viewBox="0 0 25 26" fill="none"
                                                                            xmlns="http://www.w3.org/2000/svg">
                                                                            <path
                                                                                d="M5.20833 2.58325C4.05937 2.58325 3.125 3.51763 3.125 4.66659V17.1666C3.125 18.3155 4.05937 19.2499 5.20833 19.2499H8.94375L12.5 22.8062L16.0562 19.2499H19.7917C20.9406 19.2499 21.875 18.3155 21.875 17.1666V4.66659C21.875 3.51763 20.9406 2.58325 19.7917 2.58325H5.20833ZM19.7917 17.1666H15.1938L12.5 19.8603L9.80625 17.1666H5.20833V4.66659H19.7917V17.1666Z"
                                                                                fill="#222222" />
                                                                            <path
                                                                                d="M7.29102 7.79175H17.7077V9.87508H7.29102V7.79175ZM7.29102 11.9584H14.5827V14.0417H7.29102V11.9584Z"
                                                                                fill="#222222" />
                                                                        </svg>

                                                                        <span id="comment-count-${post.id}">${formatCount(post.comments.length)}</span> Comments</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div id="post-${post.id}" class="person-comments-section">

                                                        ${commentSection}
                                                        ${moreComments}

                                                        ${post.comments.length > 1 ? '<button id="toggleBtn" onclick="toggleComments(' + post.id + ', this)" class="show-more">See More...</button>' : ''}
                                                </div>
                                            </div>
                                        `);
                                        })

                                        currentPage += 1;
                                        if (currentPage >= lastPage) {
                                            document.getElementById('load-more').style.display = 'none';
                                        }
                                    }

                                } else {
                                    document.getElementById('load-more').style.display = 'none';
                                }

                            },
                            error: function(xhr) {
                                $('#loading-spinner').hide();
                                alert('An error occurred while loading more posts.');
                            }
                        });
                    }

                    function likePost(postId, button) {
                        // Save current button
                        var button = button;

                        // Get the current like count from the DOM
                        const likeCountElement = document.getElementById("like-count-" + postId);
                        let currentLikeCount = parseInt(likeCountElement.textContent) || 0;

                        $.ajax({
                            url: `/like/${postId}`,
                            type: 'POST',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                // Immediately update the UI for the user
                                if (response.liked == true) {
                                    button.classList.add('liked');
                                    currentLikeCount++; // Increment the like count
                                } else {
                                    button.classList.remove('liked');
                                    currentLikeCount--; // Decrement the like count
                                }
                                likeCountElement.textContent = formatCount(currentLikeCount);
                            },
                            error: function(xhr) {
                                alert('An error occurred while liking/unliking the post.');
                            }
                        });
                    }


                    function addComment(postId, element) {
                        const parentBox = $(element).closest('.comment-input-box');
                        const content = parentBox.find("#commentInput").val();

                        $.ajax({
                            url: `/comment/${postId}`, // Post comment endpoint
                            type: 'POST',
                            data: {
                                content: content,
                                post_id: postId,
                                _token: '{{ csrf_token() }}' // Add CSRF token for Laravel
                            },
                            success: function(response) {
                                // Clear the input field after submitting the comment
                                parentBox.find("#commentInput").val('');
                                $("#comment-count-" + postId).text(response.count);
                            },
                            error: function(xhr) {
                                alert('An error occurred while submitting the comment.');
                            }
                        });
                    }

                    $(document).on('click', '.btn-primary[data-toggle="modal"]', function() {
                        const commentElement = $(this).closest('.person-comment-content');
                        const commentText = commentElement.find('.content-area-comment p').text();
                        const commentId = $(this).data('comment-id'); // Get comment ID from button's data attributes

                        $('#editCommentInput').val(commentText); // Set the current comment text in the modal
                        $('#commentId').val(commentId); // Set the comment ID in a hidden input field

                        // Open the modal
                        $('#exampleModal').modal('show');
                    });

                    $('#editCommentForm').on('submit', function(event) {
                        event.preventDefault(); // Prevent the form from submitting the default way

                        const commentId = $('#commentId').val(); // Get the comment ID
                        const updatedContent = $('#editCommentInput').val(); // Get the updated comment text

                        const updateUrl = `{{ route('comment.update', ':id') }}`.replace(':id', commentId); // Create the URL
                        $.ajax({
                            url: updateUrl,
                            type: 'POST', // Change this to your appropriate method (e.g., PATCH)
                            data: {
                                content: updatedContent,
                                _token: '{{ csrf_token() }}' // CSRF token for Laravel
                            },
                            success: function(response) {

                                // Update the comment text in the UI
                                const commentElement = $(`.delete-comment[data-comment-id="${commentId}"]`).closest(
                                    '.person-comment-content');
                                commentElement.find('.content-area-comment p').text(updatedContent);

                                // Close the modal
                                // $('#exampleModal').modal('hide');
                                $('#exampleModal button[data-dismiss="modal"], .close').click();


                                // Optionally show a success message
                                Swal.fire("Updated!", "Your comment has been updated.", "success");
                            },
                            error: function(xhr) {
                                Swal.fire("Error!", "An error occurred while updating the comment.", "error");
                            }
                        });
                    });

                    $(document).on('click', '#exampleModal button[data-dismiss="modal"], .close', function() {
                        $('#exampleModal').modal('hide'); // Ensure the modal is hidden
                    });

                    $('#exampleModal').on('hidden.bs.modal', function() {
                        // Reset any values in the modal
                        $(this).find('textarea').val(''); // Clear textarea if needed
                    });

                    $(document).on('click', '.delete-comment', function() {
                        const deleteUrl = `{{ route('comment.delete', ':id') }}`;
                        const finalUrl = deleteUrl.replace(':id', $(this).data('comment-id'));
                        const commentElement = $(this).closest('.person-comment-content');
                        const commentId = $(this).data('comment-id');
                        const anothercommentElement = $("#parent-comment-box-in-box-" + commentId);

                        // SweetAlert for confirmation
                        Swal.fire({
                            title: "Are you sure?",
                            text: "Once deleted, you will not be able to recover this comment!",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonText: 'Yes, delete it!',
                            cancelButtonText: 'No, keep it'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: finalUrl,
                                    type: 'POST',
                                    data: {
                                        _token: '{{ csrf_token() }}'
                                    },
                                    success: function(response) {
                                        commentElement.remove(); // Remove the comment from the DOM
                                        if (anothercommentElement.length > 0) {
                                            anothercommentElement.remove();
                                        }
                                        Swal.fire("Deleted!", "Comment deleted successfully!", "success");
                                        $("#comment-count-" + response.post.id).text(response.count);
                                    },
                                    error: function(xhr) {
                                        Swal.fire("Error!", "An error occurred while deleting the comment.",
                                            "error");
                                    }
                                });
                            } else {
                                Swal.fire("Cancelled", "Your comment is safe!", "info");
                            }
                        });
                    });

                    $(document).ready(function() {

                        loadPosts('latest');
                        Pusher.logToConsole = false;

                        var pusher = new Pusher('3af0341c542582fe2550', {
                            cluster: "ap2",
                            encrypted: false,
                            useTls: true,
                        });

                        var postChannel = pusher.subscribe('community-feed');
                        var commentChannel = pusher.subscribe('comment-channel');
                        var likeChannel = pusher.subscribe('like-channel');
                        var postDeleteChannel = pusher.subscribe('post-delete-channel');

                        postDeleteChannel.bind('post-delete-event', function(data) {
                            if (data.postId) {
                                const postElement = document.getElementById("post-box-" + data.postId);
                                if (postElement) {
                                    postElement.remove();
                                }
                            }
                        });

                        likeChannel.bind('like-added', function(data) {
                            if (data.post.commentId) {
                                if ($('#CommentsModal').hasClass('show')) {
                                    const button = document.getElementById(`comment-like-count-${data.post.commentId}`);

                                    if (button) {
                                        button.innerHTML = formatCount(data.post.count);
                                    } else {
                                        console.error(`Element with ID comment-like-count-${data.post.commentId} not found.`);
                                    }
                                }
                            } else {
                                const button = document.querySelector(`button[data-post-id="${data.post.postId}"]`);
                                const likeCountElement = document.getElementById("like-count-" + data.post.postId);
                                likeCountElement.textContent = formatCount(data.post.count);
                            }

                        });

                        commentChannel.bind('comment-added', function(data) {
                            $("#comment-count-" + data.comment.post_id).text(data.comment.count);

                            if (data.comment.count == 1) {
                                let commentSection = '';
                                let firstComment = data.comment;
                                let img = firstComment.user.image;
                                let canDeleteComment = firstComment.user_id == currentUserId || isAdmin;
                                let canEditComment = firstComment.user_id == currentUserId;
                                commentSection += `
                                                <div class="person-comment-content" id="parent-comment-box-in-box-${firstComment.id}">
                                                    <div class="person-comment-box">
                                                        <div class="img-box">
                                                            <div class="img">
                                                                <img ${img ? `src="{{ Storage::url('${img}') }}"` : 'src="{{ asset('assets/images/tony-stark-img.png') }}"'} width="100%" height="40px" alt="">
                                                            </div>
                                                            <div class="content-name">
                                                                <h6>${firstComment.user.name} <span style="font-size: 10px; font-weight: 400; color: #777777;">&nbsp | ${timeAgo(firstComment.created_at)}</span></h6>
                                                                <h5>${firstComment.user.email}</h5>
                                                            </div>
                                                        </div>
                                                        <div class="two-btns-inline">
                                                            ${canEditComment ? `
                                                            <button type="button" class="btn btn-primary" data-comment-id="${firstComment.id}" data-toggle="modal"
                                                                data-target="#exampleModal"><svg width="20" height="19"
                                                                    viewBox="0 0 20 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M15.2451 1.63672L17.5293 3.9209L15.788 5.66297L13.5038 3.37879L15.2451 1.63672ZM6.87891 12.2871H9.16309L14.7114 6.73882L12.4272 4.45464L6.87891 10.0029V12.2871Z"
                                                                        fill="white"></path>
                                                                    <path
                                                                        d="M15.2526 14.5715H6.99758C6.97778 14.5715 6.95723 14.5791 6.93743 14.5791C6.91231 14.5791 6.88718 14.5722 6.86129 14.5715H4.5931V3.91195H9.80636L11.3291 2.38916H4.5931C3.75328 2.38916 3.07031 3.07137 3.07031 3.91195V14.5715C3.07031 15.412 3.75328 16.0942 4.5931 16.0942H15.2526C15.6565 16.0942 16.0438 15.9338 16.3294 15.6482C16.615 15.3627 16.7754 14.9753 16.7754 14.5715V7.9717L15.2526 9.49449V14.5715Z"
                                                                        fill="white"></path>
                                                                </svg>
                                                                Edit</button> ` : ''}
                                                            ${canDeleteComment ? `
                                                            <button type="button" class="delete-comment" data-comment-id="${firstComment.id}"><svg width="19" height="19" viewBox="0 0 19 19" fill="none"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M4.3154 15.331C4.3154 15.7348 4.4758 16.1221 4.76131 16.4076C5.04682 16.6931 5.43406 16.8535 5.83784 16.8535H13.45C13.8538 16.8535 14.241 16.6931 14.5265 16.4076C14.812 16.1221 14.9724 15.7348 14.9724 15.331V6.19645H16.4949V4.67402H13.45V3.15158C13.45 2.74781 13.2896 2.36057 13.0041 2.07506C12.7186 1.78955 12.3313 1.62915 11.9276 1.62915H7.36027C6.95649 1.62915 6.56926 1.78955 6.28375 2.07506C5.99823 2.36057 5.83784 2.74781 5.83784 3.15158V4.67402H2.79297V6.19645H4.3154V15.331ZM7.36027 3.15158H11.9276V4.67402H7.36027V3.15158ZM6.59905 6.19645H13.45V15.331H5.83784V6.19645H6.59905Z"
                                                                        fill="white"></path>
                                                                    <path
                                                                        d="M7.35938 7.71899H8.88181V13.8087H7.35938V7.71899ZM10.4042 7.71899H11.9267V13.8087H10.4042V7.71899Z"
                                                                        fill="white"></path>
                                                                </svg> Delete</button>` : ''}
                                                            </div>
                                                    </div>
                                                    <div class="content-area-comment">
                                                        <p>${firstComment.comment}</p>
                                                    </div>
                                                </div>
                                                `;

                                $("#post-" + firstComment.post_id).append(commentSection);
                            }

                            if (data.comment.isReply == true) {
                                $("#reply-count-" + data.comment.parent_id).text("(" + data.comment.replyCount + ")");
                                const dynamicRepliesContainer = document.querySelector(
                                    `#comment-${data.comment.parent_id} .dynamic-replies`);
                                const newReplyHTML = renderComments([data
                                    .comment
                                ]);
                                dynamicRepliesContainer.innerHTML += newReplyHTML;

                            } else {
                                if ($('#CommentsModal').hasClass('show')) {
                                    const commentsContainer = $('#comments-container');
                                    commentsContainer.append(renderComments([data.comment]));
                                }
                            }
                        });



                        postChannel.bind('post-created', function(data) {
                            if (data.post) {
                                let post = data.post;

                                let imageSection = '';
                                let videoSection = '';
                                let commentSection = '';
                                let moreComments = '';

                                if (post.images) {
                                    post.images.forEach(image => {
                                        imageSection += `
                                            <div class="box imge video">
                                                    <img src="{{ Storage::url('${image.path}') }}" width="100px" height="100px" alt="" >
                                            </div>
                                        `;
                                    });
                                }

                                if (post.videos) {
                                    post.videos.forEach(video => {
                                        videoSection += `
                                            <div class="box imge video">
                                                <video poster="{{ Storage::url('${video.path}') }}" controls preload="none">
                                                    <source src="{{ Storage::url('${video.path}') }}" type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>
                                            </div>
                                        `;
                                    });
                                }

                                const contentLimit = 300;
                                const isLongContent = post.content.length > contentLimit;
                                const truncatedContent = isLongContent ? post.content.substring(0, contentLimit) + '...' : post.content;

                                const likedStyle = post.hasLiked ? "liked" : "";
                                const image = post.user.image;
                                const canDeletePost = isAdmin || post.user_id == currentUserId;

                                $("#post-detaling").prepend(`
                                            <div class="shadow-box post-detaling" id="post-box-${post.id}">
                                                <div class="main-admin-blog">
                                                        <div class="parent-person-box">
                                                            <div class="person-details">
                                                                <img ${image ? `src="{{ Storage::url('${image}') }}"` : 'src="{{ asset('assets/images/tony-stark-img.png') }}"'} alt="">
                                                                <div class="content">
                                                                    <h6>${post.user.name}</h6>
                                                                    <h5>${post.user.email}</h5>
                                                                </div>
                                                            </div>
                                                            <div class="person-details-date">
                                                                <h4>${timeAgo(post.created_at)}</h4>
                                                                ${canDeletePost ? `
                                                                <button class="btn btn-danger" onclick="deletePost(${post.id})">Delete
                                                                    <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M5.20833 20.8334C5.20833 21.3859 5.42783 21.9158 5.81853 22.3065C6.20923 22.6972 6.73913 22.9167 7.29167 22.9167H17.7083C18.2609 22.9167 18.7908 22.6972 19.1815 22.3065C19.5722 21.9158 19.7917 21.3859 19.7917 20.8334V8.33337H21.875V6.25004H17.7083V4.16671C17.7083 3.61417 17.4888 3.08427 17.0981 2.69357C16.7074 2.30287 16.1775 2.08337 15.625 2.08337H9.375C8.82247 2.08337 8.29256 2.30287 7.90186 2.69357C7.51116 3.08427 7.29167 3.61417 7.29167 4.16671V6.25004H3.125V8.33337H5.20833V20.8334ZM9.375 4.16671H15.625V6.25004H9.375V4.16671ZM8.33333 8.33337H17.7083V20.8334H7.29167V8.33337H8.33333Z" fill="#222222"/>
                                                                    <path d="M9.375 10.4166H11.4583V18.75H9.375V10.4166ZM13.5417 10.4166H15.625V18.75H13.5417V10.4166Z" fill="#222222"/></button>
                                                                ` : ''}
                                                            </div>
                                                        </div>
                                                        <div class="detalingsread-more">
                                                            <div class="content">
                                                                <p>
                                                                    <span class="less-text">${truncatedContent}
                                                                    </span> <span class="more-text" style="display:none;">${post.content}</span>
                                                                    ${isLongContent ? '<a href="javascript:void(0);" class="read-more-btn" onclick="toggleText(this)">Read more...</a>' : ''}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="scroll-full-box">
                                                            ${imageSection}
                                                            ${videoSection}
                                                        </div>
                                                        <div class="comment-input-box">
                                                            <div class="box input-box">
                                                                    <input type="text" id="commentInput" placeholder="What’s on your mind?">
                                                                    <button onclick="addComment(${post.id}, this)">Comment</button>
                                                            </div>
                                                            <div class="two-btns-inline">
                                                                <div class="box like-btn">
                                                                    <button id="likeButton" class="${likedStyle}" onclick="likePost(${post.id}, this)" data-post-id="${post.id}">
                                                                        <svg width="25" height="26" viewBox="0 0 25 26" fill="none"
                                                                            xmlns="http://www.w3.org/2000/svg">
                                                                            <path
                                                                                d="M20.834 8.83325H14.9882L16.1579 5.32596C16.3684 4.69263 16.2621 3.99054 15.8715 3.44888C15.4809 2.90721 14.8475 2.58325 14.1798 2.58325H12.5007C12.1913 2.58325 11.8986 2.72075 11.6996 2.95825L6.80378 8.83325H4.16732C3.01836 8.83325 2.08398 9.76763 2.08398 10.9166V20.2916C2.08398 21.4405 3.01836 22.3749 4.16732 22.3749H18.0288C18.4526 22.3735 18.8661 22.2435 19.2144 22.0021C19.5628 21.7607 19.8297 21.4192 19.9798 21.0228L22.8517 13.3655C22.8953 13.2486 22.9175 13.1247 22.9173 12.9999V10.9166C22.9173 9.76763 21.9829 8.83325 20.834 8.83325ZM4.16732 10.9166H6.25065V20.2916H4.16732V10.9166ZM20.834 12.8114L18.0288 20.2916H8.33398V10.252L12.9882 4.66659H14.1819L12.5548 9.54471C12.502 9.70129 12.4873 9.8682 12.5118 10.0316C12.5364 10.195 12.5996 10.3502 12.6961 10.4843C12.7927 10.6185 12.9198 10.7276 13.067 10.8028C13.2141 10.878 13.3771 10.917 13.5423 10.9166H20.834V12.8114Z"
                                                                                fill="#222222" />
                                                                        </svg>
                                                                        <span id="like-count-${post.id}">0</span> Likes
                                                                    </button>
                                                                </div>
                                                                <div class="box like-btn">
                                                                    <button id="commentButton" onclick="showCommentsModal(${post.id}, this)"><svg width="25" height="26" viewBox="0 0 25 26" fill="none"
                                                                            xmlns="http://www.w3.org/2000/svg">
                                                                            <path
                                                                                d="M5.20833 2.58325C4.05937 2.58325 3.125 3.51763 3.125 4.66659V17.1666C3.125 18.3155 4.05937 19.2499 5.20833 19.2499H8.94375L12.5 22.8062L16.0562 19.2499H19.7917C20.9406 19.2499 21.875 18.3155 21.875 17.1666V4.66659C21.875 3.51763 20.9406 2.58325 19.7917 2.58325H5.20833ZM19.7917 17.1666H15.1938L12.5 19.8603L9.80625 17.1666H5.20833V4.66659H19.7917V17.1666Z"
                                                                                fill="#222222" />
                                                                            <path
                                                                                d="M7.29102 7.79175H17.7077V9.87508H7.29102V7.79175ZM7.29102 11.9584H14.5827V14.0417H7.29102V11.9584Z"
                                                                                fill="#222222" />
                                                                        </svg>

                                                                        <span id="comment-count-${post.id}">${post.comments.length}</span> Comments</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="post-${post.id}" class="person-comments-section">
                                                        ${commentSection}
                                                        ${moreComments}
                                                        ${post.comments.length > 1 ? '<button id="toggleBtn" onclick="toggleComments(' + post.id + ', this)" class="show-more">See More...</button>' : ''}
                                                </div>
                                            </div>
                                    `);
                            }
                        });

                    });

                    // -- JS for frontend -- //
                    document.getElementById('latest-btn').addEventListener('click', function() {
                        currentPage = 0;
                        lastPage = 0;
                        $("#post-detaling").html('');
                        this.classList.add('active');
                        document.getElementById('hot-btn').classList.remove('active');
                        document.getElementById('popular-btn').classList.remove('active');
                        loadPosts('latest');
                        $("#load-more").show();
                    });

                    document.getElementById('popular-btn').addEventListener('click', function() {
                        currentPage = 0;
                        lastPage = 0;
                        $("#post-detaling").html('');
                        this.classList.add('active');
                        document.getElementById('hot-btn').classList.remove('active');
                        document.getElementById('latest-btn').classList.remove('active');
                        loadPosts('popular');
                        $("#load-more").show();
                    });

                    document.getElementById('hot-btn').addEventListener('click', function() {
                        currentPage = 0;
                        lastPage = 0;
                        $("#post-detaling").html('');

                        this.classList.add('active');
                        document.getElementById('popular-btn').classList.remove('active');
                        document.getElementById('latest-btn').classList.remove('active');
                        loadPosts('hot');
                        $("#load-more").show();
                    });


                    function toggleText(button) {
                        const paragraph = button.parentElement;
                        const moreText = paragraph.querySelector('.more-text');
                        const lessText = paragraph.querySelector('.less-text');

                        if (moreText.style.display === "none") {
                            moreText.style.display = "inline";
                            lessText.style.display = "none";
                            button.innerText = "Read less...";
                        } else {
                            moreText.style.display = "none";
                            lessText.style.display = "inline";
                            button.innerText = "Read more...";
                        }
                    }

                    $("#likeButton").on('click', function() {
                        $(this).toggleClass('liked');
                    });

                    function toggleComments(id, button) {
                        showCommentsModal(id, button);
                    }

                    function showCommentsModal(postId, element) {
                        $("#CommentsModal").modal("show");

                        $.ajax({
                            url: `{{ route('comment.get') }}`,
                            type: 'post',
                            data: {
                                _token: '{{ csrf_token() }}',
                                id: postId
                            },
                            success: function(response) {
                                $("#comments-container").empty();
                                if (response.data.length > 0 && response.data[0].comments) {
                                    let commentSection = renderComments(response.data[0].comments);
                                    $("#comments-container").append(commentSection);
                                } else {
                                    $("#comments-container").append(`<p class="no-comments">No comments found</p>`);
                                }
                            },
                            error: function(xhr) {
                                console.log(xhr);
                            }
                        });
                    }

                    function renderComments(comments = [], level = 0) {
                        return comments.map(comment => {
                            let img = comment.user.image;
                            let canDeleteComment = comment.user.id == currentUserId || isAdmin;
                            let canEditComment = comment.user.id == currentUserId;
                            let hasLiked = comment.hasLiked ? 'like-class-parent' : '';
                            let likeCount = comment.likeCount || 0;
                            let commentClass = comment.parent_id === null ? 'person-comment-content-parent' : '';
                            let commentId = `comment-${comment.id}`;

                            let commentHTML = `
                                <div class="person-comment-content ${commentClass}" id="parent-comment-box-${comment.id}">
                                    <div class="person-comment-box">
                                        <div class="img-box">
                                            <div class="img">
                                                <img ${img ? `src="{{ Storage::url('${img}') }}"` : 'src="{{ asset('assets/images/tony-stark-img.png') }}"'} width="100%" height="40px" alt="">
                                            </div>
                                            <div class="content-name">
                                                <h6>${comment.user.name} <span style="font-size: 10px; font-weight: 400; color: #777777;">&nbsp | ${timeAgo(comment.created_at)}</span></h6>
                                                <h5>${comment.user.email}</h5>
                                            </div>
                                        </div>
                                        <div class="two-btns-inline">
                                            ${canEditComment ? `<button type="button" class="btn btn-primary" data-comment-id="${comment.id}" data-toggle="modal" data-target="#exampleModal">
                                                                <svg width="20" height="19"
                                                                    viewBox="0 0 20 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M15.2451 1.63672L17.5293 3.9209L15.788 5.66297L13.5038 3.37879L15.2451 1.63672ZM6.87891 12.2871H9.16309L14.7114 6.73882L12.4272 4.45464L6.87891 10.0029V12.2871Z"
                                                                        fill="white"></path>
                                                                    <path
                                                                        d="M15.2526 14.5715H6.99758C6.97778 14.5715 6.95723 14.5791 6.93743 14.5791C6.91231 14.5791 6.88718 14.5722 6.86129 14.5715H4.5931V3.91195H9.80636L11.3291 2.38916H4.5931C3.75328 2.38916 3.07031 3.07137 3.07031 3.91195V14.5715C3.07031 15.412 3.75328 16.0942 4.5931 16.0942H15.2526C15.6565 16.0942 16.0438 15.9338 16.3294 15.6482C16.615 15.3627 16.7754 14.9753 16.7754 14.5715V7.9717L15.2526 9.49449V14.5715Z"
                                                                        fill="white"></path>
                                                                </svg>

                                                                </button>` : ''}
                                            ${canDeleteComment ? `<button type="button" class="delete-comment" data-comment-id="${comment.id}">
                                                                <svg width="19" height="19" viewBox="0 0 19 19" fill="none"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M4.3154 15.331C4.3154 15.7348 4.4758 16.1221 4.76131 16.4076C5.04682 16.6931 5.43406 16.8535 5.83784 16.8535H13.45C13.8538 16.8535 14.241 16.6931 14.5265 16.4076C14.812 16.1221 14.9724 15.7348 14.9724 15.331V6.19645H16.4949V4.67402H13.45V3.15158C13.45 2.74781 13.2896 2.36057 13.0041 2.07506C12.7186 1.78955 12.3313 1.62915 11.9276 1.62915H7.36027C6.95649 1.62915 6.56926 1.78955 6.28375 2.07506C5.99823 2.36057 5.83784 2.74781 5.83784 3.15158V4.67402H2.79297V6.19645H4.3154V15.331ZM7.36027 3.15158H11.9276V4.67402H7.36027V3.15158ZM6.59905 6.19645H13.45V15.331H5.83784V6.19645H6.59905Z"
                                                                        fill="white"></path>
                                                                    <path
                                                                        d="M7.35938 7.71899H8.88181V13.8087H7.35938V7.71899ZM10.4042 7.71899H11.9267V13.8087H10.4042V7.71899Z"
                                                                        fill="white"></path>
                                                                </svg>
                                                                </button>` : ''}
                                            <button class="${hasLiked} modal-like-btn" onclick="likeComment(${comment.id}, this)" id="comment-like-btn-${comment.id}">
                                                <svg width="20" height="20" viewBox="0 0 25 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M20.834 8.83325H14.9882L16.1579 5.32596C16.3684 4.69263 16.2621 3.99054 15.8715 3.44888C15.4809 2.90721 14.8475 2.58325 14.1798 2.58325H12.5007C12.1913 2.58325 11.8986 2.72075 11.6996 2.95825L6.80378 8.83325H4.16732C3.01836 8.83325 2.08398 9.76763 2.08398 10.9166V20.2916C2.08398 21.4405 3.01836 22.3749 4.16732 22.3749H18.0288C18.4526 22.3735 18.8661 22.2435 19.2144 22.0021C19.5628 21.7607 19.8297 21.4192 19.9798 21.0228L22.8517 13.3655C22.8953 13.2486 22.9175 13.1247 22.9173 12.9999V10.9166C22.9173 9.76763 21.9829 8.83325 20.834 8.83325ZM4.16732 10.9166H6.25065V20.2916H4.16732V10.9166ZM20.834 12.8114L18.0288 20.2916H8.33398V10.252L12.9882 4.66659H14.1819L12.5548 9.54471C12.502 9.70129 12.4873 9.8682 12.5118 10.0316C12.5364 10.195 12.5996 10.3502 12.6961 10.4843C12.7927 10.6185 12.9198 10.7276 13.067 10.8028C13.2141 10.878 13.3771 10.917 13.5423 10.9166H20.834V12.8114Z" fill="#222222"/>
                                                </svg>
                                                <span id="comment-like-count-${comment.id}">${formatCount(likeCount)}</span>
                                            </button>
                                            <button onclick="toggleReplies('${commentId}', this)">
                                                <svg class="icon-toggle" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path class="arrow-icon" d="M7 10l5 5 5-5H7z" fill="#222222"/> <!-- Down arrow icon -->
                                                </svg>
                                                <span id="reply-count-${comment.id}" data-count="${comment.replies.length}">
                                                    ${comment.replies.length > 0 ? `(${comment.replies.length})` : ''}
                                                </span>
                                            </button>

                                        </div>
                                    </div>
                                    <div class="content-area-comment">
                                        <p>${comment.comment}</p>
                                    </div>
                                    <div class="reply-box" style="display: none;" id="${commentId}"> <!-- Hidden by default -->
                                        <input type="text" id="replyInput-${comment.id}" placeholder="Write a reply..." />
                                        <button onclick="addReply(${comment.id}, ${comment.post_id})">Reply</button>
                                        <!-- This is where replies will be rendered dynamically -->
                                        <div class="dynamic-replies">
                                            ${renderComments(comment.replies || [], level + 1)} <!-- Recursively render replies -->
                                        </div>
                                    </div>
                                </div>`;
                            return commentHTML;
                        }).join('');
                    }
                    function toggleReplies(commentId, button) {
                        const replyBox = document.getElementById(commentId);
                        const icon = button.querySelector('.icon-toggle');

                        if (replyBox.style.display === 'none' || replyBox.style.display === '') {
                            replyBox.style.display = 'block';
                            icon.innerHTML = `
                                <path class="arrow-icon" d="M7 14l5-5 5 5H7z" fill="#222222"/> <!-- Up arrow icon -->
                            `;
                        } else {
                            replyBox.style.display = 'none';
                            icon.innerHTML = `
                                <path class="arrow-icon" d="M7 10l5 5 5-5H7z" fill="#222222"/> <!-- Down arrow icon -->
                            `;
                        }
                    }

                    function likeComment(commentId, element) {
                        $.ajax({
                            type: 'POST',
                            url: `/comment/like`,
                            data: {
                                _token: '{{ csrf_token() }}',
                                comment_id: commentId
                            },
                            success: function(response) {
                                if (response.success) {
                                    let currentText = $(element).text();
                                    let likeCount = response.likeCount;
                                    if (response.liked) {
                                        $(element).addClass('like-class-parent');
                                    } else {
                                        $(element).removeClass('like-class-parent');
                                    }
                                    $(element).html(`
                                    <svg width="20" height="20" viewBox="0 0 25 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M20.834 8.83325H14.9882L16.1579 5.32596C16.3684 4.69263 16.2621 3.99054 15.8715 3.44888C15.4809 2.90721 14.8475 2.58325 14.1798 2.58325H12.5007C12.1913 2.58325 11.8986 2.72075 11.6996 2.95825L6.80378 8.83325H4.16732C3.01836 8.83325 2.08398 9.76763 2.08398 10.9166V20.2916C2.08398 21.4405 3.01836 22.3749 4.16732 22.3749H18.0288C18.4526 22.3735 18.8661 22.2435 19.2144 22.0021C19.5628 21.7607 19.8297 21.4192 19.9798 21.0228L22.8517 13.3655C22.8953 13.2486 22.9175 13.1247 22.9173 12.9999V10.9166C22.9173 9.76763 21.9829 8.83325 20.834 8.83325ZM4.16732 10.9166H6.25065V20.2916H4.16732V10.9166ZM20.834 12.8114L18.0288 20.2916H8.33398V10.252L12.9882 4.66659H14.1819L12.5548 9.54471C12.502 9.70129 12.4873 9.8682 12.5118 10.0316C12.5364 10.195 12.5996 10.3502 12.6961 10.4843C12.7927 10.6185 12.9198 10.7276 13.067 10.8028C13.2141 10.878 13.3771 10.917 13.5423 10.9166H20.834V12.8114Z" fill="#222222"/>
                                    </svg>
                                    <span id="comment-like-count-${commentId}">${formatCount(likeCount)}</span>`);
                                }
                            },
                            error: function(error) {
                                console.error('Error liking comment:', error);
                            }
                        });
                    }

                    function addReply(parentId, postId) {
                        const replyInput = document.getElementById(`replyInput-${parentId}`);
                        const replyText = replyInput.value;
                        if (replyText.trim() === '') {
                            alert('Reply cannot be empty!');
                            return;
                        }
                        $.ajax({
                            type: 'POST',
                            url: '/comments/add',
                            data: {
                                _token: '{{ csrf_token() }}',
                                post_id: postId,
                                parent_id: parentId,
                                comment: replyText
                            },
                            success: function(response) {
                                replyInput.value = '';
                                $("#comment-count-" + postId).text(response.count);
                                var replyCount = $("#reply-count-" + parentId).data("count");
                                replyCount++;
                                $("#reply-count-" + parentId).text("(" + replyCount + ")");
                            },
                            error: function(error) {
                                console.error('Error adding reply:', error);
                            }
                        });
                    }

                    function deletePost(id) {
                        Swal.fire({
                            title: 'Are you sure?',
                            text: "You won't be able to revert this!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, delete it!',
                            cancelButtonText: 'No, cancel!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    type: 'POST',
                                    url: '/posts/delete',
                                    data: {
                                        _token: '{{ csrf_token() }}',
                                        post_id: id
                                    },
                                    success: function(response) {
                                        Swal.fire(
                                            'Deleted!',
                                            'Your post has been deleted.',
                                            'success'
                                        );
                                        currentPage = 0;
                                        lastPage = 0;
                                        $("#post-detaling").empty();
                                        loadPosts('latest');
                                        $("#load-more").show();
                                    },
                                    error: function(error) {
                                        Swal.fire(
                                            'Error!',
                                            'There was an issue deleting your post.',
                                            'error'
                                        );
                                        console.error('Error deleting post:', error);
                                    }
                                });
                            } else {
                                Swal.fire(
                                    'Cancelled',
                                    'Your post is safe :)',
                                    'info'
                                );
                            }
                        });
                    }
                    function closeCommentsModal() {
                        $("#CommentsModal").modal("hide");
                    }
                    // -- JS for backend -- //
                </script>
            @endsection
